import { PaginatedResponse } from "./Paginate";

export interface HeaderImage {
  id?: number;
  description: string;
  image_uri: string;
  image_file: File | null;
  caption: string;
  errors?: any;
}

export type HeaderItems = HeaderImage[];

export type PaginatedHeaderImage = PaginatedResponse<HeaderImage>;
