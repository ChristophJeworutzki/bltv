export const useAppStore = defineStore("app", () => {
  const route = useRoute();
  const introSkipped = ref(route.name === "index");
  const introCompleted = ref(!introSkipped.value);
  const menuOpen = ref(false);

  return {
    introSkipped,
    introCompleted,
    menuOpen,
  };
});
