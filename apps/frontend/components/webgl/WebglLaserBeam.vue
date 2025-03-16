<template>
  <canvas ref="canvasRef" class="h-full w-full"></canvas>
</template>

<script setup lang="ts">
import type {
  Scene,
  WebGLRenderer,
  OrthographicCamera,
  Mesh as ThreeMesh,
} from "three";

import { useWindowSize, useRafFn, useDebounceFn } from "@vueuse/core";

// Types
interface Config {
  xScale: number;
  yScale: number;
  speed: number;
  intensity: number;
  rotation: number;
}

// Props
interface Props {
  config?: Config;
}

const props = withDefaults(defineProps<Props>(), {
  config: (): Config => ({
    xScale: 2,
    yScale: 0.1,
    speed: 0.025,
    intensity: 0.125,
    rotation: 0,
  }),
});

// Refs
const canvasRef = ref<HTMLCanvasElement | null>(null);

// State
const stage = shallowRef<ReturnType<typeof createStage> | null>(null);
const mesh = shallowRef<ReturnType<typeof createMesh> | null>(null);

// Dynamically import modules
let THREE: any = null;

// Use window size
const { width: windowWidth, height: windowHeight } = useWindowSize();

// Shaders
const vertexShader = `
  attribute vec3 position;
  void main() {
      gl_Position = vec4(position, 1.0);
  }
`;

const fragmentShader = `
  precision highp float;
  uniform vec2 resolution;
  uniform float time;
  uniform float xScale;
  uniform float yScale;
  uniform float intensity;
  uniform float rotation;

  void main() {
      vec2 p = (gl_FragCoord.xy * 2.0 - resolution) / min(resolution.x, resolution.y);

      // Apply rotation to the coordinates
      float cosAngle = cos(rotation);
      float sinAngle = sin(rotation);
      vec2 rotatedP = vec2(
          p.x * cosAngle - p.y * sinAngle,
          p.x * sinAngle + p.y * cosAngle
      );

      // Fixed chromatic aberration amount
      float fixedDistortion = 0.05;
      float d = length(rotatedP) * fixedDistortion;

      float rx, gx, bx;
      float r, g, b;

      // Use base intensity directly
      float finalIntensity = intensity;

      // Use rotated coordinates but always calculate based on the vertical beam logic
      rx = rotatedP.x * (1.0 + d);
      gx = rotatedP.x;
      bx = rotatedP.x * (1.0 - d);

      r = finalIntensity / abs(rotatedP.y + sin((rx + time) * xScale) * yScale);
      g = finalIntensity / abs(rotatedP.y + sin((gx + time + 0.5) * xScale) * yScale);
      b = finalIntensity / abs(rotatedP.y + sin((bx + time + 1.0) * xScale) * yScale);

      // Add some additional effects
      float vignette = 1.0 - length(p) * 0.5;

      // Add glow effect
      float glow = 0.0;
      for(float i = 0.0; i < 5.0; i++) {
          float offset = i * 0.02;
          glow += finalIntensity * 0.2 / abs(rotatedP.y + offset + sin((rotatedP.x + time) * xScale) * yScale);
      }

      r += glow * 0.3 * vignette;
      g += glow * 0.1 * vignette;
      b += glow * 0.2 * vignette;

      gl_FragColor = vec4(r, g, b, 1.0);
  }
`;

const createStage = (canvas: HTMLCanvasElement) => {
  const renderParam = {
    clearColor: 0x000000,
    width: windowWidth.value,
    height: windowHeight.value,
  };

  const cameraParam = {
    left: -1,
    right: 1,
    top: 1,
    bottom: -1,
    near: 0,
    far: -1,
  };

  let scene: Scene | null = null;
  let camera: OrthographicCamera | null = null;
  let renderer: WebGLRenderer | null = null;
  let isInitialized = false;

  const setScene = (): void => {
    scene = new THREE.Scene();
  };

  const setRenderer = (): void => {
    renderer = new THREE.WebGLRenderer({
      canvas,
      antialias: true,
      alpha: true,
    });
    renderer?.setPixelRatio(window.devicePixelRatio);
    renderer?.setClearColor(new THREE.Color(renderParam.clearColor));
    renderer?.setSize(renderParam.width, renderParam.height);
  };

  const setCamera = (): void => {
    if (!isInitialized) {
      camera = new THREE.OrthographicCamera(
        cameraParam.left,
        cameraParam.right,
        cameraParam.top,
        cameraParam.bottom,
        cameraParam.near,
        cameraParam.far,
      );
    }

    if (!camera || !renderer) return;

    camera.updateProjectionMatrix();
    renderer?.setSize(windowWidth.value, windowHeight.value);
  };

  const render = (): void => {
    if (!scene || !camera || !renderer) return;
    renderer?.render(scene, camera);
  };

  const init = (): void => {
    setScene();
    setRenderer();
    setCamera();
    isInitialized = true;
  };

  const onResize = (): void => {
    setCamera();
  };

  return {
    init,
    render,
    onResize,
    getScene: () => scene as Scene,
  };
};

// Mesh class as composition functions
const createMesh = (
  canvas: HTMLCanvasElement,
  stageInstance: ReturnType<typeof createStage>,
) => {
  // Configuration object with defaults merged from props
  const config: Config = {
    ...props.config,
  };

  // Create a computed rotation value that converts degrees to radians
  const rotationRadians = computed(
    () => (props.config.rotation * Math.PI) / 180,
  );

  const uniforms = {
    resolution: { type: "v2", value: [canvas.width, canvas.height] },
    time: { type: "f", value: 0.0 },
    xScale: { type: "f", value: config.xScale },
    yScale: { type: "f", value: config.yScale },
    intensity: { type: "f", value: config.intensity },
    rotation: { type: "f", value: rotationRadians.value },
  };

  let meshInstance: ThreeMesh | null = null;

  const setMesh = (): void => {
    const position = [
      -1.0, -1.0, 0.0, 1.0, -1.0, 0.0, -1.0, 1.0, 0.0, 1.0, -1.0, 0.0, -1.0,
      1.0, 0.0, 1.0, 1.0, 0.0,
    ];

    const positions = new THREE.BufferAttribute(new Float32Array(position), 3);

    const geometry = new THREE.BufferGeometry();
    geometry.setAttribute("position", positions);

    const material = new THREE.RawShaderMaterial({
      vertexShader,
      fragmentShader,
      uniforms,
      side: THREE.DoubleSide,
    });

    meshInstance = new THREE.Mesh(geometry, material);
    if (meshInstance) {
      stageInstance.getScene().add(meshInstance);
    }
  };

  const updateUniforms = (): void => {
    // Update uniforms from config
    uniforms.xScale.value = config.xScale;
    uniforms.yScale.value = config.yScale;
    uniforms.intensity.value = config.intensity;
    uniforms.rotation.value = rotationRadians.value;
  };

  const render = (): void => {
    uniforms.time.value += config.speed;

    // Update resolution if canvas size changes
    uniforms.resolution.value = [canvas.width, canvas.height];
  };

  const init = (): void => {
    setMesh();
  };

  return {
    init,
    render,
    updateUniforms,
    config,
  };
};

// Animation loop
const { pause: stopAnimation, resume: startAnimation } = useRafFn(
  () => {
    if (stage.value && mesh.value) {
      stage.value.render();
      mesh.value.render();
    }
  },
  { immediate: false },
);

// Handle window resize
const handleResize = useDebounceFn(() => {
  if (!canvasRef.value) return;

  if (stage.value) {
    stage.value.onResize();
  }

  canvasRef.value.width = windowWidth.value;
  canvasRef.value.height = windowHeight.value;
}, 60);

// Clean up
const cleanUp = () => {
  stopAnimation();
  THREE = null;
  stage.value = null;
  mesh.value = null;
};

// Watch for window size changes
watch([windowWidth, windowHeight], handleResize);

onMounted(async () => {
  // Dynamically import THREE
  const threeModule = await import("three");
  THREE = threeModule;

  if (!canvasRef.value) return;

  // Create stage
  stage.value = createStage(canvasRef.value);
  stage.value.init();

  // Create mesh
  mesh.value = createMesh(canvasRef.value, stage.value);
  mesh.value.init();

  // Start animation
  startAnimation();
});

onBeforeUnmount(() => {
  // Clean up
  cleanUp();
});

// Watch for config changes from parent
watch(
  () => props.config,
  (newConfig) => {
    if (mesh.value && mesh.value.config) {
      Object.assign(mesh.value.config, newConfig);
      mesh.value.updateUniforms();
    }
  },
  { deep: true },
);
</script>
