export interface VuetifyTableOptions {
  sortBy: string[];
  sortDesc: string[];
  page: number;
  itemsPerPage: number;
}

export interface VuetifyTableHeader<T = string> {
  text: string;
  value: T;
  sortable?: boolean;
}
