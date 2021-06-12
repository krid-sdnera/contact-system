<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" v-bind="attrs" v-on="on" class="mb-2">
        New Email List Rule
      </v-btn>
    </template>
    <v-card v-if="newListRule !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">
          Create new List Rule
        </span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <!-- Label -->
            <base-input
              :field.sync="newListRule.label"
              label="Label"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Comment -->
            <base-input
              :field.sync="newListRule.comment"
              label="Comment"
              field-type="text"
            ></base-input>
          </v-row>
          <v-row>
            <!-- List Selector -->
            <base-input
              :field.sync="selectedListId"
              label="List"
              field-type="autocomplete"
              :select-options="listOptions"
            ></base-input>
          </v-row>
          <v-row>
            <p>
              {{ presetRelationType }}:
              {{ presetRelation.id }}
            </p>
          </v-row>
          <v-row>
            <!-- Use Member Checkbox -->
            <base-input
              :field.sync="newListRule.useMember"
              label="Use Member email"
              field-type="checkbox"
            ></base-input>
          </v-row>
          <v-row>
            <!-- Use Contact Checkbox -->
            <base-input
              :field.sync="newListRule.useContact"
              label="Use Contact email"
              field-type="checkbox"
            ></base-input>
          </v-row>
        </v-container>
        <small>*indicates required field</small>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="closeCreateListModal"
        >
          Cancel
        </v-btn>
        <v-btn
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="saveCreateListModal"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import {
  ContactData,
  ListData,
  ListRuleData,
  ListRuleInput,
  MemberData,
  RoleData,
  ScoutGroupData,
  SectionData,
} from '@api/models';
import {
  Component,
  Emit,
  Prop,
  PropSync,
  Vue,
  Watch,
} from 'vue-property-decorator';
import { createAlert } from '~/common/alert';
import * as list from '~/store/emailList';
import * as ui from '~/store/ui';

@Component
export default class DialogListRuleCreateComponent extends Vue {
  @PropSync('open', Boolean)
  dialog!: boolean;

  @Prop(Object) readonly presetRelation!:
    | ContactData
    | MemberData
    | RoleData
    | SectionData
    | ScoutGroupData
    | undefined;
  @Prop(String) readonly presetRelationType!: string | undefined;

  newListRule: ListRuleInput | null = null;

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  @Watch('dialog')
  handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, rebuild data
      this.buildNewListRuleData();
    }
  }

  get contactId(): number | null {
    return this.presetRelationType === 'Contact' && this.presetRelation
      ? this.presetRelation.id
      : null;
  }
  get memberId(): number | null {
    return this.presetRelationType === 'Member' && this.presetRelation
      ? this.presetRelation.id
      : null;
  }
  get roleId(): number | null {
    return this.presetRelationType === 'Role' && this.presetRelation
      ? this.presetRelation.id
      : null;
  }
  get sectionId(): number | null {
    return this.presetRelationType === 'Section' && this.presetRelation
      ? this.presetRelation.id
      : null;
  }
  get scoutGroupId(): number | null {
    return this.presetRelationType === 'ScoutGroup' && this.presetRelation
      ? this.presetRelation.id
      : null;
  }

  buildNewListRuleData() {
    this.newListRule = Object.assign({}, {
      label: '',
      comment: '',
      memberId: this.memberId,
      contactId: this.contactId,
      roleId: this.roleId,
      sectionId: this.sectionId,
      scoutGroupId: this.scoutGroupId,
      useMember: this.presetRelationType === 'Member' ? true : false,
      useContact: this.presetRelationType === 'Contact' ? true : false,
    } as ListRuleInput);

    // Dont wait to load list of lists
    this.$store.dispatch(`${list.namespace}/fetchAllLists`, {});
  }

  closeCreateListModal() {
    this.dialog = false;
  }

  @Emit('submit')
  async saveCreateListModal() {
    try {
      if (
        this.newListRule &&
        this.newListRule.useMember === false &&
        this.newListRule.useContact === false
      ) {
        createAlert(this.$store, {
          message: '"Use Member" or "Use Contact" must be selected.',
          type: 'warning',
        });
        return;
      }
      const ruleResponse = await this.$store.dispatch(
        `${list.namespace}/createEmailListRuleById`,
        {
          listRuleInput: this.newListRule,
          listId: this.selectedListId,
        }
      );

      this.dialog = false;
      this.newListRule = null;
      createAlert(this.$store, {
        message: 'List Rule created.',
        type: 'success',
      });

      return ruleResponse;
    } catch (e) {
      console.error(e);

      createAlert(this.$store, {
        message: 'Failed to create List Rule.',
        type: 'error',
      });
    }
  }
  selectedListId: string | null = null;

  get listOptions(): { label: string; value: string }[] {
    if (!this.presetRelation) {
      return [];
    }
    const listsAlreadyAssigned: number[] = this.$store.getters[
      `${list.namespace}/getRulesBy${this.presetRelationType}Id`
    ](this.presetRelation.id).map((x: ListRuleData): number => x.listId);

    return Object.values(
      this.$store.state.emailList.emailLists as Record<number, ListData>
    )
      .filter(
        (list: ListData): boolean => !listsAlreadyAssigned.includes(list.id)
      )
      .map((list: ListData): {
        label: string;
        value: string;
      } => ({
        label: `${list.name} - ${list.address}`,
        value: String(list.id),
      }));
  }
}
</script>
