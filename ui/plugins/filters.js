import Vue from 'vue';

Vue.filter('dateOfBirth', function (value) {
  if (!value) {
    return '';
  }
  return new Date(value.toString()).toLocaleDateString();
});

Vue.filter('capitalize', function (value) {
  if (!value) {
    return '';
  }
  value = value.toString();
  return value.charAt(0).toUpperCase() + value.slice(1);
});
