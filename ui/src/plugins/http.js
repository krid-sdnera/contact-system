export default function ({ $http, env }, inject) {
  // Create a custom HTTP instance
  const $api = $http.create({
    // See https://github.com/sindresorhus/ky#options
  });

  // Set baseURL to something different
  $api.setBaseURL(env.API_BASE);
  $api.setHeader('x-auth-token', env.API_TOKEN);

  // Inject to context as $api
  inject('api', $api);
}
