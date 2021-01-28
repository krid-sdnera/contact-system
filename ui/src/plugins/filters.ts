import Vue from 'vue';
import { AddressData } from '@api/models';
import { DateTime, Duration } from 'luxon';

const dateHelper = (inDate: Date | string | undefined): DateTime | string => {
  if (!inDate) {
    return '';
  }
  let dt: DateTime;

  dt = DateTime.fromJSDate(inDate as Date);

  if (dt.invalidExplanation || dt.invalidReason) {
    dt = DateTime.fromSQL(inDate as string);
    if (dt.invalidExplanation || dt.invalidReason) {
      return dt.invalidExplanation || dt.invalidReason || '';
    }
  }
  return dt;
};

Vue.filter('date', function (
  inDate: Date | string | undefined,
  format: 'ymd' | 'dmy'
) {
  const dt: DateTime | string = dateHelper(inDate);
  if (typeof dt === 'string') {
    return dt;
  }

  switch (format) {
    case 'ymd':
      return dt.toISODate();
    default:
      return dt.toLocaleString(DateTime.DATE_SHORT);
  }
});

Vue.filter('duration', function (
  inDate: string | Date,
  niceText: boolean = true
) {
  const dt: DateTime | string = dateHelper(inDate);
  if (typeof dt === 'string') {
    return dt;
  }

  let d: Duration = dt.diffNow();

  // Date is in the future.
  const future = d.milliseconds > 0;

  d = future ? d : d.negate();
  d = d.shiftTo('years', 'months', 'days', 'hours', 'minutes');

  const dur = d.toObject();
  let pp: string[] = [];

  const showYears = Number(dur.years) > 0;
  const showMonths = Number(dur.months) > 0;
  const showDays = Number(dur.days) > 0 && !showYears;
  const showHours = Number(dur.hours) > 0 && !showYears && !showMonths;
  const showMinutes =
    Number(dur.minutes) > 0 && !showYears && !showMonths && !showDays;

  if (future && niceText) {
    pp.push('in');
  }
  if (showYears) {
    pp.push(`${dur.years?.toFixed(0)}y`);
  }
  if (showMonths) {
    pp.push(`${dur.months?.toFixed(0)}m`);
  }
  if (showDays) {
    pp.push(`${dur.days?.toFixed(0)}d`);
  }
  if (showHours) {
    pp.push(`${dur.hours?.toFixed(0)}h`);
  }
  if (showMinutes) {
    pp.push(`${dur.minutes?.toFixed(0)}m`);
  }
  if (!future && niceText) {
    pp.push('ago');
  }
  return pp.join(' ');
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

Vue.filter('phone', function (inPhone: string | undefined) {
  if (!inPhone) {
    return '';
  }

  inPhone.replace(/[^\d]/, '');

  if (inPhone.length === 8) {
    return inPhone.replace(/(\d{4})(\d{4})/, '$1 $2');
  }
  if (inPhone.length === 10) {
    return inPhone.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3');
  }
  if (inPhone.length === 11) {
    return inPhone.replace(/61(\d{3})(\d{3})(\d{3})/, '+61$1 $2 $3');
  }
});
