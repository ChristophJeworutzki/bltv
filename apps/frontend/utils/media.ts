export function getMediaOrientation(media: Media) {
  if (media.type === "image" && media.image) {
    return media.image.orientation;
  } else if (media.type === "video" && media.video) {
    return media.video.orientation;
  }
}

export function getMediaAspectRatio(media: Media) {
  if (media.type === "image" && media.image) {
    return media.image.aspectRatio;
  } else if (media.type === "video" && media.video) {
    return media.video.aspectRatio;
  }
}

export function getCssMediaAspectRatio(media: Media) {
  const aspectRatio = getMediaAspectRatio(media);
  if (aspectRatio) {
    const ratio = aspectRatio.split(":");
    return `${ratio[0]}/${ratio[1]}`;
  }
}

export function convertAspectRatioToCss(aspectRatio: string) {
  if (!aspectRatio && aspectRatio.indexOf(":") === -1) {
    return;
  }
  const ratio = aspectRatio.split(":");
  return `${ratio[0]}/${ratio[1]}`;
}
