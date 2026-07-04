(function($) {
    "use strict";

    /**
     * Initialize GSAP and ScrollTrigger
     */
    const initOlympusAnimations = () => {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
            return;
        }

        gsap.registerPlugin(ScrollTrigger);

        // Reveal on scroll
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

        // Hero Parallax
        const $heroContent = $('#ol-hero-content');
        if ($heroContent.length) {
            gsap.to($heroContent, {
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
        }

        const $scrollCue = $('#ol-scroll-cue');
        if ($scrollCue.length) {
            gsap.to($scrollCue, {
                opacity: 0,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.ol-hero-wrap',
                    start: 'top top',
                    end: '6% top',
                    scrub: true
                }
            });
        }

        const $heroVideo = $('.ol-hero-video');
        if ($heroVideo.length) {
            gsap.fromTo($heroVideo,
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
        }

        // Dark mode on scroll
        const $siteBody = $('#ol-site-body');
        if ($siteBody.length) {
            ScrollTrigger.create({
                trigger: '#ol-site-body',
                start: 'top 88%',
                onEnter()     { document.documentElement.setAttribute('data-theme', 'dark'); },
                onLeaveBack() { document.documentElement.removeAttribute('data-theme'); }
            });
        }
    };

    /**
     * Hero Video Scrub Logic
     */
    const initHeroVideoScrub = ($scope) => {
        const vid = $scope.find('#ol-hero-video')[0];
        if (!vid) return;

        const setupScrub = () => {
            if (!vid.duration) return;
            ScrollTrigger.create({
                trigger: '.ol-hero-wrap',
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

        // Handle loader (if any)
        const $loader = $('#ol-loader');
        const hideLoader = () => {
            $loader.addClass('out');
            setTimeout(() => $loader.hide(), 950);
        };

        vid.addEventListener('canplay', hideLoader, { once: true });
        vid.addEventListener('error', hideLoader, { once: true });
        setTimeout(hideLoader, 5000);
    };

    $(window).on('elementor/frontend/init', function() {
        // Register widget-specific handlers
        elementorFrontend.hooks.addAction('frontend/element_ready/olympus-hero.default', function($scope) {
            initHeroVideoScrub($scope);
        });

        // Global animations
        elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
            initOlympusAnimations();
        });

        // If in edit mode, refresh ScrollTrigger on changes
        if (elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction('frontend/element_ready/widget', function() {
                setTimeout(() => ScrollTrigger.refresh(), 100);
            });
        }
    });

})(jQuery);
