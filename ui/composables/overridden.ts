import type { ContactData } from '~/server/types/contact';
import type { MemberData } from '~/server/types/member';

type OverrideKeys<Z extends ContactData | MemberData> = keyof NonNullable<
  NonNullable<Z>['overrides']
>;

export function useOverriddenContact<
  T extends ContactData,
  Keys = OverrideKeys<T>
>(contact: ComputedRef<T | null>) {
  return {
    isOverridden(field: Keys | Keys[]): boolean {
      const fields: Keys[] = Array.isArray(field) ? field : [field];

      return fields.some((field) => contact.value?.overrides?.[field] === true);
    },
  };
}

export function useOverriddenMember<
  T extends MemberData,
  Keys = OverrideKeys<T>
>(member: ComputedRef<T | null>) {
  return {
    isOverridden(field: Keys | Keys[]): boolean {
      const fields: Keys[] = Array.isArray(field) ? field : [field];

      return fields.some((field) => member.value?.overrides?.[field] === true);
    },
  };
}
