import { useStorage } from '@vueuse/core';
import type { JwtData, JwtErrorResponse } from '~/lib/ContactSystem/Client/src';

interface AuthToken {
  tokens: { auth: string; refresh: string } | null;
}

export function useAuth() {
  const authToken = useStorage<AuthToken>('authToken', { tokens: null });
  const route = useRoute();
  const router = useRouter();

  watch(authToken, (newVal, oldVal) => {
    // If an authToken just got set, we want to redirct the user to the page they were viewing.
    if (oldVal.tokens === null && newVal.tokens !== null) {
      // But only if the current route is /login.
      if (route.path !== `/login`) {
        return;
      }

      const fromQuery = Array.isArray(route.query.from)
        ? route.query.from[0]
        : route.query.from;

      if (fromQuery) {
        router.replace(fromQuery);
      } else {
        router.replace(`/`);
      }
    }

    // If an authToken just got UNset, we want to redirct the user to the login page.
    if (oldVal.tokens !== null && newVal.tokens === null) {
      // But only if the current route is NOT /login.
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
  });

  return {
    isLoggedIn: computed(() => authToken.value.tokens !== null),
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

                authToken.value.tokens = {
                  auth: payload.token,
                  refresh: payload.refreshToken,
                };
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
    doLogout() {
      authToken.value.tokens = null;
    },
    requireAuthElseRedirect() {
      if (authToken.value === null) {
        router.replace({
          path: `/login`,
          query: {
            from: router.currentRoute.value.fullPath,
          },
        });
      }
    },
    tokens: computed(() => {
      return {
        auth: authToken.value.tokens?.auth || null,
        refresh: authToken.value.tokens?.refresh || null,
      };
    }),
    async refreshToken() {
      console.log('Refreshing Token');
      const tokens = authToken.value.tokens;
      if (!tokens) {
        this.doLogout();
        return;
      }

      try {
        const payload = await useApi().auth.refreshJWT({
          refreshToken: tokens.refresh,
        });

        if (isJwtData(payload)) {
          authToken.value.tokens = {
            auth: payload.token,
            refresh: payload.refreshToken,
          };
        } else {
          this.doLogout();
        }

        // Don't tell the user that we refreshed their token.
        // It should be transparent to them.
      } catch (e) {
        // Tell user that we could not refresh the token.
        this.doLogout();
      }
    },
  };
}

function isJwtData(data: JwtErrorResponse): data is JwtData {
  return 'token' in data && 'refreshToken' in data;
}
