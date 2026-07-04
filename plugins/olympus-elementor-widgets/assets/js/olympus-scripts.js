(function($) {
    "use strict";

    const OlympusHandler = {

        init: function() {
            if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
                console.warn('Olympus: GSAP or ScrollTrigger not found.');
                return;
            }

            gsap.registerPlugin(ScrollTrigger);

            this.setupLoader();
            this.setupHero();
            this.setupDarkMode();
            this.setupNav();
            this.setupReveals();

            $(window).on('load', function() {
                ScrollTrigger.refresh();
            });
        },

        setupLoader: function() {
            const $loader = $('#olympus-loader');
            if (!$loader.length) return;

            const hideLoader = () => {
                $loader.addClass('out');
                setTimeout(() => $loader.hide(), 950);
            };

            const $vid = $('.ol-hero-video');
            if ($vid.length) {
                $vid[0].addEventListener('canplay', hideLoader, { once: true });
                $vid[0].addEventListener('error', hideLoader, { once: true });
            }
            setTimeout(hideLoader, 5000);
        },

        setupHero: function() {
            const $heroWrap = $('.ol-hero-wrap');
            const $vid = $('.ol-hero-video');
            if (!$heroWrap.length || !$vid.length) return;

            const vid = $vid[0];
            const scrubValue = parseFloat($heroWrap.attr('data-scrub')) || 0.25;

            const setupScrub = () => {
                if (!vid.duration) return;
                ScrollTrigger.create({
                    trigger: '.ol-hero-wrap',
                    start: 'top top',
                    end: 'bottom bottom',
                    scrub: scrubValue,
                    onUpdate(self) {
                        if (vid.readyState >= 2) {
                            vid.currentTime = vid.duration * self.progress;
                        }
                    }
                });
            };

            vid.addEventListener('loadedmetadata', setupScrub);
            if (vid.readyState >= 1) setupScrub();

            gsap.to('.ol-hero-content', {
                yPercent: -28,
                opacity: 0,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.ol-hero-wrap',
                    start: 'top top',
                    end: '28% top',
                    scrub: true
                }
            });

            gsap.to('.ol-scroll-cue', {
                opacity: 0,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.ol-hero-wrap',
                    start: 'top top',
                    end: '6% top',
                    scrub: true
                }
            });

            gsap.fromTo('.ol-hero-video',
                { scale: 1 },
                {
                    scale: 1.07,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: '.ol-hero-wrap',
                        start: 'top top',
                        end: 'bottom bottom',
                        scrub: true
                    }
                }
            );
        },

        setupDarkMode: function() {
            const $siteBody = $('.ol-sec').first(); // Target first section to trigger dark mode
            if (!$siteBody.length) return;

            ScrollTrigger.create({
                trigger: $siteBody,
                start: 'top 88%',
                onEnter()     { $('html').attr('data-theme', 'dark'); },
                onLeaveBack() { $('html').removeAttr('data-theme'); }
            });
        },

        setupNav: function() {
            const $nav = $('.olympus-nav');
            const $hero = $('.ol-hero-wrap');
            if (!$nav.length || !$hero.length) return;

            ScrollTrigger.create({
                trigger: $hero,
                start: 'top top',
                end: 'bottom top',
                onLeave()     { $nav.addClass('bg'); },
                onEnterBack() { $nav.removeClass('bg'); }
            });
        },

        setupReveals: function() {
            $('.ol-reveal').each(function() {
                const el = this;
                gsap.fromTo(el,
                    { opacity: 0, y: 36 },
                    {
                        opacity: 1, y: 0,
                        duration: 1,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 87%',
                            toggleActions: 'play none none none'
                        }
                    }
                );
            });
        },

        setTheme: function(theme) {
            if (theme === 'dark') {
                $('html').attr('data-theme', 'dark');
            } else {
                $('html').removeAttr('data-theme');
            }
        }
    };

    $(window).on('elementor/frontend/init', function() {
        OlympusHandler.init();

        if (elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction('frontend/element_ready/olympus_wrapper.default', function($scope) {
                const theme = $scope.find('.ol-theme-data').data('theme');
                OlympusHandler.setTheme(theme);
            });
        }
    });

})(jQuery);
