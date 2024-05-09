export interface Breadcrumb {
  to: string;
  label: string;
}

export function useBreadcrumbs() {
  const route = useRoute();

  return {
    breadcrumbs: computed<Breadcrumb[]>(
      () =>
        (route.meta.breadcrumbs as Breadcrumb[]) || [{ to: '/', label: 'Home' }]
    ),
  };
}

export function useBuildBreadcrumbs(breadcrumbs: Breadcrumb[]) {
  return breadcrumbs;
}
