(function($) {
    "use strict";

    const OlympusFrontend = {
        init: function() {
            gsap.registerPlugin(ScrollTrigger);
            this.initThemeSwitch();
            this.initRevealAnimations();

            // Listen for Elementor widget readiness
            $(window).on('elementor/frontend/init', () => {
                elementorFrontend.hooks.addAction('frontend/element_ready/02-hero.default', this.initHero);
            });
        },

        initThemeSwitch: function() {
            const pageWrapper = $('.elementor-widget-01-page-wrapper');
            if (pageWrapper.length) {
                const darkTrigger = pageWrapper.data('dark-trigger');
                if (darkTrigger) {
                    ScrollTrigger.create({
                        trigger: '.site-body', // This will need to be a class we add to the main wrapper or just below hero
                        start: 'top 88%',
                        onEnter: () => $('html').attr('data-theme', 'dark'),
                        onLeaveBack: () => $('html').removeAttr('data-theme')
                    });
                }
            }
        },

        initRevealAnimations: function() {
            $('.reveal').each(function() {
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
        },

        initHero: function($scope) {
            const vid = $scope.find('.hero-video')[0];
            const scrubValue = $scope.data('scrub') || 0.25;
            const scaleEnd = $scope.data('scale') || 1.07;
            const fadePercent = $scope.data('fade-percent') || 28;

            if (vid) {
                const setupScrub = () => {
                    if (!vid.duration) return;
                    ScrollTrigger.create({
                        trigger: $scope.find('.hero-wrap')[0],
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

                // Parallax Content
                gsap.to($scope.find('.hero-content'), {
                    yPercent: -fadePercent,
                    opacity: 0,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: $scope.find('.hero-wrap')[0],
                        start: 'top top',
                        end: `${fadePercent}% top`,
                        scrub: true
                    }
                });

                // Scroll cue fade
                gsap.to($scope.find('.scroll-cue'), {
                    opacity: 0,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: $scope.find('.hero-wrap')[0],
                        start: 'top top',
                        end: '6% top',
                        scrub: true
                    }
                });

                // Video scale
                gsap.fromTo(vid,
                    { scale: 1 },
                    {
                        scale: scaleEnd,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: $scope.find('.hero-wrap')[0],
                            start: 'top top',
                            end: 'bottom bottom',
                            scrub: true
                        }
                    }
                );
            }
        }
    };

    $(window).on('load', () => {
        OlympusFrontend.init();
        ScrollTrigger.refresh();
    });

})(jQuery);
