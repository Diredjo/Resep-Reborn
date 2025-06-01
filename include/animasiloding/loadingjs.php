<div id="page-transition">
  <div class="magic-text"><i class="fa-solid fa-broom"></i></div>
</div>

<script>
  const transitionEl = document.getElementById('page-transition');

  window.addEventListener('DOMContentLoaded', () => {
    transitionEl.classList.add('hide');
  });

  document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', e => {
      const href = link.getAttribute('href');
      if (
        href &&
        !href.startsWith('#') &&
        !href.includes('javascript:') &&
        link.target !== '_blank'
      ) {
        e.preventDefault();
        transitionEl.classList.remove('hide');
        document.body.classList.add('transitioning');
        setTimeout(() => {
          window.location.href = href;
        }, 100); //waktu 
      }
    });
  });


  const sidebar = document.getElementById("sidebar");
  const konten = document.getElementById("konten");
  const footer = document.getElementById("footer");

  function toggleSidebar() {
    sidebar.classList.toggle("collapsed");
    konten.classList.toggle("collapsed");
    footer.classList.toggle("collapsed");
  }
</script>