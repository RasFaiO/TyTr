export interface DataLink {
  url: URL;
  label: Text;
  active: boolean;
}

export interface PaginatedResponse<T> {
  data: T[];
  links: DataLink[];
  current_page?: number;
  last_page?: number;
  total?: number;
  per_page?: number;
  [key: string]: unknown;
}

// Page props
export interface PageProps {
  auth?: {
    user: {
      id: number
    }
  }
  user: {
    permissions: string[];
  };
  flash: {
    message?: string;
  };
  [key: string]: unknown;
}