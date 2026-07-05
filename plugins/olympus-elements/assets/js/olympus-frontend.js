(function($) {
    "use strict";

    const OlympusHandler = {
        init: function() {
            elementorFrontend.hooks.addAction('frontend/element_ready/olympus-header.default', OlympusHandler.header);
            elementorFrontend.hooks.addAction('frontend/element_ready/olympus-loader.default', OlympusHandler.loader);
            elementorFrontend.hooks.addAction('frontend/element_ready/olympus-hero.default', OlympusHandler.hero);
            elementorFrontend.hooks.addAction('frontend/element_ready/olympus-intro.default', OlympusHandler.reveal);
            elementorFrontend.hooks.addAction('frontend/element_ready/olympus-pantheon.default', OlympusHandler.reveal);
            elementorFrontend.hooks.addAction('frontend/element_ready/olympus-myths.default', OlympusHandler.reveal);
            elementorFrontend.hooks.addAction('frontend/element_ready/olympus-oracle.default', OlympusHandler.reveal);
            elementorFrontend.hooks.addAction('frontend/element_ready/olympus-chronicles.default', OlympusHandler.reveal);

            // Global Scroll Triggers
            OlympusHandler.globalScroll();
        },

        header: function($scope) {
            const nav = $scope.find('.nav')[0];
            if (!nav) return;

            ScrollTrigger.create({
                trigger: '.ol-hero-wrap',
                start: 'top top',
                end: 'bottom top',
                onLeave: () => nav.classList.add('bg'),
                onEnterBack: () => nav.classList.remove('bg')
            });
        },

        loader: function($scope) {
            const loader = $scope.find('#loader')[0];
            if (!loader) return;

            const hideLoader = () => {
                loader.classList.add('out');
                setTimeout(() => loader.style.display = 'none', 950);
            };

            // In editor, we might want to skip or shorten this
            if (elementorFrontend.isEditMode()) {
                setTimeout(hideLoader, 500);
            } else {
                window.addEventListener('load', hideLoader);
                setTimeout(hideLoader, 5000); // Fallback
            }
        },

        hero: function($scope) {
            const vid = $scope.find('#hero-video')[0];
            const content = $scope.find('#hero-content')[0];
            const cue = $scope.find('#scroll-cue')[0];
            const wrap = $scope.find('.ol-hero-wrap')[0];

            if (!vid) return;

            const setupScrub = () => {
                if (!vid.duration) return;
                ScrollTrigger.create({
                    trigger: wrap,
                    start: 'top top',
                    end: 'bottom bottom',
                    scrub: 0.25,
                    onUpdate(self) {
                        if (vid.readyState >= 2) {
                            vid.currentTime = vid.duration * self.progress;
                        }
                    }
                });
            };

            vid.addEventListener('loadedmetadata', setupScrub);
            if (vid.readyState >= 1) setupScrub();

            if (content) {
                gsap.to(content, {
                    yPercent: -28,
                    opacity: 0,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: wrap,
                        start: 'top top',
                        end: '28% top',
                        scrub: true
                    }
                });
            }

            if (cue) {
                gsap.to(cue, {
                    opacity: 0,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: wrap,
                        start: 'top top',
                        end: '6% top',
                        scrub: true
                    }
                });
            }

            gsap.fromTo(vid,
                { scale: 1 },
                {
                    scale: 1.07,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: wrap,
                        start: 'top top',
                        end: 'bottom bottom',
                        scrub: true
                    }
                }
            );
        },

        reveal: function($scope) {
            $scope.find('.reveal, .ol-reveal').each(function() {
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

        globalScroll: function() {
            // Dark mode toggle on scroll
            ScrollTrigger.create({
                trigger: '.ol-site-body',
                start: 'top 88%',
                onEnter: () => document.documentElement.setAttribute('data-theme', 'dark'),
                onLeaveBack: () => document.documentElement.removeAttribute('data-theme')
            });
        }
    };

    $(window).on('elementor/frontend/init', OlympusHandler.init);
})(jQuery);
