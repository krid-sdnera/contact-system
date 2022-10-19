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
    <v-row v-if="fieldType === 'address'">
      <v-col cols="6" class="pr-0 pb-0">
        <!-- Address Line 1 -->
        <v-text-field
          v-model="fieldData.street1"
          label="Street Line 1"
          :disabled="!isOverridden"
        ></v-text-field>
      </v-col>

      <v-col cols="6" class="pl-0 pb-0">
        <!-- Address Line 2 -->
        <v-text-field
          v-model="fieldData.street2"
          label="Street Line 2"
          :disabled="!isOverridden"
        ></v-text-field>
      </v-col>

      <v-col cols="4" class="pr-0 pb-0">
        <!-- Address City -->
        <v-text-field
          v-model="fieldData.city"
          label="City"
          :disabled="!isOverridden"
        ></v-text-field>
      </v-col>

      <v-col cols="4" class="px-0 pb-0">
        <!-- Address State -->
        <v-text-field
          v-model="fieldData.state"
          label="State"
          :disabled="!isOverridden"
        ></v-text-field>
      </v-col>

      <v-col cols="4" class="pl-0 pb-0">
        <!-- Address Postcode -->
        <v-text-field
          v-model="fieldData.postcode"
          label="Postcode"
          :disabled="!isOverridden"
        ></v-text-field>
      </v-col>
    </v-row>

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

  @Prop([String, Date, Number, Boolean, Object])
  readonly original: string | Date | number | boolean | Object | undefined;

  @Prop(String)
  readonly fieldType!: string;

  @Prop(Array)
  readonly selectOptions: { label: string; value: string }[] | undefined;

  @PropSync('field', { type: [String, Number, Boolean, Object] })
  fieldData!: string | number | boolean | Object;

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
