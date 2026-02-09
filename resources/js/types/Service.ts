import { ItemServiceItem } from "./ItemService";
import { PaginatedResponse } from "./Paginate";

export interface ServiceItem {
  id?: number;
  name: string;
  slug: string;
  excerpt: string;
  description: string;
  image_uri: string;
  image_file?: File | null;
  caption_image: string;
  state?: boolean;
  items?: Array<ItemServiceItem>;
  errors?: any;
}

export type ServicesIt = ServiceItem[];
export type PaginatedService = PaginatedResponse<ServiceItem>;
