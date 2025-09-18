document.addEventListener('DOMContentLoaded', function() {
  // Меню
  const menuButton = document.getElementById('logo_img');
  if (menuButton) {
      menuButton.addEventListener('click', toggleMenu);
  }

  // Активная страница в навигации
  highlightCurrentPage();
});

function toggleMenu() {
  document.getElementById("navbar").classList.toggle("active");
}

function highlightCurrentPage() {
  const navItems = document.querySelectorAll('#navbar li');
  navItems.forEach(item => {
      if (item.querySelector('a').href === window.location.href) {
          item.classList.add('current-page');
      }
  });
}

window.onclick = function(event) {
  if (!event.target.closest('#logo_img') && !event.target.closest('#navbar')) {
      const dropdowns = document.getElementsByClassName("nonactive");
      for (let i = 0; i < dropdowns.length; i++) {
          if (dropdowns[i].classList.contains('active')) {
              dropdowns[i].classList.remove('active');
          }
      }
  }
}
document.getElementById('menu_toggle').addEventListener('click', function() {
    document.getElementById('navbar').classList.toggle('active');
});