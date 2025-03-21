export const useAppStore = defineStore("app", () => {
  const menuOpen = ref(false);

  return {
    menuOpen,
  };
});
