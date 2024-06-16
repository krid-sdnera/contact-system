import type { ContactData } from '~/server/types/contact';
import type { MemberData } from '~/server/types/member';
import type { RoleData } from '~/server/types/role';
import type { ScoutGroupData } from '~/server/types/scoutGroup';
import type { SectionData } from '~/server/types/section';

export type RuleRelationProp = {
  member?: MemberData;
  contact?: ContactData;
  role?: RoleData;
  section?: SectionData;
  scoutGroup?: ScoutGroupData;
};

export type Relation =
  | { type: 'member'; entity: MemberData }
  | { type: 'contact'; entity: ContactData }
  | { type: 'role'; entity: RoleData }
  | { type: 'section'; entity: SectionData }
  | { type: 'scoutGroup'; entity: ScoutGroupData }
  | null;

const pathMap: Record<string, string> = {
  Contact: 'contacts',
  Member: 'members',
  MemberRole: 'members',
  Role: 'roles',
  Section: 'sections',
  ScoutGroup: 'groups',
  EmailList: 'lists',
  EmailListRule: 'lists',
};

export function relationPath(relationType: string): string {
  return pathMap[relationType];
}

export function relationLinkable(relationType: string): boolean {
  return relationType in pathMap;
}

export function relationUrl(relationType: string, id: string | number): string {
  if (relationType === 'MemberRole') {
    const memberId = String(id).split('-', 1)[0];
    return `/${relationPath('Member')}/${memberId}`;
  }
  if (relationType === 'EmailListRule') {
    const emailId = String(id).split('-', 1)[0];
    return `/${relationPath('EmailList')}/${emailId}`;
  }

  return `/${relationPath(relationType)}/${id}`;
}

export function useRuleRelation<T extends RuleRelationProp>(relationProp: T) {
  return {
    getEntity(): Relation {
      if (relationProp.member) {
        return {
          entity: relationProp.member,
          type: 'member',
        };
      } else if (relationProp.contact) {
        return {
          entity: relationProp.contact,
          type: 'contact',
        };
      } else if (relationProp.role) {
        return {
          entity: relationProp.role,
          type: 'role',
        };
      } else if (relationProp.section) {
        return {
          entity: relationProp.section,
          type: 'section',
        };
      } else if (relationProp.scoutGroup) {
        return {
          entity: relationProp.scoutGroup,
          type: 'scoutGroup',
        };
      }

      return null;
    },
    getByType<K extends keyof T>(type: K): T[K] {
      return relationProp[type];
    },
  };
}
