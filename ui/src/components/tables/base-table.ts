import {
  ContactDataManagementStateEnum,
  ContactDataStateEnum,
  MemberRoleDataManagementStateEnum,
  MemberRoleDataStateEnum,
  ModelApiResponse,
} from '@api/models';
import { Component, Emit, Prop, Vue, Watch } from 'vue-property-decorator';
import { createAlert } from '~/common/alert';
import { CSApiOptions } from '~/common/api-types';
import { VuetifyTableOptions } from '~/common/vuetify-types';

interface IDwise {
  id: number | string;
}

@Component
export default class BaseTable<T extends IDwise> extends Vue {
  // Default Props
  @Prop(Boolean) readonly allowCreation!: boolean;
  @Prop(Boolean) readonly searchable!: boolean;

  // Overridable Config
  title: string = '';
  // Headers: Config
  headers: { text: string; value: string }[] = [];
  initialHeaders: string[] = [];
  // Table Data: methods
  get items(): T[] {
    return [];
  }
  async fetchItems(): Promise<void> {}
  // Dialog controls: Config
  async rowActionDelete(id: number | string): Promise<ModelApiResponse | void> {
    return;
  }

  // Common methods
  async mounted() {
    this.initialiseDialogRowActionDelete();
    this.fetchItems();
    this.initialiseHeaders();
  }

  toolbarExtended: boolean = false;

  // Headers
  selectedHeaders: string[] = [];
  initialiseHeaders() {
    this.selectedHeaders = this.headers
      .filter((h) => this.initialHeaders.includes(h.value))
      .map((h) => h.value);
  }
  get showHeaders() {
    return this.headers.filter((h) => this.selectedHeaders.includes(h.value));
  }

  // Dialog controls
  dialogFields: boolean = false;
  dialogCreate: boolean = false;
  dialogRowActionDelete: { [id: string]: boolean } = {};

  initialiseDialogRowActionDelete() {
    for (const item of this.items) {
      this.$set(this.dialogRowActionDelete, item.id, false);
    }
  }

  async handleRowActionDeleteConfirm(id: number | string) {
    try {
      await this.rowActionDelete(id);

      this.$set(this.dialogRowActionDelete, id, false);
      createAlert(this.$store, {
        message: `${this.title} deleted.`,
        type: 'success',
      });
    } catch (e) {
      this.$set(this.dialogRowActionDelete, id, false);

      console.error(e);
      createAlert(this.$store, {
        message: `Failed to delete ${this.title}`,
        type: 'error',
      });
    }
  }

  // Status flags
  loading: boolean = false;
  error: boolean = false;
  serverItemIdsToDisplay: (string | number)[] = [];
  search: string = '';
  totalItems: number = 0;
  options: VuetifyTableOptions = {
    sortBy: [],
    sortDesc: [],
    page: 1,
    itemsPerPage: 10,
  };

  get apiOptions() {
    let sort = '';
    if (this.options.sortBy.length && this.options.sortDesc.length) {
      const sortDir = this.options.sortDesc[0] ? 'DESC' : 'ASC';
      sort = this.options.sortBy[0] + ':' + sortDir;
    }

    return {
      query: this.search,
      sort: sort,
      page: this.options.page || 1,
      pageSize: this.options.itemsPerPage || 25,
    };
  }

  @Watch('search')
  @Emit('options-changed')
  onSearchChange() {
    this.options.page = 1;
    this.fetchItems();
    return this.apiOptions;
  }

  @Watch('options', { deep: true })
  @Emit('options-changed')
  onOptionsChange() {
    this.fetchItems();
    return this.apiOptions;
  }

  getStateColor(state: ContactDataStateEnum | MemberRoleDataStateEnum): string {
    return state === ContactDataStateEnum.Enabled ? 'green' : 'orange';
  }
  getMStateColor(
    state: ContactDataManagementStateEnum | MemberRoleDataManagementStateEnum
  ): string {
    return state === ContactDataManagementStateEnum.Managed
      ? 'green'
      : 'orange';
  }
}
