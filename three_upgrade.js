// Enhanced Three.js Logic for AVATIC 'Director's Cut'
// Incorporates EffectComposer, UnrealBloom, and Cinematic Camera

const setupPostProcessing = (renderer, scene, camera, width, height) => {
  const composer = new THREE.EffectComposer(renderer);

  const renderPass = new THREE.RenderPass(scene, camera);
  composer.addPass(renderPass);

  const bloomPass = new THREE.UnrealBloomPass(
    new THREE.Vector2(width, height),
    1.5, // strength
    0.4, // radius
    0.85 // threshold
  );
  composer.addPass(bloomPass);

  // Custom Film Grain / Vignette Pass
  const filmShader = {
    uniforms: {
      "tDiffuse": { value: null },
      "tIn": { value: null },
      "amount": { value: 0.5 },
      "vignette": { value: 0.5 }
    },
    vertexShader: `
      varying vec2 vUv;
      void main() {
        vUv = uv;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
      }
    `,
    fragmentShader: `
      uniform sampler2D tDiffuse;
      uniform float amount;
      uniform float vignette;
      varying vec2 vUv;
      float random(vec2 p) {
        return fract(sin(dot(p.xy, vec2(12.9898, 78.233))) * 43758.5453);
      }
      void main() {
        vec4 color = texture2D(tDiffuse, vUv);
        float noise = (random(vUv + amount) - 0.5) * 0.05;
        float d = distance(vUv, vec2(0.5, 0.5));
        float vig = smoothstep(0.8, 0.4, d * vignette);
        gl_FragColor = vec4(color.rgb + noise, color.a) * vig;
      }
    `
  };

  const filmPass = new THREE.ShaderPass(filmShader);
  composer.addPass(filmPass);

  return { composer, bloomPass, filmPass };
};
