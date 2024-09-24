import { useStorage } from '@vueuse/core';
import type { JwtData, JwtErrorResponse } from '~/lib/ContactSystem/Client/src';

interface AuthToken {
  tokens: { auth: string; refresh: string } | null;
}

function useAuthStorage() {
  const tokenStorage = useStorage<AuthToken>('authToken', { tokens: null });

  return {
    tokens: tokenStorage,
    isLoggedIn: computed(
      () =>
        typeof tokenStorage.value.tokens?.auth === 'string' &&
        typeof tokenStorage.value.tokens?.refresh === 'string'
    ),
    setTokens(newValues: { auth: string; refresh: string }) {
      console.debug('AUTH STORE setting tokens');
      tokenStorage.value.tokens = {
        auth: newValues.auth,
        refresh: newValues.refresh,
      };
    },
    removeTokens() {
      console.debug('AUTH STORE removing tokens');
      tokenStorage.value.tokens = null;
    },
  };
}

// It is not recommended to call `useRoute()` from within nuxt middleware.
export function useMiddlewareAuth() {
  const authStorage = useAuthStorage();

  return {
    isLoggedIn: authStorage.isLoggedIn,
  };
}

export function useAuth() {
  const authStorage = useAuthStorage();
  const route = useRoute();
  const router = useRouter();

  watch(
    authStorage.tokens,
    (newVal, oldVal) => {
      // If an authToken just got UNset, we want to redirct the user to the login page.
      if (oldVal.tokens !== null && newVal.tokens === null) {
        if (route.path === `/login`) {
          // Current page is /login, let the user enter their details.
          return;
        }

        goToLoginCaptureFromParam();
      }

      // The authToken value changed (newly set or overwritten), we want to redirct the user the page they were viewing.
      // But only if the current route is /login.
      if (route.path !== `/login`) {
        // Current page is NOT /login, let the user continue browsing.
        return;
      }

      goToFromParam();
    },
    { deep: true }
  );

  function doLogout() {
    console.debug('AUTH logout, remove tokens');

    authStorage.removeTokens();

    goToLoginCaptureFromParam();
  }

  return {
    isLoggedIn: authStorage.isLoggedIn,
    useLogin() {
      const pending = ref<boolean>(false);
      const error = ref<boolean>(false);
      const errorMessage = ref<string>('');

      return {
        pending,
        error,
        errorMessage,
        submit(options: { username: string; password: string }) {
          pending.value = true;
          error.value = false;
          errorMessage.value = '';

          const promise = useApi().auth.getJWT({
            jwtInput: {
              username: options.username,
              password: options.password,
            },
          });

          promise
            .then((payload) => {
              if (isJwtData(payload)) {
                pending.value = false;
                error.value = false;

                authStorage.setTokens({
                  auth: payload.token,
                  refresh: payload.refreshToken,
                });
                return;
              }

              pending.value = false;
              error.value = true;
              errorMessage.value = payload.message;
            })
            .catch((error) => {
              pending.value = false;
              error.value = true;
              errorMessage.value =
                error.status === 401
                  ? `Username and password are incorrect.`
                  : 'Unknown error occurred';
            });
        },
      };
    },
    doLogout,
    goToFromParam,
    goToLoginCaptureFromParam,
    getAuthToken(): string | null {
      return authStorage.tokens.value.tokens?.auth || null;
    },
    async refreshToken() {
      console.debug('AUTH refreshing token');
      if (
        !authStorage.isLoggedIn ||
        !authStorage.tokens.value.tokens?.refresh
      ) {
        console.log('AUTH no token to refresh, logout');
        doLogout();
        return;
      }

      try {
        const payload = await useApi().auth.refreshJWT({
          refreshToken: authStorage.tokens.value.tokens.refresh,
        });

        if (isJwtData(payload)) {
          console.debug('AUTH refreshed token');
          authStorage.setTokens({
            auth: payload.token,
            refresh: payload.refreshToken,
          });
        } else {
          console.debug('AUTH refresh token failed, logout');
          doLogout();
        }

        // Don't tell the user that we refreshed their token.
        // It should be transparent to them.
      } catch (e) {
        // Tell user that we could not refresh the token.
        doLogout();
      }
    },
  };
}

function isJwtData(data: JwtErrorResponse): data is JwtData {
  return 'token' in data && 'refreshToken' in data;
}

function goToFromParam() {
  const route = useRoute();
  const router = useRouter();
  const fromQuery = Array.isArray(route.query.from)
    ? route.query.from.filter((x) => !x?.startsWith('/login'))[0]
    : route.query.from;

  if (fromQuery) {
    router.replace(fromQuery);
  } else {
    router.replace(`/`);
  }
}

function goToLoginCaptureFromParam() {
  const route = useRoute();
  const router = useRouter();
  // Capture the current path and store as the from param

  // If the current route is /login we dont want to add any more values.
  if (route.path === `/login`) {
    return;
  }

  router.replace({
    path: `/login`,
    query: {
      from: router.currentRoute.value.fullPath,
    },
  });
}
