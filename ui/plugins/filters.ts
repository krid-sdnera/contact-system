import { type AddressData } from '~/server/types/address';
import { DateTime, Duration } from 'luxon';

export default defineNuxtPlugin(() => {
  return {
    provide: {
      filters: {
        date,
        datetime,
        duration,
        capitalize,
        address,
        googleMapsLink,
        phone,
      },
    },
  };
});

function dateHelper(inDate: Date | string | undefined): DateTime | string {
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
}

function date(
  inDate: Date | string | undefined,
  format: 'ymd' | 'dmy' = 'dmy'
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
}

function datetime(inDate: Date | string | undefined, format: 'dmy' = 'dmy') {
  const dt: DateTime | string = dateHelper(inDate);
  if (typeof dt === 'string') {
    return dt;
  }

  switch (format) {
    // case 'ymd':
    // return dt.toISODate();
    default:
      return dt.toLocaleString(DateTime.DATETIME_SHORT_WITH_SECONDS);
  }
}

function duration(
  inDate: Date | string | undefined,
  opts?: {
    sentanceFix?: boolean;
  }
) {
  const dt: DateTime | string = dateHelper(inDate);
  if (typeof dt === 'string') {
    return dt;
  }

  let d: Duration = dt.diffNow(undefined, { conversionAccuracy: 'longterm' });

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

  if (future && opts?.sentanceFix) {
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
  if (!future && opts?.sentanceFix) {
    pp.push('ago');
  }
  return pp.join(' ');
}

function capitalize(value: string | undefined) {
  if (!value) {
    return '';
  }
  value = value.toString();
  return value.charAt(0).toUpperCase() + value.slice(1);
}

function address(address: AddressData | undefined) {
  if (!address) {
    return '';
  }

  const arr = [];

  if (address?.street1 || address?.street2) {
    arr.push(`${address?.street1} ${address?.street2}`.trim());
  }
  if (address?.city || address?.state) {
    arr.push(`${address?.city} ${address?.state}`.trim());
  }
  if (address?.postcode) {
    arr.push(`${address?.postcode}`.trim());
  }
  return arr.join(`,\n`);
}

function googleMapsLink(addressData: AddressData | undefined) {
  const place = address(addressData);

  if (!place) {
    return '';
  }

  return `https://google.com.au/maps?q=${place.replaceAll(' ', '+')}`;
}

function phone(inPhone: string | undefined) {
  if (!inPhone) {
    return '';
  }

  inPhone.replace(/[^\d]/, '');

  if (inPhone.length === 8) {
    return inPhone.replace(/(\d{4})(\d{4})/, '$1 $2');
  }
  if (inPhone.length === 10) {
    if (inPhone.startsWith('04')) {
      return inPhone.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3');
    }
    return inPhone.replace(/(\d{2})(\d{4})(\d{4})/, '$1 $2 $3');
  }
  if (inPhone.length === 11) {
    return inPhone.replace(/61(\d{3})(\d{3})(\d{3})/, '+61$1 $2 $3');
  }
}
