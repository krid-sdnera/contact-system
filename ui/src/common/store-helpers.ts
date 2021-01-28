import { CSApiOptions } from './api-types';

export async function fetchAllHelper<
  Req extends CSApiOptions,
  Res extends {
    totalItems: number;
    totalPages: number;
    page: number;
    pageSize: number;
  }
>(
  fetchCb: (options: Req) => Promise<Res>,
  reduceToIdsCb: (payload: Res) => (string | number)[],
  options: Req
) {
  const ids: (string | number)[] = [];
  const apiOptions: Req = {
    ...options,
    pageSize: 50,
  };

  let nextPageNumber: number | null = 1;
  while (nextPageNumber !== null) {
    apiOptions.page = nextPageNumber;

    const payload: Res = await fetchCb(apiOptions);

    ids.push(...reduceToIdsCb(payload));

    nextPageNumber =
      apiOptions.page < payload.totalPages ? payload.page + 1 : null;
  }

  return ids;
}
