export interface CSApiOptions {
  query?: string;
  sort?: string;
  pageSize?: number;
  page?: number;
}

export enum AppFetchState {
  Loading = 'Loading',
  Loaded = 'Loaded',
  NotFound = 'NotFound',
  OtherError = 'OtherError',
}
