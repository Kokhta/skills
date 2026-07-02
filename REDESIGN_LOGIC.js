// REDESIGN LOGIC - STEP 1: Advanced Materials & Lighting

const initAdvancedScene = (THREE, canvas) => {
  const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.2;
  renderer.outputEncoding = THREE.sRGBEncoding;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
  camera.position.z = 50;

  // Environment Map (Procedural)
  const pmremGenerator = new THREE.PMREMGenerator(renderer);
  pmremGenerator.compileEquirectangularShader();

  // High-End Lighting
  const ambientLight = new THREE.AmbientLight(0x0a0f1a, 0.5);
  scene.add(ambientLight);

  const mainLight = new THREE.PointLight(0xe9c349, 3, 100);
  mainLight.position.set(10, 10, 20);
  scene.add(mainLight);

  const accentLight = new THREE.PointLight(0x2bb8ec, 2, 80);
  accentLight.position.set(-15, -10, 15);
  scene.add(accentLight);

  // Fresnel Shader Material for Arrow
  const fresnelMaterial = new THREE.ShaderMaterial({
    uniforms: {
      time: { value: 0 },
      color1: { value: new THREE.Color(0x2bb8ec) },
      color2: { value: new THREE.Color(0xe9c349) },
    },
    vertexShader: `
      varying vec3 vNormal;
      varying vec3 vViewPosition;
      void main() {
        vNormal = normalize(normalMatrix * normal);
        vec4 mvPosition = modelViewMatrix * vec4(position, 1.0);
        vViewPosition = -mvPosition.xyz;
        gl_Position = projectionMatrix * mvPosition;
      }
    `,
    fragmentShader: `
      uniform vec3 color1;
      uniform vec3 color2;
      uniform float time;
      varying vec3 vNormal;
      varying vec3 vViewPosition;
      void main() {
        vec3 viewDir = normalize(vViewPosition);
        float fresnel = pow(1.0 - dot(viewDir, vNormal), 3.0);
        vec3 color = mix(color1, color2, fresnel + sin(time) * 0.2);
        gl_FragColor = vec4(color, 1.0);
      }
    `,
    transparent: true,
  });

  return { renderer, scene, camera, fresnelMaterial };
};

// REDESIGN LOGIC - STEP 2: Volumetric Nebula Shader

const createVolumetricNebula = (THREE, scene) => {
  const nebulaGeometry = new THREE.SphereGeometry(150, 32, 32);
  const nebulaMaterial = new THREE.ShaderMaterial({
    uniforms: {
      time: { value: 0 },
      resolution: { value: new THREE.Vector2(window.innerWidth, window.innerHeight) },
      baseColor: { value: new THREE.Color(0x0a0f1a) },
      accentColor: { value: new THREE.Color(0x1a2a4a) },
    },
    vertexShader: `
      varying vec2 vUv;
      varying vec3 vPosition;
      void main() {
        vUv = uv;
        vPosition = position;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
      }
    `,
    fragmentShader: `
      uniform float time;
      uniform vec3 baseColor;
      uniform vec3 accentColor;
      varying vec3 vPosition;

      float noise(vec3 p) {
        return fract(sin(dot(p, vec3(12.9898, 78.233, 45.164))) * 43758.5453);
      }

      void main() {
        float n = noise(vPosition * 0.05 + time * 0.1);
        vec3 color = mix(baseColor, accentColor, n);
        float dist = length(vPosition) / 150.0;
        float alpha = smoothstep(1.0, 0.5, dist) * 0.4;
        gl_FragColor = vec4(color, alpha);
      }
    `,
    side: THREE.BackSide,
    transparent: true,
    depthWrite: false,
    blending: THREE.AdditiveBlending
  });

  const nebula = new THREE.Mesh(nebulaGeometry, nebulaMaterial);
  scene.add(nebula);
  return nebula;
};

// REDESIGN LOGIC - STEP 3: Interactive Geometric Objects

const createMarketingArtifacts = (THREE, scene) => {
  const artifacts = [];
  const geometries = [
    new THREE.IcosahedronGeometry(1.5, 0), // Lead
    new THREE.TorusGeometry(1, 0.4, 16, 32), // Strategy
    new THREE.OctahedronGeometry(1.2, 0) // Growth
  ];
  const glassMaterial = new THREE.MeshPhysicalMaterial({
    color: 0x2bb8ec,
    metalness: 0.1,
    roughness: 0.05,
    transmission: 1.0,
    ior: 1.5,
    thickness: 0.5,
    specularIntensity: 1.0,
    clearcoat: 1.0,
    transparent: true,
  });

  for(let i=0; i<15; i++) {
    const geo = geometries[i % geometries.length];
    const mesh = new THREE.Mesh(geo, glassMaterial);
    mesh.position.set(
      (Math.random() - 0.5) * 60,
      (Math.random() - 0.5) * 60,
      (Math.random() - 0.5) * 100
    );
    mesh.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, 0);
    mesh.userData = {
      rotSpeed: (Math.random() - 0.5) * 0.01,
      floatSpeed: 0.005 + Math.random() * 0.01
    };
    scene.add(mesh);
    artifacts.push(mesh);
  }
  return artifacts;
};

// REDESIGN LOGIC - STEP 4: HUD & EffectComposer Stack

const setupHUDAndComposer = (THREE, renderer, scene, camera) => {
  const composer = new THREE.EffectComposer(renderer);
  composer.addPass(new THREE.RenderPass(scene, camera));

  const bloomPass = new THREE.UnrealBloomPass(
    new THREE.Vector2(window.innerWidth, window.innerHeight),
    1.2, 0.4, 0.85
  );
  composer.addPass(bloomPass);

  // Scanline/HUD Shader
  const hudShader = {
    uniforms: {
      "tDiffuse": { value: null },
      "time": { value: 0 }
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
      uniform float time;
      varying vec2 vUv;
      void main() {
        vec4 base = texture2D(tDiffuse, vUv);
        float scanline = sin(vUv.y * 800.0 + time * 5.0) * 0.02;
        float noise = (fract(sin(dot(vUv.xy, vec2(12.9898, 78.233))) * 43758.5453) - 0.5) * 0.01;
        gl_FragColor = vec4(base.rgb + scanline + noise, base.a);
      }
    `
  };
  const hudPass = new THREE.ShaderPass(hudShader);
  composer.addPass(hudPass);

  return { composer, bloomPass, hudPass };
};

// REDESIGN LOGIC - STEP 5: Cinematic Synchronization

const syncExperience = (gsap, camera, nebula, artifacts) => {
  gsap.registerPlugin(ScrollTrigger);

  const mainTl = gsap.timeline({
    scrollTrigger: {
      trigger: "main",
      start: "top top",
      end: "bottom bottom",
      scrub: 2.0,
    }
  });

  // Camera Path
  mainTl.to(camera.position, { x: -10, y: 5, z: 20, ease: "power2.inOut" }, 0);
  mainTl.to(camera.rotation, { y: 0.3, ease: "power1.inOut" }, 0);

  mainTl.to(camera.position, { x: 10, y: -5, z: 80, ease: "power2.inOut" }, 1);
  mainTl.to(camera.rotation, { y: -0.3, ease: "power1.inOut" }, 1);

  // Atmospheric Pulse
  mainTl.to(nebula.scale, { x: 1.2, y: 1.2, z: 1.2, ease: "none" }, 0);

  // Artifact Interaction
  artifacts.forEach((art, i) => {
    mainTl.to(art.position, {
      y: art.position.y + 10,
      z: art.position.z + 20,
      ease: "sine.inOut"
    }, 0);
  });
};
