import { ItemProductItem } from "./ItemProduct";
import { PaginatedResponse } from "./Paginate";

export interface ProductItem {
  id?: number;
  name: string;
  slug: string;
  excerpt: string;
  description: string;
  image_uri: string;
  image_file?: File | null;
  caption_image: string;
  state?: boolean;
  items?: Array<ItemProductItem>;
  errors?: any;
}

export type Product = ProductItem[];
export type PaginatedProduct = PaginatedResponse<ProductItem>