<template>
  <v-row>
    <v-col>
      <v-card>
        <v-card-text>
          <v-row align="center">
            <v-col md="auto">
              <v-icon color="red" style="font-size: 20vw;">
                mdi-alert-circle-outline
              </v-icon>
            </v-col>
            <v-col v-if="error.previous.status === 404">
              <h2 class="mb-6">{{ error.message }}</h2>
              <p>Possible actions:</p>
              <ul class="possible-action-container">
                <li v-for="crumb in breadcrumbs" v-bind:key="crumb.to">
                  View
                  <nuxt-link :to="crumb.to" class="text-decoration-none">
                    {{ crumb.label }}
                  </nuxt-link>
                </li>
              </ul>
            </v-col>
            <v-col v-else>
              <h2 class="mb-6">
                {{ error.message }} - {{ error.previous.status }}
              </h2>
              <p>Possible actions:</p>
              <ul class="possible-action-container">
                <li v-for="crumb in breadcrumbs" v-bind:key="crumb.to">
                  View
                  <nuxt-link :to="crumb.to" class="text-decoration-none">
                    {{ crumb.label }}
                  </nuxt-link>
                </li>
              </ul>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';
import { AppError } from '~/common/app-error';
import { AppBreadcrumb } from '~/common/breadcrumb';

import * as ui from '~/store/ui';

@Component
export default class ErrorDisplay extends Vue {
  @Prop({ required: true })
  error!: AppError;

  get breadcrumbs(): AppBreadcrumb[] {
    const breadcrumbs: AppBreadcrumb[] = this.$store.getters[
      `${ui.namespace}/breadcrumbs`
    ];
    const cloned = [...breadcrumbs];
    cloned.pop();
    return cloned.reverse();
  }
}
</script>

<style lang="css" scoped>
ul.possible-action-container {
  list-style-type: none;
}
ul.possible-action-container li a {
  text-decoration: none;
}
ul.possible-action-container li a:hover {
  text-decoration: underline;
}
</style>
