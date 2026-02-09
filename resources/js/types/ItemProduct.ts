import { PaginatedResponse } from "./Paginate";

export type unitsData = 'UNIDAD'| 'DOCENA'| 'GRAMOS'| 'LITROS';
export interface ItemProductItem {
  id?: number;
  product?: any;
  product_id: number | null;
  slug: string;
  description: string;
  excerpt: string;
  price: number;
  stock: number;
  image_uri: string | null;
  image_file?: File | null;
  caption_image: string | undefined;
  size: string;
  weight: string;
  color: string;
  unit: unitsData; 
  state?: boolean;
  featured?: boolean;
  errors?: any;
}

export type ItemProductIt = ItemProductItem[];

export type PaginatedItemProduct = PaginatedResponse<ItemProductItem>;