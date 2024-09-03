import { useStorage, type RemovableRef } from '@vueuse/core';

interface Header {
  readonly key?: string;
  readonly value?: any;
  readonly title?: string;
  readonly fixed?: boolean;
  readonly align?: 'end' | 'center' | 'start';
  readonly width?: string | number;
  readonly minWidth?: string;
  readonly maxWidth?: string;
  readonly nowrap?: boolean;
  // headerProps
  // cellProps
  readonly sortable?: boolean;
  // sort
  // sortRaw
  // filter
  readonly mobile?: boolean;
  children?: Header[];

  // Custom fields.
  filterable?: boolean;
  typeConfig?:
    | { type: 'boolean' }
    | { type: 'enum'; choices: { title: string; value: string }[] };
}

type HeaderWithKey = Header & Required<Pick<Header, 'key'>>;

export type TableControlsHeader = HeaderWithKey;

export function useTableControls<H extends HeaderWithKey>(
  tableControlsKey: string,
  headers: H[],
  defaultColumns: string[]
) {
  const defaultColumnsMap = headers.reduce((acc, column) => {
    acc[column.key] = defaultColumns.includes(column.key);
    return acc;
  }, {} as Record<string, boolean>);

  const fixedColumns = ['actionButtons'];

  const columnDisplayMap = useStorage<Record<string, boolean>>(
    tableControlsKey,
    defaultColumnsMap
  );

  return {
    shownHeaders: computed(() => {
      return headers.filter(
        (h) =>
          // If a fixed column, always show it.
          fixedColumns.includes(h.key) || columnDisplayMap.value[h.key]
      );
    }),
    useUiTableControls(): UiTableControls {
      return {
        availableColumns: headers
          .filter((h) => !fixedColumns.includes(h.key))
          .map((h) => ({
            key: h.key,
            title: h.title || '',
          })),
        columnDisplayMap: columnDisplayMap,
      };
    },
  };
}

interface HeaderSimple {
  key: string;
  title: string;
}

export interface UiTableControls {
  availableColumns: HeaderSimple[];
  columnDisplayMap: RemovableRef<Record<string, boolean>>;
}
