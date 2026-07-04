(function($) {
  "use strict";

  var globalInited = false;

  var OlympusHandler = function($scope, $) {
    gsap.registerPlugin(ScrollTrigger);

    var $heroWrap = $scope.find('.hero-wrap');
    if ($heroWrap.length) {
      initHero($heroWrap);
    }

    if (!globalInited) {
      var $siteBody = $('.site-body');
      if ($siteBody.length) {
        initGlobalAnimations($siteBody);
        globalInited = true;
      }
    }

    initRevealAnimations($scope);

    // Refresh ScrollTrigger after a short delay to ensure layout is ready
    setTimeout(function() {
        ScrollTrigger.refresh();
    }, 500);
  };

  function initHero($hero) {
    var vid = $hero.find('#hero-video')[0];
    if (!vid) return;

    // Loader logic
    var loader = $('#olympus-loader');
    function hideLoader() {
      loader.addClass('out');
      setTimeout(function() { loader.hide(); }, 950);
    }

    vid.addEventListener('canplay', hideLoader, { once: true });
    vid.addEventListener('error', hideLoader, { once: true });
    setTimeout(hideLoader, 5000);

    // Video scrub
    function setupScrub() {
      if (!vid.duration) return;
      ScrollTrigger.create({
        trigger: $hero[0],
        start: 'top top',
        end: 'bottom bottom',
        scrub: 0.25,
        onUpdate: function(self) {
          if (vid.readyState >= 2) {
            vid.currentTime = vid.duration * self.progress;
          }
        }
      });
    }

    vid.addEventListener('loadedmetadata', setupScrub);
    if (vid.readyState >= 1) setupScrub();

    // Hero content parallax
    gsap.to($hero.find('#hero-content'), {
      yPercent: -28,
      opacity: 0,
      ease: 'none',
      scrollTrigger: {
        trigger: $hero[0],
        start: 'top top',
        end: '28% top',
        scrub: true
      }
    });

    // Scroll cue fade
    gsap.to($hero.find('#scroll-cue'), {
      opacity: 0,
      ease: 'none',
      scrollTrigger: {
        trigger: $hero[0],
        start: 'top top',
        end: '6% top',
        scrub: true
      }
    });

    // Video scale
    gsap.fromTo(vid,
      { scale: 1 },
      {
        scale: 1.07,
        ease: 'none',
        scrollTrigger: {
          trigger: $hero[0],
          start: 'top top',
          end: 'bottom bottom',
          scrub: true
        }
      }
    );
  }

  function initGlobalAnimations($body) {
    // Dark mode on scroll
    ScrollTrigger.create({
      trigger: $body[0],
      start: 'top 88%',
      onEnter: function() { document.documentElement.setAttribute('data-theme', 'dark'); },
      onLeaveBack: function() { document.documentElement.removeAttribute('data-theme'); }
    });

    // Nav background
    var $nav = $('#olympus-nav');
    if ($nav.length) {
      ScrollTrigger.create({
        trigger: '.hero-wrap',
        start: 'top top',
        end: 'bottom top',
        onLeave: function() { $nav.addClass('bg'); },
        onEnterBack: function() { $nav.removeClass('bg'); }
      });
    }
  }

  function initRevealAnimations($scope) {
    $scope.find('.reveal').each(function() {
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
  }

  $(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction('frontend/element_ready/olympus-hero.default', OlympusHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/olympus-intro.default', OlympusHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/olympus-pantheon.default', OlympusHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/olympus-myth.default', OlympusHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/olympus-oracle.default', OlympusHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/olympus-chronicles.default', OlympusHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/olympus-footer.default', OlympusHandler);
  });

})(jQuery);
