<?php if (! $__env->hasRenderedOnce('d8bfe568-8400-4952-bd55-75334d89d2a3')): $__env->markAsRenderedOnce('d8bfe568-8400-4952-bd55-75334d89d2a3'); ?>
<style>
    .support-hero {
        position: relative;
        overflow: hidden;
        isolation: isolate;
    }

    .support-hero .support-hero-content {
        position: relative;
        z-index: 3;
    }

    .support-hero .support-hero-slider {
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;
    }

    .support-hero .support-hero-slide {
        position: absolute;
        inset: -2%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        opacity: 0;
        transform: scale(1.08);
        transition: opacity 1.2s ease-in-out, transform 8s ease-out;
        filter: saturate(1.08) contrast(1.05);
    }

    .support-hero .support-hero-slide.active {
        opacity: 1;
        transform: scale(1);
    }

    .support-hero .support-hero-overlay {
        position: absolute;
        inset: 0;
        z-index: 2;
    }

    .support-hero .support-hero-grain {
        position: absolute;
        inset: 0;
        z-index: 2;
        opacity: 0.14;
        mix-blend-mode: soft-light;
        background-image:
            radial-gradient(circle at 18% 22%, rgba(255, 255, 255, 0.34) 0%, transparent 42%),
            radial-gradient(circle at 81% 34%, rgba(255, 255, 255, 0.2) 0%, transparent 40%),
            radial-gradient(circle at 52% 78%, rgba(255, 255, 255, 0.12) 0%, transparent 35%);
    }

    .support-hero[data-hero-tone="indigo"] .support-hero-overlay {
        background:
            linear-gradient(120deg, rgba(30, 58, 138, 0.84), rgba(67, 56, 202, 0.82) 45%, rgba(30, 64, 175, 0.8));
    }

    .support-hero[data-hero-tone="blue"] .support-hero-overlay {
        background:
            linear-gradient(120deg, rgba(30, 58, 138, 0.84), rgba(30, 64, 175, 0.82) 45%, rgba(29, 78, 216, 0.8));
    }

    .support-hero[data-hero-tone="emerald"] .support-hero-overlay {
        background:
            linear-gradient(120deg, rgba(6, 78, 59, 0.85), rgba(4, 120, 87, 0.82) 46%, rgba(6, 95, 70, 0.8));
    }

    .support-hero[data-hero-tone="teal"] .support-hero-overlay {
        background:
            linear-gradient(120deg, rgba(19, 78, 74, 0.86), rgba(15, 118, 110, 0.83) 46%, rgba(13, 148, 136, 0.8));
    }

    .support-hero[data-hero-tone="purple"] .support-hero-overlay {
        background:
            linear-gradient(120deg, rgba(88, 28, 135, 0.85), rgba(107, 33, 168, 0.82) 46%, rgba(91, 33, 182, 0.8));
    }

    .support-hero[data-hero-tone="orange"] .support-hero-overlay {
        background:
            linear-gradient(120deg, rgba(124, 45, 18, 0.86), rgba(154, 52, 18, 0.84) 44%, rgba(194, 65, 12, 0.8));
    }

    .support-hero[data-hero-tone="red"] .support-hero-overlay {
        background:
            linear-gradient(120deg, rgba(127, 29, 29, 0.85), rgba(185, 28, 28, 0.82) 46%, rgba(153, 27, 27, 0.8));
    }

    .support-hero[data-hero-tone="slate"] .support-hero-overlay {
        background:
            linear-gradient(120deg, rgba(15, 23, 42, 0.86), rgba(30, 41, 59, 0.84) 44%, rgba(31, 41, 55, 0.82));
    }

    @media (prefers-reduced-motion: reduce) {
        .support-hero .support-hero-slide {
            transition: none;
            transform: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const intervalDuration = prefersReducedMotion ? 12000 : 7000;

        document.querySelectorAll('[data-support-hero]').forEach(function (hero) {
            const slides = hero.querySelectorAll('.support-hero-slide');
            if (slides.length < 2) return;

            let activeIndex = 0;
            setInterval(function () {
                slides[activeIndex].classList.remove('active');
                activeIndex = (activeIndex + 1) % slides.length;
                slides[activeIndex].classList.add('active');
            }, intervalDuration);
        });
    });
</script>
<?php endif; ?>

<div class="support-hero-slider" aria-hidden="true">
    <div class="support-hero-slide active" style="background-image: url('<?php echo e(asset('images/photo-154.avif')); ?>');"></div>
    <div class="support-hero-slide" style="background-image: url('<?php echo e(asset('images/photo-15.avif')); ?>');"></div>
    <div class="support-hero-slide" style="background-image: url('<?php echo e(asset('images/services.jpg')); ?>');"></div>
    <div class="support-hero-slide" style="background-image: url('<?php echo e(asset('images/zabra.avif')); ?>');"></div>
    <div class="support-hero-overlay"></div>
    <div class="support-hero-grain"></div>
</div>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\components\support-hero-slider.blade.php ENDPATH**/ ?>