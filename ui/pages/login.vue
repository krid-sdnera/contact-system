<script setup lang="ts">
useHead({
  title: 'Login',
});

definePageMeta({
  breadcrumbs: useBuildBreadcrumbs([{ to: `/`, label: `Login` }]),
});

const { isLoggedIn, useLogin } = useAuth();
const { pending, error, errorMessage, submit } = useLogin();

const username = ref<string>('');
const password = ref<string>('');
function handleLogin() {
  submit({
    username: username.value,
    password: password.value,
  });
}
const runtime = useRuntimeConfig();
</script>

<template>
  <v-row>
    <v-col cols="6" md="6" offset-md="3" sm="12">
      <v-card>
        <v-card-title class="headline">Login</v-card-title>
        <v-card-text>
          <span v-if="isLoggedIn">You are already logged in</span>
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
