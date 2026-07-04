/**
 * Avatice 3D Main Scene Controller
 */
(function($) {
    class Avatice3DScene {
        constructor() {
            this.container = $('.avatice-3d-layout-wrapper');
            if (!this.container.length) return;

            this.canvas = document.getElementById('avatice-3d-canvas');
            if (!this.canvas) return;

            this.railProgress = document.getElementById('avatice-rail-progress');
            this.railStop = document.getElementById('avatice-rail-stop');

            this.updateConfig();

            this.state = {
                progress: 0,
                targetProgress: 0,
                camZ: 30,
                mx: 0, my: 0, tmx: 0, tmy: 0
            };

            this.init();
        }

        updateConfig() {
            this.container = $('.avatice-3d-layout-wrapper');
            this.config = {
                fogColor: this.container.data('fog-color') || '#070a0f',
                light1: this.container.data('light1') || '#2bb8ec',
                light2: this.container.data('light2') || '#7fe0ff',
                smoothing: parseFloat(this.container.data('smoothing')) || 0.04,
                iconCount: parseInt(this.container.data('icon-count')) || 60,
                fov: parseFloat(this.container.data('fov')) || 62
            };

            if (this.scene && this.scene.fog) {
                this.scene.fog.color.set(this.config.fogColor);
            }
            if (this.p1) this.p1.color.set(this.config.light1);
            if (this.p2) this.p2.color.set(this.config.light2);
            if (this.cam) {
                this.cam.fov = this.config.fov;
                this.cam.updateProjectionMatrix();
            }
        }

        init() {
            const THREE = window.THREE;
            if (!THREE) {
                setTimeout(() => this.init(), 100);
                return;
            }

            this.setupRenderer();
            this.setupScene();
            this.setupPostProcessing();
            this.setupObjects();
            this.setupEventListeners();
            this.setupRevealAnimations();

            this.animate();
        }

        setupRenderer() {
            const THREE = window.THREE;
            this.renderer = new THREE.WebGLRenderer({ canvas: this.canvas, antialias: true, alpha: true });
            this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            this.updateSize();
        }

        updateSize() {
            const W = window.innerWidth;
            const H = window.innerHeight;
            this.renderer.setSize(W, H);
            if (this.composer) this.composer.setSize(W, H);
            if (this.cam) {
                this.cam.aspect = W / H;
                // Editor FOV override vs dynamic mobile FOV
                this.cam.fov = W < 768 ? 75 : this.config.fov;
                this.cam.updateProjectionMatrix();
            }
            this.pathScale = W < 768 ? 0.6 : 1.0;
        }

        setupScene() {
            const THREE = window.THREE;
            this.scene = new THREE.Scene();
            this.scene.fog = new THREE.Fog(new THREE.Color(this.config.fogColor), 28, 230);

            this.cam = new THREE.PerspectiveCamera(this.config.fov, window.innerWidth / window.innerHeight, 0.1, 600);
            this.cam.position.set(0, 0, 30);

            this.scene.add(new THREE.AmbientLight(0x0a1a2a, 0.5));

            this.p1 = new THREE.PointLight(new THREE.Color(this.config.light1), 3.0, 150);
            this.p1.position.set(8, 10, 20);
            this.scene.add(this.p1);

            this.p2 = new THREE.PointLight(new THREE.Color(this.config.light2), 2.0, 150);
            this.p2.position.set(-12, -6, 12);
            this.scene.add(this.p2);

            this.p3 = new THREE.PointLight(0xffffff, 1.5, 100);
            this.scene.add(this.p3);

            const dir = new THREE.DirectionalLight(0xffffff, 0.8);
            dir.position.set(0, 5, 10);
            this.scene.add(dir);
        }

        setupPostProcessing() {
            const THREE = window.THREE;
            this.composer = new THREE.EffectComposer(this.renderer);
            this.composer.addPass(new THREE.RenderPass(this.scene, this.cam));

            this.bloomPass = new THREE.UnrealBloomPass(
                new THREE.Vector2(window.innerWidth, window.innerHeight),
                0.6, 0.4, 0.85
            );
            this.composer.addPass(this.bloomPass);

            if (window.innerWidth < 768) {
                this.bloomPass.strength = 0.3;
            }
        }

        bendX(z) {
            let x = (Math.sin(z * 0.011) * 17 + Math.cos(z * 0.033) * 4.5) * this.pathScale;
            this.ROOMS.forEach(room => {
                const dist = Math.abs(z - room.z);
                if (dist < 40) {
                    const influence = 1 - (dist / 40);
                    x += Math.sin(z * 0.1) * 10 * influence;
                }
            });
            return x;
        }

        bendY(z) {
            let y = (Math.cos(z * 0.015) * 10 + Math.sin(z * 0.027) * 3) * this.pathScale;
            this.ROOMS.forEach(room => {
                const dist = Math.abs(z - room.z);
                if (dist < 40) {
                    const influence = 1 - (dist / 40);
                    y += Math.cos(z * 0.1) * 10 * influence;
                }
            });
            return y;
        }

        bend(z) {
            return { x: this.bendX(z), y: this.bendY(z) };
        }

        setupObjects() {
            const THREE = window.THREE;
            this.ROOMS = [
                { z: 30,  type: 'tunnel',  r: 15,  color: 0x14587f },
                { z: -30, type: 'open',    r: 45,  color: 0x2bb8ec },
                { z: -90, type: 'square',  r: 25,  color: 0x0e3f5c },
                { z: -150,type: 'tunnel',  r: 12,  color: 0x7fe0ff },
                { z: -210,type: 'open',    r: 50,  color: 0x3f86ad },
                { z: -270,type: 'tunnel',  r: 18,  color: 0x14587f },
                { z: -330,type: 'square',  r: 30,  color: 0x2bb8ec },
                { z: -390,type: 'open',    r: 40,  color: 0x0e3f5c },
                { z: -450,type: 'tunnel',  r: 15,  color: 0x7fe0ff },
                { z: -510,type: 'square',  r: 35,  color: 0x3f86ad }
            ];

            this.Z_FAR = -550;
            this.Z_NEAR = 24;
            this.SPAN = this.Z_NEAR - this.Z_FAR;

            // Geometry Cache
            this.G = {
                box: new THREE.BoxGeometry(1, 1, 1),
                cyl: new THREE.CylinderGeometry(1, 1, 1, 18),
                cone: new THREE.ConeGeometry(1, 1, 18),
                coneOpen: new THREE.ConeGeometry(1, 1, 20, 1, true),
                sph: new THREE.SphereGeometry(1, 16, 12),
                torus: (r, t, seg) => new THREE.TorusGeometry(r, t || 0.08, 8, seg || 32)
            };

            this.setupTunnel();
            this.setupStars();
            this.setupIcons();
            this.setupRings();
        }

        setupTunnel() {
            const THREE = window.THREE;
            const pathPts = [];
            for (let z = this.Z_NEAR + 50; z >= this.Z_FAR - 50; z -= 8) {
                pathPts.push(new THREE.Vector3(this.bendX(z), this.bendY(z), z));
            }
            const tunnelCurve = new THREE.CatmullRomCurve3(pathPts);
            [[15.5, 0x14587f, 0.16], [12, 0x0e3f5c, 0.13]].forEach(([r, col, op]) => {
                const tg = new THREE.TubeGeometry(tunnelCurve, 220, r, 26, false);
                const tm = new THREE.MeshBasicMaterial({ color: col, wireframe: true, transparent: true, opacity: op });
                this.scene.add(new THREE.Mesh(tg, tm));
            });
        }

        setupStars() {
            const THREE = window.THREE;
            const mkStars = (count, size, col, opacity, spread) => {
                const p = new Float32Array(count * 3), home = new Float32Array(count * 2);
                for (let i = 0; i < count; i++) {
                    const hx = (Math.random() - 0.5) * spread, hy = (Math.random() - 0.5) * spread, z = this.Z_NEAR - Math.random() * this.SPAN;
                    home[i * 2] = hx; home[i * 2 + 1] = hy;
                    p[i * 3] = hx + this.bendX(z); p[i * 3 + 1] = hy + this.bendY(z); p[i * 3 + 2] = z;
                }
                const g = new THREE.BufferGeometry(); g.setAttribute('position', new THREE.BufferAttribute(p, 3));
                const m = new THREE.PointsMaterial({ color: col, size, transparent: true, opacity, sizeAttenuation: true, blending: THREE.AdditiveBlending });
                const pts = new THREE.Points(g, m); this.scene.add(pts);
                return { g, pts, count, home, spread };
            };
            this.starsNear = mkStars(1500, 0.5, 0x9fe6ff, 0.9, 120);
            this.starsFar = mkStars(900, 0.28, 0x4f9fd0, 0.6, 150);
        }

        setupIcons() {
            const THREE = window.THREE;
            const ICON_TYPES = ['chart', 'target', 'rocket', 'star', 'coin', 'bubble', 'gear', 'megaphone', 'funnel', 'network'];
            this.icons = [];
            const palette = [0x2bb8ec, 0x7fe0ff, 0x1f9cd6, 0x158bcb, 0x49c6f0];

            const makeIcon = (type, mat) => {
                const g = new THREE.Group();
                const add = (geo, fn) => { const me = new THREE.Mesh(geo, mat); fn && fn(me); g.add(me); return me; };
                if(type==='chart'){ [0.7,1.1,1.6,2.2].forEach((h,i)=> add(this.G.box, me=>{ me.scale.set(0.42,h,0.42); me.position.set(-1.1+i*0.72, h/2-1.1, 0); })); }
                else if(type==='target'){ [1.3,0.85,0.42].forEach(r=> add(this.G.torus(r,0.09,40))); add(this.G.sph, me=> me.scale.setScalar(0.2)); }
                else if(type==='rocket'){ add(this.G.cyl, me=> me.scale.set(0.42,1.3,0.42)); add(this.G.cone, me=>{ me.scale.set(0.42,0.7,0.42); me.position.y=1.0; }); }
                else { add(this.G.sph, me=> me.scale.setScalar(0.42)); }
                return g;
            };

            for (let i = 0; i < this.config.iconCount; i++) {
                const type = ICON_TYPES[(Math.random() * ICON_TYPES.length) | 0];
                const col = palette[i % palette.length];
                const mat = new THREE.MeshPhysicalMaterial({ color: col, metalness: 0.9, roughness: 0.1, emissive: 0x0a3f63, emissiveIntensity: 0.45, clearcoat: 1.0 });

                const group = makeIcon(type, mat);
                const ang = Math.random() * Math.PI * 2, rad = 4.5 + Math.random() * 9.5;
                const hx = Math.cos(ang) * rad, hy = Math.sin(ang) * rad, z0 = this.Z_NEAR - 8 - Math.random() * this.SPAN;

                group.position.set(hx + this.bendX(z0), hy + this.bendY(z0), z0);
                group.scale.setScalar(0.55 + Math.random() * 1.05);
                group.userData = { hx, hy, rx: (Math.random() - 0.5) * 0.012, ry: (Math.random() - 0.5) * 0.026, rz: (Math.random() - 0.5) * 0.012, drift: 0.4 + Math.random() * 0.9, bob: Math.random() * 6, bAmp: 0.3 + Math.random() * 0.6 };
                this.scene.add(group);
                this.icons.push(group);
            }
        }

        setupRings() {
            const THREE = window.THREE;
            this.wallRings = [];
            for (let i = 0; i < 46; i++) {
                const r = 13 + Math.random() * 3;
                const g = new THREE.TorusGeometry(r, 0.06, 6, 80);
                const m = new THREE.MeshBasicMaterial({ color: Math.random() < 0.3 ? 0x7fe0ff : 0x2bb8ec, transparent: true, opacity: 0.32, blending: THREE.AdditiveBlending });
                const mesh = new THREE.Mesh(g, m);
                const hx = (Math.random() - 0.5) * 2, hy = (Math.random() - 0.5) * 2, z0 = this.Z_NEAR - i * (this.SPAN / 46);
                mesh.position.set(hx + this.bendX(z0), hy + this.bendY(z0), z0);
                mesh.userData = { hx, hy, spin: (Math.random() - 0.5) * 0.003 };
                this.scene.add(mesh);
                this.wallRings.push(mesh);
            }
        }

        setupEventListeners() {
            window.addEventListener('scroll', () => this.onScroll(), { passive: true });
            window.addEventListener('resize', () => this.updateSize());
            window.addEventListener('mousemove', (e) => {
                this.state.tmx = (e.clientX / window.innerWidth - 0.5);
                this.state.tmy = (e.clientY / window.innerHeight - 0.5);
            });
            this.onScroll();
        }

        onScroll() {
            const max = document.documentElement.scrollHeight - window.innerHeight;
            this.state.targetProgress = max > 0 ? window.scrollY / max : 0;

            if (this.railProgress) this.railProgress.style.height = (8 + this.state.progress * 92) + '%';
            if (this.railStop) {
                const stops = 10;
                const n = Math.min(stops, Math.floor(this.state.progress * stops) + 1);
                this.railStop.innerHTML = String(n).padStart(2, '0') + '<span style="color:#4a6675">/' + stops + '</span>';
            }
        }

        setupRevealAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('shown');
                        $(entry.target).find('> *').each((i, el) => {
                            $(el).css('transition-delay', (0.2 + i * 0.1) + 's');
                        });
                    }
                });
            }, { threshold: 0.1 });

            $('.avatice-reveal').each((i, el) => observer.observe(el));
        }

        streamStars(layer, speed, camZ) {
            const a = layer.g.attributes.position.array, hm = layer.home;
            for (let i = 0; i < layer.count; i++) {
                let z = a[i * 3 + 2] + speed;
                if (z > camZ + 12) {
                    z = camZ - (this.SPAN - 20);
                    hm[i * 2] = (Math.random() - 0.5) * layer.spread;
                    hm[i * 2 + 1] = (Math.random() - 0.5) * layer.spread;
                }
                a[i * 3] = hm[i * 2] + this.bendX(z);
                a[i * 3 + 1] = hm[i * 2 + 1] + this.bendY(z);
                a[i * 3 + 2] = z;
            }
            layer.g.attributes.position.needsUpdate = true;
        }

        animate() {
            if (this.disposed) return;
            requestAnimationFrame(() => this.animate());
            const THREE = window.THREE;
            const dt = 0.016;
            const et = performance.now() * 0.001;

            this.state.progress += (this.state.targetProgress - this.state.progress) * this.config.smoothing;

            const targetZ = 30 - this.state.progress * 540;
            this.state.camZ += (targetZ - this.state.camZ) * 0.03;

            this.state.mx += (this.state.tmx - this.state.mx) * 0.05;
            this.state.my += (this.state.tmy - this.state.my) * 0.05;

            const cb = this.bend(this.state.camZ), lb = this.bend(this.state.camZ - 25);
            this.cam.position.set(cb.x + this.state.mx * 8, cb.y - this.state.my * 6, this.state.camZ);
            this.cam.lookAt(new THREE.Vector3(lb.x + this.state.mx * 4, lb.y - this.state.my * 3, this.state.camZ - 25));

            $('.avatice-section').each((i, sec) => {
                const r = sec.getBoundingClientRect();
                const centerOff = (r.top + r.height / 2 - window.innerHeight / 2) / window.innerHeight;
                const near = Math.max(0, 1 - Math.min(Math.abs(centerOff), 1));
                const k = 0.35 + 0.65 * near;
                sec.style.transform = `perspective(1700px) rotateY(${(this.state.mx * 6 * k).toFixed(2)}deg) rotateX(${(-this.state.my * 5 * k).toFixed(2)}deg) scale(${(1 - 0.015 * (1 - near)).toFixed(3)})`;
            });

            this.icons.forEach(a => {
                a.rotation.x += a.userData.rx; a.rotation.y += a.userData.ry; a.rotation.z += a.userData.rz;
                let z = a.position.z + dt * a.userData.drift * 6;
                if (z > this.state.camZ + 16) z -= this.SPAN;
                const bx = this.bendX(z), by = this.bendY(z);
                a.position.set(a.userData.hx + bx, a.userData.hy + by + Math.sin(et * 0.8 + a.userData.bob) * 0.5 * a.userData.bAmp, z);
            });

            this.wallRings.forEach(r => {
                r.rotation.z += r.userData.spin;
                let z = r.position.z + dt * 9;
                if (z > this.state.camZ + 16) z -= this.SPAN;
                r.position.set(r.userData.hx + this.bendX(z), r.userData.hy + this.bendY(z), z);
            });

            this.streamStars(this.starsNear, dt * 16, this.state.camZ);
            this.streamStars(this.starsFar, dt * 7, this.state.camZ);

            this.p1.position.set(Math.sin(et * 0.6) * 10, Math.cos(et * 0.5) * 8, this.state.camZ + 18);
            this.p3.position.set(this.state.mx * 20, this.state.my * 20, this.state.camZ + 5);

            this.composer.render();
        }

        dispose() {
            this.disposed = true;
            if (this.renderer) this.renderer.dispose();
        }
    }

    window.Avatice3DScene = Avatice3DScene;

    $(window).on('elementor/frontend/init', function() {
        if ($('.avatice-3d-layout-wrapper').length) {
            window.Avatice3DSceneInstance = new Avatice3DScene();
        }
    });

})(jQuery);
