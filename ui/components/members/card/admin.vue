<script setup lang="ts">
import type { MemberData } from '~/server/types/member';

const props = defineProps<{
  member: MemberData | null;
}>();

const dialogUpdate = ref<boolean>(false);
function itemUpdate() {
  dialogUpdate.value = true;
}
function itemUpdated(id: number) {
  dialogUpdate.value = false;
}

const dialogDelete = ref<boolean>(false);
function itemDelete() {
  dialogDelete.value = true;
}
function itemDeleted(id: number) {
  dialogDelete.value = false;
}
</script>

<template>
  <v-card v-if="props.member">
    <MembersUpdate
      v-model="dialogUpdate"
      @updated="itemUpdated"
      :member="props.member"
    ></MembersUpdate>

    <MembersDelete
      v-model="dialogDelete"
      @updated="itemDeleted"
      :member="props.member"
    ></MembersDelete>

    <v-card-title>Admin Actions</v-card-title>

    <v-card-text>
      <v-chip class="mb-1">
        {{ $filters.capitalize(props.member.managementState) }}
      </v-chip>
      <v-chip v-if="props.member.expiry" class="mb-1">{{
        props.member.expiry
      }}</v-chip>
    </v-card-text>
    <v-card-text>
      <v-chip v-if="props.member.autoUpgradeEnabled === true" class="mb-1"
        >Auto upgrade enabled</v-chip
      >
      <v-chip v-else class="mb-1 grey--text text--darken-3" color="warning">
        Auto upgrade disabled
      </v-chip>
    </v-card-text>

    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
        variant="tonal"
        icon="mdi-pencil"
        color="warning"
        @click="itemUpdate()"
      ></v-btn>
      <v-btn
        variant="tonal"
        icon="mdi-delete"
        color="error"
        @click="itemDelete()"
      ></v-btn>
    </v-card-actions>

    <template v-if="props.member.metaInvite">
      <template v-if="props.member.metaInvite.type === 'inviteActive'">
        <v-card-text>
          <OverridableText label="Invitation process active">
            <v-icon class="red--text">mdi-close</v-icon>
            <span>Awaiting member completion</span>
          </OverridableText>

          <OverridableText label="This invite will expire on">
            {{ $filters.date(props.member.metaInvite.expiryDate) }}
            ({{ $filters.duration(props.member.metaInvite.expiryDate) }})
          </OverridableText>

          <OverridableText label="Status">
            {{ props.member.metaInvite.status }}
          </OverridableText>
        </v-card-text>
      </template>
      <template
        v-if="props.member.metaInvite.type === 'inviteAwaitingApproval'"
      >
        <v-card-text>
          <OverridableText label="Invitation process active">
            <v-icon class="green--text">mdi-check</v-icon>
            Member has completed invite<br />
            <v-icon class="red--text">mdi-close</v-icon>
            Awaiting Group Leader approval
          </OverridableText>

          <OverridableText label="This invite was submitted on">
            {{ $filters.date(props.member.metaInvite.submittedDate) }}
            ({{ $filters.duration(props.member.metaInvite.submittedDate) }})
          </OverridableText>

          <OverridableText label="Level Description">
            {{ props.member.metaInvite.levelDescription }}
          </OverridableText>
        </v-card-text>
      </template>
    </template>
  </v-card>

  <!-- Loading Skeleton -->
  <v-skeleton-loader v-else type="article"></v-skeleton-loader>
</template>
