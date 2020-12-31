import {
  ContactDataManagementStateEnum,
  ContactDataStateEnum,
  MemberRoleDataManagementStateEnum,
  MemberRoleDataStateEnum,
  ModelApiResponse,
} from '@api/models';
import {
  Vue,
  Component,
  Watch,
  Prop,
  PropSync,
  Emit,
} from 'vue-property-decorator';
import { createAlert } from '~/common/alert';

interface IDwise {
  id: number | string;
}

interface VuetifyTableOptions {
  sortBy: string[];
  sortDesc: string[];
  page: number;
  itemsPerPage: number;
}

@Component
export default class BaseTable<T extends IDwise> extends Vue {
  @Prop(Boolean) readonly allowCreation!: boolean;
  @Prop(Boolean) readonly searchable!: boolean;

  loading: boolean = false;
  error: boolean = false;
  serverItemIdsToDisplay: (string | number)[] = [];

  // Config
  title: string = '';
  headers: { text: string; value: string }[] = [];

  // Overrideable
  get items(): T[] {
    return [];
  }

  async fetchItems(): Promise<void> {}

  async mounted() {
    this.initialiseDialogRowActionDelete();
    this.fetchItems();
  }

  dialogCreate: boolean = false;
  dialogRowActionDelete: { [id: string]: boolean } = {};

  initialiseDialogRowActionDelete() {
    for (const item of this.items) {
      this.$set(this.dialogRowActionDelete, item.id, false);
    }
  }

  // Overrideable
  async rowActionDelete(id: number | string): Promise<ModelApiResponse | void> {
    return;
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
