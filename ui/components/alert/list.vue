<script setup lang="ts">
const { alerts } = useAlerts();
</script>

<template>
  <div class="alert-container">
    <AlertItem
      v-for="appAlert in alerts"
      :key="appAlert.uniq"
      :alert="appAlert"
    />
  </div>
</template>

<style lang="scss" scoped>
.alert-container {
  position: fixed;
  bottom: 16px;
  right: 16px;
  z-index: 999;
}
</style>
