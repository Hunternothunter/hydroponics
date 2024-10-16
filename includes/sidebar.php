<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link collapsed" href="gauge-index.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="controls.php">
        <i class="fa-solid fa-sliders"></i>
        <span>Controls</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="historical-data.php">
        <i class="fa-regular fa-file-zipper"></i>
        <span>Historical Data</span>
      </a>
    </li>
    <li class="nav-heading">Account Settings</li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="users-profile.php">
        <i class="bi bi-person"></i>
        <span>Profile</span>
      </a>
    </li>
  </ul>
</aside>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var navLinks = document.querySelectorAll('.nav-link');

    var currentPath = window.location.pathname.split('/').pop();
    navLinks.forEach(function(link) {
      if (link.getAttribute('href') === currentPath) {
        link.classList.remove('collapsed');
      } else {
        link.classList.add('collapsed');
      }
    });

    navLinks.forEach(function(link) {
      link.addEventListener('click', function(event) {
        navLinks.forEach(function(link) {
          link.classList.add('collapsed');
        });
        event.currentTarget.classList.remove('collapsed');
      });
    });
  });

  // $(document).ready(function() {
  //   // Highlight the link based on the current URL
  //   var currentPath = window.location.pathname.split('/').pop();

  //   $('.nav-link').each(function() {
  //     if ($(this).attr('href') === currentPath) {
  //       $(this).removeClass('collapsed');
  //     } else {
  //       $(this).addClass('collapsed');
  //     }
  //   });

  //   // Handle link clicks to update the active link and load content via AJAX
  //   $('.nav-link').on('click', function(event) {
  //     event.preventDefault(); // Prevent the default link click behavior

  //     // Add 'collapsed' class to all links and remove from the clicked link
  //     $('.nav-link').addClass('collapsed');
  //     $(this).removeClass('collapsed');

  //     var url = $(this).attr('href');

  //     // Load content via AJAX
  //     $.ajax({
  //       url: url,
  //       success: function(data) {
  //         // Update the content of a specific div with the data from the requested URL
  //         $('#main').html($(data).find('#main').html());
  //         // location.reload();
  //         $('.nav-link:not(.collapsed)').click();

  //         // Optionally update the URL in the browser without reloading the page
  //         window.history.pushState({
  //           path: url
  //         }, '', url);
  //       },
  //       error: function() {
  //         console.log('Error loading content.');
  //       }
  //     });
  //   });

  //   // Handle browser back and forward buttons
  //   window.onpopstate = function(event) {
  //     var currentPath = window.location.pathname.split('/').pop();
  //     $('.nav-link').each(function() {
  //       if ($(this).attr('href') === currentPath) {
  //         $(this).removeClass('collapsed');
  //       } else {
  //         $(this).addClass('collapsed');
  //       }
  //     });
  //   };
  // });
</script>