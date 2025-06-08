document.addEventListener('DOMContentLoaded', function () {
  const userId = window.userId; // Make sure this is set in your Blade template

  if (!window.Echo || !userId) return;

  // Listen for task assignments
  window.Echo.private(`user.${userId}`)
      .listen('TaskAssigned', function (e) {
          toast.success(`New task assigned: ${e.title}`, {
              duration: 5000,
          });
      });

  // Listen for project status updates
  window.Echo.private('project.*')
      .listen('ProjectStatusUpdated', function (e) {
          toast.info(`Project "${e.name}" status updated to ${e.status}`, {
              duration: 5000,
          });
      });

  // Listen for new messages
  window.Echo.private('project.*')
      .listen('NewMessage', function (e) {
          toast(`New message from ${e.user.name}`, {
              duration: 5000,
              icon: '💬',
          });
      });

  // Optional cleanup on page unload
  window.addEventListener('beforeunload', function () {
      window.Echo.leave(`user.${userId}`);
      window.Echo.leave('project.*');
  });
});

/*Ensure window.userId is defined in your Blade view:


<script>window.userId = {{ auth()->user()->id }};</script>
This will make the user ID available for the Echo listener to use. You can place this script tag in your Blade template where you include your JavaScript files, typically in the <head> or just before the closing </body> tag.
*/
// Ensure you have the following libraries installed:
// npm install laravel-echo pusher-js
// npm install toastify-js
// npm install toast
// npm install axios
// npm install world-countries
// npm install alpinejs
// npm install bootstrap
// npm install jquery
// npm install bootstrap-icons
// npm install bootstrap-vue
// npm install bootstrap-vue-3
// npm install bootstrap-vue-3-icons
