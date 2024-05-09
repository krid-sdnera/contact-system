<template>
  <v-dialog v-model="dialog" max-width="500" scrollable>
    <template v-slot:activator="{ on, attrs }">
      <v-btn v-bind="attrs" v-on="on" small>
        Options
        <v-icon right small>mdi-cog</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        Select Columns
        <v-spacer></v-spacer>
        <v-btn icon dark @click="dialog = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-checkbox
          v-for="field in availableFields"
          :key="field.value"
          v-model="selectedFieldsSync"
          :label="field.text"
          :value="field.value"
          hide-details
          dense
          :multiple="true"
        ></v-checkbox>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="green" text @click="dialog = false">
          Close
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { Vue, Component, Prop, Watch, PropSync } from 'vue-property-decorator';

@Component
export default class TableOptionsComponent extends Vue {
  @PropSync('open', Boolean) dialog!: boolean;
  @PropSync('selectedFields', Array) selectedFieldsSync!: string[];

  @Prop(Array) readonly availableFields!: { text: string; value: string }[];
}
</script>
