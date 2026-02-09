export interface FeaturedProductItem {
  id?: number;
  slug: string;
  excerpt: string;
  description: string;
  image_uri: string;
  caption_image: string;
  product: {
    name: string;
    slug: string;
  }
}

export type FeaturedProductItems = FeaturedProductItem[];