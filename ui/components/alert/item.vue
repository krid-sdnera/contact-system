<script setup lang="ts">
const { expireAlert } = useAlerts();

const props = defineProps<{ alert: AppAlertJSON }>();

onMounted(() => {
  setTimeout(() => {
    expireAlert(props.alert);
  }, 5000);
});
</script>

<template>
  <v-alert density="compact" :type="props.alert.type">{{
    props.alert.message
  }}</v-alert>
</template>
