import { PaginatedResponse } from "./Paginate";

export type GalleryItemState = {
  key?: string;
  id?: string | number | null          // existe en BD
  // tempId?: string
  item_id: number | undefined;
  file?: File           // imagen nueva
  image_uri?: string     // preview (url o storage)
  caption?: string
  removed?: boolean     // marcada para borrar
  isNew?: boolean
}

export interface ItemServiceItem {
  id?: number;
  service_id: number | null;
  service?: any;
  slug: string;
  description: string;
  excerpt: string;
  price: number;
  included: string;
  duration: string;
  state?: boolean;
  image_uri: string | null;
  image_file?: File | null;
  caption_image: string | undefined;
  location: string;
  capacity: number;
  start_date: string | undefined;
  featured?: boolean;
  position?: number;
  gallery: GalleryItemState[];
  errors?: any;
}
export type ItemServiceIt = ItemServiceItem[];

export type PaginatedItemService = PaginatedResponse<ItemServiceItem>;
