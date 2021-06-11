<template>
  <v-dialog v-model="dialog" persistent scrollable max-width="600px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" small v-bind="attrs" v-on="on">
        {{ btnLabel }}
        <v-icon right small>mdi-export</v-icon>
      </v-btn>
    </template>
    <v-card style="max-height: 90vh;">
      <v-card-title style="position: sticky;">
        Export Members
        <v-spacer></v-spacer>
        <v-btn icon dark @click="closeDialog">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col>
            Preparing to export {{ totalItems }} Members
            <span v-if="presetRole">from the {{ presetRole.name }} role</span>
            <span v-if="presetSection">
              from the {{ presetSection.name }} section
            </span>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <p>Member Fields ({{ selectedMemberFields.length }})</p>
            <ul class="mb-5">
              <li v-for="header in selectedMemberFields" :key="header.value">
                {{ header.text }}
              </li>
            </ul>
            <v-select
              v-model="selectedMemberFields"
              :items="availableMemberFields"
              label="Member fields to export"
              multiple
              return-object
            >
              <template v-slot:selection="{ index }">
                <span v-if="index === 0" class="grey--text caption">
                  {{ selectedMemberFields.length }} fields
                </span>
              </template>
            </v-select>
          </v-col>
          <v-col>
            <p>Contact Fields ({{ selectedContactFields.length }})</p>
            <ul class="mb-5">
              <li v-for="header in selectedContactFields" :key="header.value">
                {{ header.text }}
              </li>
            </ul>
            <v-select
              v-model="selectedContactFields"
              :items="availableContactFields"
              label="Contact fields to export"
              multiple
              return-object
            >
              <template v-slot:selection="{ index }">
                <span v-if="index === 0" class="grey--text caption">
                  {{ selectedContactFields.length }} fields
                </span>
              </template>
            </v-select>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="closeDialog">
          Cancel
        </v-btn>
        <v-btn color="blue darken-1" text @click="exportMembers">
          Export
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import {
  ContactData,
  MemberData,
  Members,
  RoleData,
  SectionData,
} from '@api/models';
import { Component, Prop, PropSync, Vue, Watch } from 'vue-property-decorator';
import { CSApiOptions } from '~/common/api-types';
import { VuetifyTableHeader } from '~/common/vuetify-types';
import * as contact from '~/store/contact';
import * as member from '~/store/member';

@Component
export default class DialogMemberExportComponent extends Vue {
  @PropSync('open', Boolean) dialog!: boolean;

  @Prop({ type: String, default: 'Export' }) readonly btnLabel!: string;
  @Prop(Object) readonly apiOptions!: CSApiOptions;
  @Prop({ type: Array, default: [] }) readonly presetMemberFields!: string[];
  @Prop({ type: Array, default: [] }) readonly presetContactFields!: string[];
  @Prop(Object) readonly presetRole: RoleData | undefined;
  @Prop(Object) readonly presetSection: SectionData | undefined;

  closeDialog() {
    this.dialog = false;
  }

  mounted() {
    // Don't load this data on mounted hook, for every page load.
    // Wait till the dialog is opened and the user wants this ui element.
  }

  @Watch('dialog')
  handleDialogChanged(dialog: boolean) {
    if (dialog === true) {
      // opening the dialog, rebuild data
      this.initialiseSelectedFields();
    }
  }

  initialiseSelectedFields() {
    this.selectedMemberFields = this.availableMemberFields.filter((h) =>
      this.presetMemberFields.includes(h.value)
    );
    this.selectedContactFields = this.availableContactFields.filter((h) =>
      this.presetContactFields.includes(h.value)
    );

    // Just fetch the first page to get the total items
    this.fetchMemberCount();
  }

  async exportMembers() {
    this.$store.commit('ui/startUpdateApiRequestInProgress', null, {
      root: true,
    });

    this.memberIdsToExport = [];
    const exportData = [];

    // Add field headings to export data.
    const fieldsToNames = (field: VuetifyTableHeader) => field.text;
    exportData.push([
      ...this.selectedMemberFields.map(fieldsToNames),
      ...this.selectedContactFields.map(fieldsToNames),
      ...this.selectedContactFields.map(fieldsToNames),
    ]);

    // Fetch Member lists.
    await this.fetchAllMembers();

    // Reduce to a unique list of member ids.
    const memberIds = this.memberIdsToExport.filter(
      (value, index, self) => self.indexOf(value) === index
    );

    // If there were contact fields selected, fetch their data.
    if (this.selectedContactFields.length > 0) {
      for (const memberId of memberIds) {
        await this.fetchContactsByMemberId(memberId);
      }
    }

    // Define mapping functions.
    const memberFieldMapper = (member: MemberData) => (
      field: VuetifyTableHeader<keyof MemberData | 'age'>
    ): string => {
      switch (field.value) {
        case 'address':
          return this.$options.filters?.address(member[field.value]);
        case 'dateOfBirth':
          return this.$options.filters?.date(member[field.value]);
        case 'phoneHome':
        case 'phoneMobile':
        case 'phoneWork':
          return this.$options.filters?.phone(member[field.value]);
        case 'age':
          return this.$options.filters?.duration(member.dateOfBirth, false);
        default:
          return String(member[field.value]) || '';
      }
    };

    const contactFieldMapper = (contact: ContactData | undefined) => (
      field: VuetifyTableHeader<keyof ContactData>
    ): string => {
      if (!contact) {
        return '';
      }
      switch (field.value) {
        case 'address':
          return this.$options.filters?.address(contact[field.value]);
        case 'phoneHome':
        case 'phoneMobile':
        case 'phoneWork':
          return this.$options.filters?.phone(contact[field.value]);
        default:
          return String(contact[field.value]) || '';
      }
    };

    // Start for each member.
    for (const memberId of memberIds) {
      const memberData = this.$store.getters[
        `${member.namespace}/getMemberById`
      ](memberId);

      const contactsData: ContactData[] = this.$store.getters[
        `${contact.namespace}/getContactsByMemberId`
      ](memberId);

      const primaryContact: ContactData | undefined = contactsData
        .filter((contact) => contact.primaryContact)
        .shift();
      const otherContact: ContactData | undefined = contactsData
        .filter((contact) => !contact.primaryContact)
        .shift();

      exportData.push([
        ...this.selectedMemberFields.map(memberFieldMapper(memberData)),
        ...this.selectedContactFields.map(contactFieldMapper(primaryContact)),
        ...this.selectedContactFields.map(contactFieldMapper(otherContact)),
      ]);
    }

    const escapeCSVCell = (item: any) =>
      typeof item === 'string' && item.indexOf(',') >= 0
        ? `"${item}"`
        : String(item);

    this.forceFileDownload(
      exportData.map((row) => row.map(escapeCSVCell).join(',')).join('\n'),
      `contacts-${this.$options.filters?.date(new Date(), 'ymd')}.csv`
    );

    this.$store.commit('ui/stopUpdateApiRequestInProgress', null, {
      root: true,
    });

    this.closeDialog();
  }

  forceFileDownload(data: string, title: string) {
    const url = window.URL.createObjectURL(
      new Blob([data], { type: 'text/csv' })
    );
    console.log(url);
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', title);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  totalItems: number = 0;

  selectedMemberFields: VuetifyTableHeader<keyof MemberData | 'age'>[] = [];
  availableMemberFields: VuetifyTableHeader<keyof MemberData | 'age'>[] = [
    { text: 'Firstname', value: 'firstname' },
    { text: 'Nickname', value: 'nickname' },
    { text: 'Lastname', value: 'lastname' },
    { text: 'Membership Number', value: 'membershipNumber' },
    { text: 'Address', value: 'address' },
    { text: 'Date of Birth', value: 'dateOfBirth' },
    { text: 'Age', value: 'age' },
    { text: 'Email', value: 'email' },
    { text: 'Home Phone', value: 'phoneHome' },
    { text: 'Mobile Phone', value: 'phoneMobile' },
    { text: 'Work Phone', value: 'phoneWork' },
    { text: 'Gender', value: 'gender' },
    { text: 'School Name', value: 'schoolName' },
    { text: 'School Year Level', value: 'schoolYearLevel' },
    { text: 'Auto Upgrade Enabled', value: 'autoUpgradeEnabled' },
  ];
  selectedContactFields: VuetifyTableHeader<keyof ContactData>[] = [];
  availableContactFields: VuetifyTableHeader<keyof ContactData>[] = [
    { text: 'Firstname', value: 'firstname' },
    { text: 'Lastname', value: 'lastname' },
    { text: 'Relationship', value: 'relationship' },
    { text: 'Occupation', value: 'occupation' },
    { text: 'Address', value: 'address' },
    { text: 'Email', value: 'email' },
    { text: 'Home Phone', value: 'phoneHome' },
    { text: 'Mobile Phone', value: 'phoneMobile' },
    { text: 'Work Phone', value: 'phoneWork' },
  ];

  memberIdsToExport: number[] = [];

  loading: boolean = false;
  error: boolean = false;

  async fetchAllMembers(): Promise<void> {
    this.loading = true;

    try {
      if (this.presetRole === undefined && this.presetSection === undefined) {
        this.memberIdsToExport = await this.$store.dispatch(
          `${member.namespace}/fetchAllMembers`,
          this.apiOptions
        );
      }
      if (this.presetRole !== undefined && this.presetSection === undefined) {
        this.memberIdsToExport = await this.$store.dispatch(
          `${member.namespace}/fetchAllMembersByRoleId`,
          { roleId: this.presetRole.id, ...this.apiOptions }
        );
      }
      if (this.presetRole === undefined && this.presetSection !== undefined) {
        this.memberIdsToExport = await this.$store.dispatch(
          `${member.namespace}/fetchAllMembersBySectionId`,
          { sectionId: this.presetSection.id, ...this.apiOptions }
        );
      }

      this.totalItems = this.memberIdsToExport.length;
      this.error = false;
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  async fetchMemberCount(): Promise<void> {
    this.loading = true;
    let payload: Members | null = null;
    try {
      if (this.presetRole === undefined && this.presetSection === undefined) {
        payload = await this.$store.dispatch(
          `${member.namespace}/fetchMembers`,
          { ...this.apiOptions, page: 1, pageSize: 1 }
        );
      }
      if (this.presetRole !== undefined && this.presetSection === undefined) {
        payload = await this.$store.dispatch(
          `${member.namespace}/fetchAllMembersByRoleId`,
          { roleId: this.presetRole.id, ...this.apiOptions }
        );
      }
      if (this.presetRole === undefined && this.presetSection !== undefined) {
        payload = await this.$store.dispatch(
          `${member.namespace}/fetchAllMembersBySectionId`,
          { sectionId: this.presetSection.id, ...this.apiOptions }
        );
      }
      if (!payload) {
        this.totalItems = 0;
        this.error = false;
        this.loading = false;
        return;
      }
      this.totalItems = payload.totalItems;
      this.error = false;
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }

  async fetchContactsByMemberId(memberId: number) {
    this.loading = true;

    try {
      await this.$store.dispatch(
        `${contact.namespace}/fetchContactsByMemberId`,
        { memberId }
      );
      this.error = false;
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }
}
</script>
