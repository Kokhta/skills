(function($) {
    "use strict";

    const initAnimations = () => {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

        gsap.registerPlugin(ScrollTrigger);

        // 1. Loader Logic
        const loader = $('#ol-loader');
        const hideLoader = () => {
            loader.addClass('out');
            setTimeout(() => loader.hide(), 950);
        };

        // Hide loader after 5s or when video ready (handled in hero widget or here)
        setTimeout(hideLoader, 3000);

        // 2. Theme Toggle on Scroll
        const pageWrapper = $('.olympus-page-wrapper');
        if (pageWrapper.length) {
            ScrollTrigger.create({
                trigger: pageWrapper,
                start: 'top 88%',
                onEnter: () => $('html').attr('data-theme', 'dark'),
                onLeaveBack: () => $('html').removeAttr('data-theme')
            });
        }

        // 3. Reveal on Scroll
        $('.ol-reveal').each(function() {
            gsap.fromTo(this,
                { opacity: 0, y: 36 },
                {
                    opacity: 1, y: 0,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: this,
                        start: 'top 87%',
                        toggleActions: 'play none none none'
                    }
                }
            );
        });
    };

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', () => {
            initAnimations();
        });
    });

    $(document).ready(() => {
        if (!window.elementorFrontend) {
            initAnimations();
        }
    });

})(jQuery);
