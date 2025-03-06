export const useDataStore = defineStore("data", () => {
  const globalData = ref(<GlobalData | null>{});
  return {
    globalData,
  };
});
