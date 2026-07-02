// Cinematic Camera Sync with GSAP ScrollTrigger
// Replaces static scroll mapping with a smooth, timeline-based sequence

const initCinematicCamera = (camera, targetZ, scrollContainer) => {
  gsap.registerPlugin(ScrollTrigger);

  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: scrollContainer,
      start: "top top",
      end: "bottom bottom",
      scrub: 1.5, // Smooth lag for cinematic feel
      onUpdate: (self) => {
        // Dynamic FOV or tilt logic can be injected here
      }
    }
  });

  // Hero Section (Intro Fly-in)
  tl.to(camera.position, { z: targetZ * 0.2, ease: "none" }, 0);
  tl.to(camera.rotation, { x: 0.1, ease: "power2.inOut" }, 0);

  // Strategy Console (Pan & Focus)
  tl.to(camera.position, { x: 5, y: -2, z: targetZ * 0.5, ease: "none" }, 1);
  tl.to(camera.rotation, { y: -0.2, ease: "power1.inOut" }, 1);

  // Portfolio (Wide expansion)
  tl.to(camera.position, { x: 0, y: 0, z: targetZ * 0.8, ease: "none" }, 2);

  // Final CTA (Zoom In)
  tl.to(camera.position, { z: targetZ, ease: "none" }, 3);

  return tl;
};
