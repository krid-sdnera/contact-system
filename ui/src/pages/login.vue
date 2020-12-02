<template>
  <div>
    <v-text-field label="Username" name="username" v-model="username">
    </v-text-field>
    <v-text-field
      label="Password"
      type="password"
      name="password"
      v-model="password"
      autocomplete="off"
    ></v-text-field>
    <v-btn @click="handleLogin" :loading="loading">Login</v-btn>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Watch } from 'vue-property-decorator';
import { MemberData } from '@api/models';
import * as auth from '~/store/auth';

@Component
export default class LoginPage extends Vue {
  username: string = '';
  password: string = '';
  loading: boolean = false;
  error: boolean = false;

  async handleLogin(): Promise<void> {
    this.loading = true;
    try {
      await this.$store.dispatch(`${auth.namespace}/login`, {
        username: this.username,
        password: this.password,
      });
      this.error = false;

      this.$router.go(-1);
    } catch (e) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  }
}
</script>
