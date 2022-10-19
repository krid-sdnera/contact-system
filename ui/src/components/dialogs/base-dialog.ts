import { Component, Prop, PropSync, Vue, Watch } from 'vue-property-decorator';
import * as ui from '~/store/ui';
import { createAlert } from '~/common/helper-factories';

interface IDwise {
  id: number | string;
}

type DialogMode = 'create' | 'update';

interface DialogMessages {
  title: string;
  success: string;
  failed: string;
  invalid: string;
}

interface DialogField<T> {
  name: keyof T;
  label: string;
  type: string;
  disabled?: boolean;
}

export type DialogFields<T> = (DialogField<T> | DialogField<T>[])[];

@Component
export default class BaseDialog<TData extends IDwise, TInput> extends Vue {
  // Default Props
  @Prop({ type: String, required: true }) mode!: DialogMode;
  @PropSync('open', Boolean) dialog!: boolean;
  @Prop({ type: Object, default: () => ({}) }) readonly data!: TData;

  // Overridable Config
  entityName: string = '';
  get customMessages(): Partial<Record<DialogMode, Partial<DialogMessages>>> {
    return {};
  }
  get fields(): DialogFields<TInput> {
    return [];
  }

  // Build input data functions
  async buildInputForCreate(): Promise<TInput> {
    return {} as TInput;
  }
  async buildInputForUpdate(_data: TData): Promise<TInput> {
    return {} as TInput;
  }

  // Persistance functions
  async persistCreate(_input: TInput): Promise<void> {}
  async persistUpdate(_data: TData, _input: TInput): Promise<void> {}

  // Common methods
  builtDataInput: TInput | null = null;
  originalChanged: boolean = false;

  async mounted() {}

  async initialiseInputObject() {
    this.originalChanged = false;

    if (this.checkMode('create')) {
      this.builtDataInput = await this.buildInputForCreate();
    } else {
      this.builtDataInput = await this.buildInputForUpdate(this.data);
    }
  }

  checkMode(modeComp: DialogMode) {
    return this.mode === modeComp;
  }

  get parsedFormFields(): DialogField<TInput>[][] {
    return this.fields.map((fieldData) => {
      if (Array.isArray(fieldData)) {
        return fieldData;
      }
      return [fieldData];
    });
  }

  get messages(): DialogMessages {
    const defaultMessages: Record<DialogMode, DialogMessages> = {
      create: {
        title: `Create ${this.entityName}`,
        success: `${this.entityName} created`,
        failed: `Failed to create ${this.entityName}`,
        invalid: `Create form has entered an invalid state, reload and try again.`,
      },
      update: {
        title: `Update ${this.entityName}`,
        success: `${this.entityName} updated`,
        failed: `Failed to update ${this.entityName}`,
        invalid: `Update form has entered an invalid state, reload and try again.`,
      },
    };

    // FYI: Object.assign doesn't handle deep objects.
    const messages = Object.assign(
      defaultMessages[this.mode],
      this.customMessages[this.mode] || {}
    );

    return messages;
  }

  get isAppUpdating(): boolean {
    return this.$store.getters[`${ui.namespace}/isAppUpdating`];
  }

  @Watch('dialog')
  handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, rebuild data
      this.initialiseInputObject();
    }
  }

  @Watch('data', { immediate: true, deep: true })
  handleDataInputUpdate(data: TInput) {
    if (!data) {
      // Assumption, the dialog has been opened but the underlying data doesn't
      // exist in the store. We should close the dialog and inform the user.
      createAlert(this.$store, {
        message: this.messages.invalid,
        type: 'error',
      });
      this.dialog = false;
      return;
    }
    if (this.builtDataInput !== null) {
      // Show warning that the underlying data has updated.
      // Do you want to overwrite?
      this.originalChanged = true;
      return;
    }

    this.initialiseInputObject();
  }

  async submitDialog() {
    if (!this.builtDataInput) {
      return;
    }

    try {
      if (this.checkMode('create')) {
        await this.persistCreate(this.builtDataInput);
      } else {
        await this.persistUpdate(this.data, this.builtDataInput);
      }

      createAlert(this.$store, {
        message: this.messages.success,
        type: 'success',
      });

      this.dialog = false;
      this.builtDataInput = null;
      this.originalChanged = false;
    } catch (e) {
      createAlert(this.$store, {
        message: this.messages.failed,
        type: 'error',
      });
      console.error(e);
      // TODO: We may have to handle this error.
    }
  }

  closeDialog() {
    this.dialog = false;
  }
}
