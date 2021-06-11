export interface VuetifyTableOptions {
  sortBy: string[];
  sortDesc: string[];
  page: number;
  itemsPerPage: number;
  groupBy: string[];
  groupDesc: string[];
  multiSort: boolean;
  mustSort: boolean;
}

export interface VuetifyTableHeader<T = string> {
  text: string;
  value: T;
  sortable?: boolean;
}
