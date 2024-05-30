<script setup lang="ts">
import type { ContactData } from '~/server/types/contact';
import type { MemberData } from '~/server/types/member';
import type { RoleData } from '~/server/types/role';
import type { SectionData } from '~/server/types/section';

const model = defineModel<boolean>();
const props = defineProps<{
  controls?: UiTableControls;
  fields?: {
    member?: string[];
    contact?: string[];
  };
  filters?: {
    role?: RoleData;
    section?: SectionData;
  };
}>();

watch(model, (newVal) => {
  if (newVal === true) {
    initialiseFieldSelection();
  }
});

onMounted(() => {
  initialiseFieldSelection();
});

function initialiseFieldSelection() {
  selectedMemberFields.value = availableMemberFields.filter((h) => {
    if (props.controls) {
      return props.controls?.columnDisplayMap.value?.[h.key];
    }

    return props.fields?.member?.includes(h.key) ?? false;
  });
  selectedContactFields.value = availableContactFields.filter((h) => {
    return props.fields?.contact?.includes(h.key) ?? false;
  });
}

const { $filters } = useNuxtApp();

const selectedMemberFields = ref<TableControlsHeader[]>([]);
const availableMemberFields: TableControlsHeader[] = [
  { title: 'ID', key: 'id', fixed: true },
  { title: 'State', key: 'state' },
  { title: 'MState', key: 'managementState' },
  { title: 'Firstname', key: 'firstname' },
  { title: 'Nickname', key: 'nickname' },
  { title: 'Lastname', key: 'lastname' },
  { title: 'Membership Number', key: 'membershipNumber' },
  {
    title: 'Address',
    key: 'address',
    value: (item: MemberData) => $filters.address(item.address),
  },
  {
    title: 'Date of Birth',
    key: 'dateOfBirth',
    value: (item: MemberData) => $filters.date(item.dateOfBirth),
  },
  {
    title: 'Age',
    key: 'age',
    value: (item: MemberData) => $filters.duration(item.dateOfBirth),
  },
  { title: 'Email', key: 'email' },
  { title: 'Home Phone', key: 'phoneHome' },
  { title: 'Mobile Phone', key: 'phoneMobile' },
  { title: 'Work Phone', key: 'phoneWork' },
  { title: 'Gender', key: 'gender' },
  { title: 'School Name', key: 'schoolName' },
  { title: 'School Year Level', key: 'schoolYearLevel' },
  {
    title: 'Auto Upgrade Enabled',
    key: 'autoUpgradeEnabled',
    value: (item: MemberData) => (item.autoUpgradeEnabled ? 'Yes' : 'No'),
  },
];
function getOrderedMemberFields() {
  return availableMemberFields.filter(
    (field) =>
      selectedMemberFields.value.findIndex((f) => f.key === field.key) !== -1
  );
}
const selectedContactFields = ref<TableControlsHeader[]>([]);
const availableContactFields: TableControlsHeader[] = [
  { title: 'ID', key: 'id', fixed: true },
  { title: 'State', key: 'state' },
  { title: 'MState', key: 'managementState' },
  { title: 'Firstname', key: 'firstname' },
  { title: 'Nickname', key: 'nickname' },
  { title: 'Lastname', key: 'lastname' },
  { title: 'Parent ID', key: 'parentId' },
  {
    title: 'Address',
    key: 'address',
    value: (item: ContactData) => $filters.address(item.address),
  },

  { title: 'Email', key: 'email' },
  { title: 'Home Phone', key: 'phoneHome' },
  { title: 'Mobile Phone', key: 'phoneMobile' },
  { title: 'Work Phone', key: 'phoneWork' },
  { title: 'Relationship', key: 'relationship' },
  { title: 'Occupation', key: 'occupation' },
];
function getOrderedContactFields() {
  return availableContactFields.filter(
    (field) =>
      selectedContactFields.value.findIndex((f) => f.key === field.key) !== -1
  );
}

async function exportMembers() {
  const orderedMemberFields = getOrderedMemberFields();
  const orderedContactFields = getOrderedContactFields();

  const outputData: string[][] = [];

  // Add heading row to export data.
  outputData.push([
    ...orderedMemberFields.map((field) => `member:${field.key}`),
    ...orderedContactFields.map((field) => `primary:${field.key}`),
    ...orderedContactFields.map((field) => `other:${field.key}`),
  ]);

  // Fetch all member data.
  const { useListAllMembers } = useMember();
  const { promise } = useListAllMembers({
    role: props.filters?.role,
    section: props.filters?.section,
  });

  const { members } = await promise;

  const memberContactMap: Record<
    string,
    { primary?: ContactData; other?: ContactData }
  > = {};

  // Fetch data for contacts of the members we have already fetched.
  if (selectedContactFields.value.length > 0) {
    const { useListAllContacts } = useContact();
    for (const member of members) {
      const { promise: contactPromise } = useListAllContacts({
        member,
      });

      const { contacts } = await contactPromise;

      memberContactMap[member.id] = {
        primary: contacts.filter((contact) => contact.primaryContact).shift(),
        other: contacts.filter((contact) => !contact.primaryContact).shift(),
      };
    }
  }

  // Loop through members to build up output CSV data.
  for (const member of members) {
    const primaryContact = memberContactMap[member.id]?.primary;
    const otherContact = memberContactMap[member.id]?.other;

    // Add data row to export data.
    outputData.push([
      ...orderedMemberFields.map((field) => fieldMapper(field, member)),
      ...orderedContactFields.map((field) =>
        fieldMapper(field, primaryContact)
      ),
      ...orderedContactFields.map((field) => fieldMapper(field, otherContact)),
    ]);
  }

  // Convert array format to final string.
  const outputCSV = outputData.map((row) => row.join(',')).join('\n');
  const filename = `contacts-${$filters?.date(new Date(), 'ymd')}.csv`;

  // Trigger download of final CSV.
  forceFileDownload(outputCSV, filename);

  model.value = false;
}

function fieldMapper(
  fieldConfig: TableControlsHeader,
  itemRef?: MemberData | ContactData
): string {
  if (!itemRef) {
    return '';
  }
  const item = unref(itemRef);

  if (fieldConfig.value) {
    return escapeCSVCell(fieldConfig.value(item));
  }

  return escapeCSVCell(item[fieldConfig.key as keyof typeof item]);
}

function escapeCSVCell(item: any): string {
  return typeof item === 'string' && item.includes(',')
    ? `"${item}"`
    : String(item);
}

function forceFileDownload(data: string, title: string) {
  const url = window.URL.createObjectURL(
    new Blob([data], { type: 'text/csv' })
  );
  const link = document.createElement('a');
  link.href = url;
  link.setAttribute('download', title);
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
</script>

<template>
  <v-dialog v-model="model" persistent scrollable max-width="600px">
    <template v-slot:activator="{ props }">
      <v-btn
        color="primary"
        small
        v-bind="props"
        icon="mdi-export"
        label="Export"
      />
    </template>
    <v-card style="max-height: 90vh">
      <v-card-title
        style="position: sticky"
        class="d-flex justify-space-between align-center"
      >
        <div>Export Members</div>
        <v-spacer></v-spacer>
        <v-btn icon="mdi-close" variant="text" @click="model = false"></v-btn>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col>
            Preparing to export Members
            <span v-if="props.filters?.role"
              >from the {{ props.filters.role.name }} role</span
            >
            <span v-if="props.filters?.section">
              from the {{ props.filters.section.name }} section
            </span>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-select
              v-model="selectedMemberFields"
              :items="
                availableMemberFields.map((field) => ({
                  ...field,
                  value: undefined,
                }))
              "
              label="Member fields to export"
              multiple
              chips
              return-object
            ></v-select>
          </v-col>
          <v-col>
            <v-select
              v-model="selectedContactFields"
              :items="
                availableContactFields.map((field) => ({
                  ...field,
                  value: undefined,
                }))
              "
              label="Contact fields to export"
              multiple
              chips
              return-object
            ></v-select>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="model = false">Cancel</v-btn>
        <v-btn @click="exportMembers">Export</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
