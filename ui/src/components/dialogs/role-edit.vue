<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <v-card v-if="builtDataInput !== null" style="height: 90vh;">
      <v-card-title style="position: sticky;">
        <span class="headline">{{ messages.title }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row v-for="(fields, index) in parsedFormFields" :key="index">
            <v-col
              v-for="(field, jndex) in fields"
              :key="field.name"
              :cols="12 / fields.length"
              :class="{
                'pl-0': jndex === 0,
                'pr-0': jndex === fields.length - 1,
                'pb-0': true,
              }"
            >
              <span v-if="field.disabled">
                <small>{{ field.label }}:</small>
                {{ data[field.name] }}
              </span>
              <base-input
                v-else
                :field.sync="builtDataInput[field.name]"
                :label="field.label"
                :field-type="field.type"
              ></base-input>
            </v-col>
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
          @click="closeDialog"
        >
          Cancel
        </v-btn>
        <v-btn
          v-if="originalChanged"
          :disabled="isAppUpdating"
          color="warning"
          text
          @click="submitDialog"
        >
          Override
        </v-btn>
        <v-btn
          v-else
          :disabled="isAppUpdating"
          color="blue darken-1"
          text
          @click="submitDialog"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { RoleData, RoleInput, MemberData } from '@api/models';
import { Component, Prop } from 'vue-property-decorator';
import BaseDialog, { DialogFields } from '~/components/dialogs/base-dialog';
import * as role from '~/store/role';

@Component
export default class DialogRoleEditComponent extends BaseDialog<
  RoleData,
  RoleInput
> {
  @Prop(Object) readonly member: MemberData | undefined;

  entityName = 'Role';
  get customMessages() {
    return {
      update: {
        title: `Update Role: ${this.data?.name}`,
      },
    };
  }

  get fields() {
    const fields: DialogFields<RoleInput> = [
      { name: 'name', label: 'Role Name', type: 'text' },
      { name: 'externalId', label: 'External ID', type: 'text' },
      { name: 'classId', label: 'Class ID', type: 'text' },
      { name: 'normalisedClassId', label: 'Normalised Class ID', type: 'text' },
      {
        name: 'sectionId',
        label: 'Section',
        type: 'select',
        options: this.availableSections,
      },
    ];

    return fields;
  }

  async fetchSections() {}

  async buildInputForCreate() {
    await this.fetchSections();
    const inputData: RoleInput = {
      name: '',
      externalId: '',
      classId: '',
      normalisedClassId: '',
      sectionId: 0,
    };

    return inputData;
  }

  async buildInputForUpdate(data: RoleData) {
    await this.fetchSections();
    const inputData: RoleInput = {
      name: data.name,
      externalId: data.externalId,
      classId: data.classId,
      normalisedClassId: data.normalisedClassId,
      sectionId: data.section.id,
    };

    return inputData;
  }

  async persistCreate(input: RoleInput) {
    await this.$store.dispatch(`${role.namespace}/createRole`, {
      roleInput: input,
    });
  }

  async persistUpdate(data: RoleData, input: RoleInput) {
    await this.$store.dispatch(`${role.namespace}/updateRoleById`, {
      roleId: data.id,
      roleInput: input,
    });
  }
}
</script>
