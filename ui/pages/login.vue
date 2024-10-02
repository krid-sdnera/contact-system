<script setup lang="ts">
import { promiseTimeout } from '@vueuse/core';

useHead({
  title: 'Login',
});

definePageMeta({
  breadcrumbs: useBuildBreadcrumbs([{ to: `/`, label: `Login` }]),
});

const { isLoggedIn, useLogin, goToFromParam } = useAuth();
const { pending, error, errorMessage, submit } = useLogin();

const username = ref<string>('');
const password = ref<string>('');
function handleLogin() {
  submit({
    username: username.value,
    password: password.value,
  });
}

watch(
  isLoggedIn,
  async () => {
    if (isLoggedIn.value === true) {
      await promiseTimeout(5000);
      goToFromParam();
    }
  },
  { immediate: true }
);
</script>

<template>
  <v-row>
    <v-col cols="12" md="6" offset-md="3">
      <v-card v-if="isLoggedIn">
        <v-card-text>
          <p>You are already logged in.</p>
          <p>Redirecting you in 5 seconds.</p>
        </v-card-text>
      </v-card>

      <v-card v-else>
        <v-card-title class="headline">Login</v-card-title>
        <v-card-text>
          <v-text-field
            label="Username"
            name="username"
            v-model="username"
            v-on:keyup.enter="handleLogin"
          >
          </v-text-field>
          <v-text-field
            label="Password"
            type="password"
            name="password"
            v-model="password"
            autocomplete="off"
            v-on:keyup.enter="handleLogin"
          ></v-text-field>

          <p v-if="errorMessage">{{ errorMessage }}</p>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            @click="handleLogin"
            :loading="pending"
            :color="error ? 'error' : 'primary'"
            >Login</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>
