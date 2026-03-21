<style>
  body { position: relative; }
  body > *:not(.site-bg) { position: relative; z-index: 1; }

  body.site-bg-active {
    background: transparent !important;
  }

  body.site-bg-active .background-container {
    background-image: none !important;
  }

  body.site-bg-active .background-container::before {
    background: transparent !important;
  }

  body.site-bg-active .pointer-events-none.fixed.inset-0 {
    display: none !important;
  }

  .site-bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    overflow: hidden;
    pointer-events: none;
  }

  .site-bg::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.35));
    z-index: 2;
  }

  .site-slide {
    position: absolute;
    inset: 0;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    opacity: 0;
    transition: opacity 1.8s ease-in-out;
    z-index: 1;
    filter: saturate(1.05) contrast(1.05);
  }

  .site-slide.active {
    opacity: 1;
  }
</style>

<div class="site-bg" aria-hidden="true">
  <div class="site-slide active" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1920&q=80');"></div>
  <div class="site-slide" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1920&q=80');"></div>
  <div class="site-slide" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80');"></div>
  <div class="site-slide" style="background-image: url('https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1920&q=80');"></div>
  <div class="site-slide" style="background-image: url('https://images.unsplash.com/photo-1444653614773-995cb1ef9efa?auto=format&fit=crop&w=1920&q=80');"></div>
  <div class="site-slide" style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=1920&q=80');"></div>
  <div class="site-slide" style="background-image: url('https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1920&q=80');"></div>
  <div class="site-slide" style="background-image: url('https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg');"></div>
  <div class="site-slide" style="background-image: url('https://images.pexels.com/photos/3184360/pexels-photo-3184360.jpeg');"></div>
</div>

<script>
  document.body.classList.add('site-bg-active');
  (function () {
    const slides = document.querySelectorAll('.site-bg .site-slide');
    if (!slides.length) return;
    let current = 0;
    setInterval(() => {
      slides[current].classList.remove('active');
      current = (current + 1) % slides.length;
      slides[current].classList.add('active');
    }, 6000);
  })();
</script>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\components\background-slider.blade.php ENDPATH**/ ?>