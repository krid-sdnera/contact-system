import { Component, Emit, Prop, Vue, Watch } from 'vue-property-decorator';
import { AppFetchState } from '~/common/api-types';
import { AppError, ErrorCode } from '~/common/app-error';
import {
  apiStatus,
  apiStatusEnd,
  AppBreadcrumbOptions,
  setBreadcrumbs,
} from '~/common/helper-factories';
import * as ui from '~/store/ui';

interface IDwise {
  id: number | string;
}

@Component
export default class BaseDisplayPage extends Vue {
  breadcrumbParents: AppBreadcrumbOptions[] = [];
  get breadcrumbLabel(): string | null {
    return '';
  }
  get breadcrumbs(): AppBreadcrumbOptions[] {
    const mapLastLabel: Record<AppFetchState, string> = {
      [AppFetchState.Loading]: 'Loading',
      [AppFetchState.Loaded]: this.breadcrumbLabel ?? 'Loading',
      [AppFetchState.NotFound]: 'Not Found',
      [AppFetchState.OtherError]: 'Error',
    };

    return [
      { to: '/', label: 'Dashboard' },
      ...this.breadcrumbParents,
      {
        to: null,
        label: mapLastLabel[this.fetchState],
      },
    ];
  }

  @Watch('breadcrumbs', { immediate: true })
  watchBreadcrumbs() {
    setBreadcrumbs(this.$store, this.breadcrumbs);
  }

  fetchApiStatusMsg: string = 'Loading Data';
  async _fetchApiData(): Promise<void> {}
  async _fetchDataEntityNotFound(): Promise<void> {}

  fetchState: AppFetchState = AppFetchState.Loading;
  appFetchState = AppFetchState;
  error: AppError | null = null;
  get dataRefreshRequest(): boolean {
    return this.$store.getters[`${ui.namespace}/dataRefreshRequest`];
  }
  @Watch('dataRefreshRequest')
  async fetchData(newDataRefreshRequest?: boolean) {
    if (newDataRefreshRequest === false) {
      return;
    }

    this.fetchState = AppFetchState.Loading;
    apiStatus(this.$store, this.fetchApiStatusMsg);

    try {
      await this._fetchApiData();
      this.fetchState = AppFetchState.Loaded;
    } catch (e) {
      this.error = e;
      if (e.code === ErrorCode.EntityNotFound) {
        this._fetchDataEntityNotFound();
        this.fetchState = AppFetchState.NotFound;
      } else {
        this.fetchState = AppFetchState.OtherError;
      }
    } finally {
      this.$store.commit(`${ui.namespace}/completeDataRefresh`);
      apiStatusEnd(this.$store, this.fetchApiStatusMsg);
    }
  }

  // Common methods
  async mounted() {
    await this.fetchData();
  }
}
