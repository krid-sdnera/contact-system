<script setup lang="ts">
import type { ListData } from '~/server/types/list';
import type { ListRuleData, ListRuleInput } from '~/server/types/listRule';

const model = defineModel<ListRuleInput | null>();
const modelList = defineModel<ListData | null>('list');
const props = defineProps<{
  currentListRule?: ListRuleData;

  relation?: RuleRelationProp;
}>();
const emit = defineEmits<{
  created: [number];
}>();

onMounted(() => {
  model.value = buildInternalListRuleData(props.currentListRule);
});

function buildInternalListRuleData(
  currentListRule?: ListRuleData
): ListRuleInput {
  if (currentListRule) {
    return {
      label: currentListRule.label,
      comment: currentListRule.comment,
      memberId: null, //currentListRule.memberId,
      contactId: null, //currentListRule.contactId,
      roleId: null, //currentListRule.roleId,
      sectionId: null, //currentListRule.sectionId,
      scoutGroupId: null, //currentListRule.scoutGroupId,
      useMember: currentListRule.useMember,
      useContact: currentListRule.useContact,
    };
  } else {
    if (!props.relation) {
      return {
        label: 'ERROR',
        comment: 'No Relation defined',
        memberId: undefined,
        contactId: undefined,
        roleId: undefined,
        sectionId: undefined,
        scoutGroupId: undefined,
        useMember: false,
        useContact: false,
      };
    }
    const { getByType } = useRuleRelation(props.relation);

    return {
      label: '',
      comment: '',
      memberId: getByType('member')?.id,
      contactId: getByType('contact')?.id,
      roleId: getByType('role')?.id,
      sectionId: getByType('section')?.id,
      scoutGroupId: getByType('scoutGroup')?.id,
      useMember: getByType('member') ? true : false,
      useContact: getByType('contact') ? true : false,
    };
  }
}

let relation: Relation | null = null;
if (props.relation) {
  const { getEntity } = useRuleRelation(props.relation);
  relation = getEntity();
}

const { lists, useListAllLists } = useList();
const { error, errorMessage, status } = useListAllLists();

const listOptions = computed(() => {
  if (error.value) {
    return [];
  }

  // TODO: exlude lists which already have a rule for the current `relation.entity`

  return Object.values(lists.value).map((list) => ({
    title: list.name,
    subtitle: `${list.address}`,
    value: list,
  }));
});

// const listOptions = computed((): { label: string; value: string }[] => {
//     if (!this.presetRelation) {
//       return [];
//     }
//     const listsAlreadyAssigned: number[] = this.$store.getters[
//       `${list.namespace}/getRulesBy${this.presetRelationType}Id`
//     ](this.presetRelation.id).map((x: ListRuleData): number => x.listId);

//     return Object.values(
//       this.$store.state.emailList.emailLists as Record<number, ListData>
//     )
//       .filter(
//         (list: ListData): boolean => !listsAlreadyAssigned.includes(list.id)
//       )
//       .map((list: ListData): {
//         label: string;
//         value: string;
//       } => ({
//         label: `${list.name} - ${list.address}`,
//         value: String(list.id),
//       }));
//   })
</script>

<template>
  <v-container v-if="model">
    <v-row>
      <v-col>
        <p>
          Add a rule to bind email addresses associated with [{{
            relation?.type
          }}: {{ relation?.entity.id }}] with the list below.
        </p>
      </v-col>
    </v-row>

    <v-row>
      <!-- Label -->
      <v-text-field
        v-model="model.label"
        label="Label"
        type="text"
      ></v-text-field>
    </v-row>
    <v-row>
      <!-- Comment -->
      <v-text-field
        v-model="model.comment"
        label="Comment"
        type="text"
      ></v-text-field>
    </v-row>

    <v-row>
      <!-- List Selector -->
      <v-select
        v-model="modelList"
        label="List Selector"
        :loading="status !== 'success'"
        :items="listOptions"
        :color="listOptions.length == 0 ? 'error' : ''"
      ></v-select>
    </v-row>
    <v-row>
      <!-- Use Member Checkbox -->
      <v-checkbox
        v-model="model.useMember"
        label="Use Member email"
      ></v-checkbox>
    </v-row>
    <v-row>
      <!-- Use Contact Checkbox -->
      <v-checkbox
        v-model="model.useContact"
        label="Use Contact email"
      ></v-checkbox>
    </v-row>
    <small>*indicates required field</small>
  </v-container>
</template>
