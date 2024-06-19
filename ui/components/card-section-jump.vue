<script setup lang="ts">
interface Jump {
  label: string;
  hash: string;
}

const props = defineProps<{
  jumps: Jump[];
}>();
</script>

<template>
  <v-card class="mb-6">
    <v-card-title class="text-subtitle-1">Jump to</v-card-title>

    <v-card-text>
      <div v-for="jump in props.jumps" class="text-body-1 py-2 jump-option">
        <NuxtLink :to="{ hash: jump.hash }">
          {{ jump.label }}
          <v-icon
            icon="mdi-share"
            size="x-small"
            style="vertical-align: top"
          ></v-icon>
        </NuxtLink>
      </div>
    </v-card-text>
  </v-card>
</template>

<style lang="css" scoped>
div.jump-option {
  font-size: 1.5rem !important;
}
div.jump-option a {
  text-decoration: none;
}
div.jump-option a:hover {
  text-decoration: underline;
}
</style>
