type AlertType = 'error' | 'warning' | 'success' | 'info';

export interface AppAlertJSON {
  heading: string | null;
  message: string;
  type: AlertType;
  deduplicate: boolean;
  uniq: string;
}

type AppAlertInput = Partial<AppAlertJSON> & Pick<AppAlertJSON, 'message'>;

const alerts = ref<AppAlertJSON[]>([]);

export function useAlerts() {
  return {
    alerts,
    createAlert(appAlert: AppAlertInput) {
      if (
        appAlert.deduplicate &&
        alerts.value.find((a) => equals(a, appAlert))
      ) {
        // This message is already in the active alert list.
        // TODO: maybe reset the timer, that that would be more involved.
        return;
      }

      const appAlertsWithDefaultRules: AppAlertJSON = {
        heading: appAlert.heading ?? null,
        message: appAlert.message,
        type: appAlert.type ?? 'info',
        deduplicate: appAlert.deduplicate ?? false,
        uniq: new Date().toISOString(),
      };

      alerts.value.push(appAlertsWithDefaultRules);
    },
    expireAlert(appAlert: AppAlertJSON) {
      alerts.value.splice(alerts.value.indexOf(appAlert), 1);
    },
  };
}

function equals(a: AppAlertInput, b: AppAlertInput): boolean {
  return (
    a.heading === b.heading &&
    a.message === b.message &&
    a.type === b.type &&
    a.deduplicate === b.deduplicate
  );
}

const { isLoggedIn } = useAuth();

watch(isLoggedIn, (newVal, oldVal) => {
  if (newVal === oldVal) {
    return;
  }
  if (newVal === true) {
    useAlerts().createAlert({
      message: 'Login Successful',
      type: 'success',
      deduplicate: true,
    });
  } else {
    useAlerts().createAlert({
      message: 'Logged out',
      type: 'warning',
      deduplicate: true,
    });
  }
});
