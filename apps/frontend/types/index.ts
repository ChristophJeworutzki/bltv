declare global {
  interface Rect {
    x: number;
    y: number;
    w: number;
    h: number;
  }

  interface Attachment {
    id: string;
    title: string;
    type: string;
    mimeType: string;
    url: string;
    alt: string;
    caption: string;
    description: string;
  }

  interface Image extends Attachment {
    aspectRatio: string;
    orientation: "landscape" | "portrait";
    width: number;
    height: number;
  }

  interface Video extends Attachment {
    playbackId: string;
    width: number;
    height: number;
    duration: number;
    aspectRatio: string;
    orientation: "landscape" | "portrait";
    status: string;
    files: {
      [key: string]: {
        name?: string;
        extension?: string;
        height?: number;
        width?: number;
        bitrate?: number;
        filesize?: number;
        url: string;
      };
    };
    thumbnail: string;
    poster: string;
    meta: {
      controls: boolean;
    };
  }

  interface Audio extends Attachment {}

  interface Media {
    type: "image" | "video" | "audio";
    image?: Image;
    video?: Video;
    audio?: Audio;
  }

  interface Taxonomy {
    id: number;
    name: string;
    slug: string;
  }

  interface Post {
    type?: string;
    id: number;
    title: string;
    slug: string;
  }

  interface Link {
    type?: "post" | "url";
    value?: string;
    url?: string;
    name?: string;
    title?: string;
    target?: "_blank" | "_self";
    post_type?: string;
    slug?: string;
  }

  interface Credit {
    role: string;
    name: string;
  }

  interface Project extends Post {
    client?: string;
    preview?: Media[];
    gallery?: Media[];
    credits?: Credit[];
  }

  interface ProjectCollection {
    data: Project[];
  }

  interface Page extends Post {
    fields: Record<string, any>;
  }

  interface GlobalData {
    profile: {
      company: string;
      address: string;
      zip: string;
      city: string;
      country: string;
      email: string;
      instagram: string;
      linkedin: string;
      vimeo: string;
    };
    seo: {
      title: string;
      description: string;
      image: Image;
    };
  }
}
