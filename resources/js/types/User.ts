import { PaginatedResponse } from "./Paginate";

export interface User {
  id?: number;
  name: string;
  email: string;
  password: string;
  password_confirmation?: string;
  errors?: any;
}

export type userItem = User[];
export type PaginatedUser = PaginatedResponse<User>;
