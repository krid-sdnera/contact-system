<script setup lang="ts">
const { globalPending, globalError } = useApi();
</script>

<template>
  <v-progress-linear
    :active="globalPending || globalError"
    :indeterminate="true"
    :color="globalError ? 'error' : 'primary'"
    absolute
    location="bottom"
  ></v-progress-linear>
</template>
