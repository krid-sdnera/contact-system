<template>
  <v-row class="flex-nowrap">
    <v-tooltip v-if="overridable" bottom>
      <template v-slot:activator="{ on, attrs }">
        <div v-bind="attrs" v-on="on">
          <v-checkbox v-model="overrideData" class="shrink ml-2"></v-checkbox>
        </div>
      </template>
      <span v-if="isOverridden">
        {{ label }} is currently overridden.<br />
        Unchecking will allow updates from Extranet data.
      </span>
      <span v-else-if="!isOverridden">
        {{ label }} can be updated from Extranet data.<br />
        Checking will hold its current value.
      </span>
      <span v-else>Something went wrong.</span>
    </v-tooltip>
    <v-text-field
      v-if="fieldType === 'text'"
      v-model="fieldData"
      :label="label"
      :disabled="!isOverridden"
    ></v-text-field>
    <v-switch
      v-else-if="fieldType === 'checkbox'"
      v-model="fieldData"
      :label="label"
      :disabled="!isOverridden"
    ></v-switch>
    <v-menu
      v-else-if="fieldType === 'date'"
      v-model="datePickerModal"
      :close-on-content-click="false"
      :nudge-right="40"
      transition="scale-transition"
      offset-y
      min-width="290px"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-text-field
          v-model="fieldData"
          :disabled="!isOverridden"
          :label="label"
          append-icon="mdi-calendar"
          readonly
          v-bind="attrs"
          v-on="on"
        ></v-text-field>
      </template>
      <v-date-picker
        v-model="fieldData"
        :disabled="!isOverridden"
        @input="datePickerModal = false"
      ></v-date-picker>
    </v-menu>
    <slot></slot>
  </v-row>
</template>

<script lang="ts">
import { Vue, Component, Watch, Prop, PropSync } from 'vue-property-decorator';

@Component
export default class BaseInputComponent extends Vue {
  @Prop(String)
  readonly label!: string;

  @Prop(Boolean)
  readonly overridable: boolean | undefined;

  @Prop([String, Date, Boolean])
  readonly original: string | Date | boolean | undefined;

  @Prop(String)
  readonly fieldType!: string;

  @PropSync('field', { type: [String, Boolean] })
  fieldData!: string | boolean;

  @PropSync('override', { type: Boolean })
  overrideData: boolean | undefined;

  datePickerModal: boolean = false;

  get isOverridden(): boolean {
    if (this.overridable) {
      return this.overrideData === true;
    }
    return true;
  }

  @Watch('overrideData')
  handleOverrideChange(override: boolean) {
    if (override === true) {
      // No action required
      return;
    }

    // The override key is set to a falsy value.
    switch (this.fieldType) {
      case 'date': {
        this.fieldData = this.original?.toISOString().substr(0, 10);
        break;
      }
      default: {
        this.fieldData = this.original || '';

        break;
      }
    }
  }
}
</script>
