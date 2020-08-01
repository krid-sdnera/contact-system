import Vue from 'vue';
import { AddressData } from '@api/models';

Vue.filter('dateOfBirth', function (value: Date | undefined) {
  if (!value) {
    return '';
  }
  return new Date(value.toString()).toLocaleDateString();
});

Vue.filter('capitalize', function (value: string | undefined) {
  if (!value) {
    return '';
  }
  value = value.toString();
  return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter('address', function (address: AddressData) {
  if (!address) {
    return '';
  }

  const street1 = address.street1 || '';
  const street2 = address.street2 || '';
  const city = address.city || '';
  const state = address.state || '';
  const postcode = address.postcode || '';

  return `${street1} ${street2} ${city} ${state} ${postcode}`.trim();
});
