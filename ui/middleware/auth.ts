export default defineNuxtRouteMiddleware((to, from) => {
  const { isLoggedIn } = useMiddlewareAuth();
  const { createAlert } = useAlerts();

  // trying to access a restricted page + not logged in redirect to login page
  if (!isLoggedIn.value) {
    createAlert({
      message: 'Session expired. Please login again',
      type: 'error',
      deduplicate: true,
    });

    return navigateTo('/login');
  }
});
