<template>
  <v-row
    class="flex-nowrap"
    :class="{ 'pl-2': hideOverrideCheckbox && !reserveOverrideCheckboxSpace }"
  >
    <v-tooltip v-if="overridable && !hideOverrideCheckbox" bottom>
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
    <v-checkbox
      v-else
      class="shrink ml-2"
      :class="reserveOverrideCheckboxSpace ? 'v-hidden' : 'd-none'"
    ></v-checkbox>
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
    <v-select
      v-else-if="fieldType === 'select'"
      item-text="label"
      item-value="value"
      v-model="fieldData"
      :label="label"
      :disabled="!isOverridden"
      :items="selectOptions"
    />
    <v-autocomplete
      v-else-if="fieldType === 'autocomplete'"
      item-text="label"
      item-value="value"
      v-model="fieldData"
      :label="label"
      :disabled="!isOverridden"
      :items="selectOptions"
    ></v-autocomplete>
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

  @Prop({ type: Boolean, default: false })
  readonly hideOverrideCheckbox!: boolean;

  @Prop({ type: Boolean, default: false })
  readonly reserveOverrideCheckboxSpace!: boolean;

  @Prop([String, Date, Boolean])
  readonly original: string | Date | boolean | undefined;

  @Prop(String)
  readonly fieldType!: string;

  @Prop(Array)
  readonly selectOptions: { label: string; value: string }[] | undefined;

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
        this.fieldData =
          this.original instanceof Date
            ? this.original?.toISOString().substr(0, 10)
            : false;
        break;
      }
      default: {
        this.fieldData = !(this.original instanceof Date)
          ? this.original ?? ''
          : '';

        break;
      }
    }
  }
}
</script>

<style scoped>
.v-hidden {
  visibility: hidden;
}
</style>
