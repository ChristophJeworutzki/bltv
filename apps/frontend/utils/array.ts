export function chunkArray<T>(array: T[], chunkSize: number): T[][] {
  if (chunkSize <= 0) {
    throw new Error("Chunk size must be greater than 0");
  }
  const result: T[][] = new Array(Math.ceil(array.length / chunkSize));
  for (let i = 0; i < result.length; i++) {
    result[i] = array.slice(i * chunkSize, (i + 1) * chunkSize);
  }
  return result;
}
