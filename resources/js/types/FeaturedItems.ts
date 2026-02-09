export interface FeatureItem {
  id?: number;
  slug: string;
  caption_image: string;
  excerpt: string;
  image_uri: string;
  location: string;
  start_date: string;
  duration: string;
  service: {
    slug: string;
    name: string;
  };
}

export type FeatureItems = FeatureItem[];