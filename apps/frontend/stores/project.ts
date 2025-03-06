export const useProjectStore = defineStore("project", () => {
  const config = useRuntimeConfig();
  const baseUrl = config?.public?.api?.baseUrl;

  const isOpen = ref(false);
  const isPending = ref(false);
  const project = ref(<Project | undefined>undefined);

  async function fetchProject(slug: string) {
    isPending.value = true;
    const data = await $fetch<Project>(`/api/v1/projects/${slug}`, {
      baseURL: baseUrl,
    });
    project.value = data;
    isOpen.value = true;
    isPending.value = false;
  }

  return {
    isOpen,
    isPending,
    project,
    fetchProject,
  };
});
