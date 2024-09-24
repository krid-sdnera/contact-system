export function usePostDeleteAction(
  source: () => any,
  callback: (value: any) => any
) {
  // Use of `@deleted="itemDeleted"` is not possible because once `props.xxxx` is removed
  // the @deleted handler is removed before it can be run.
  // Detect removal and redirect.
  watch(source, (newValue, oldValue) => {
    if (oldValue !== null && newValue === null) {
      callback(newValue);
    }
  });
}
