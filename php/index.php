<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIverse - The Future of Artificial Intelligence</title>
    <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollToPlugin.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font.css">
        <style>
        #aiverse-logo-container {
            width: 650px;
            height: 650px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .aiverse-text {
            position: absolute;
            color: #87CEEB;
            font-family: Arial, sans-serif;
            font-size: 35px;
            font-weight: bold;
            text-align: center;
            z-index: 1;
            text-transform: uppercase;
            pointer-events: none;
            text-shadow: 0 0 10px rgba(135, 207, 235, 1);
        }
    </style>
</head>
<?php include 'header.php' ?>
<body>
    <canvas id="particle-canvas"></canvas>

    <div class="floating-element" id="floating-1"></div>
    <div class="floating-element" id="floating-2"></div>
    <div class="floating-element" id="floating-3"></div>
    <div class="floating-element" id="floating-4"></div>
    
    <section class="hero section" id="home">
        <div class="container2">
            <div class="hero-content">
                <div class="hero-text">
                    <h1> Step Into Tomorrow with <span class="text-primary">AI</span>Verse</h1>
                    <p>AIverse is your gateway to the future of intelligence—access multiple powerful AI tools through a unified platform. From image generation to chatbots and live weather, connect instantly using smart APIs, all in one place.</p>
                    <div class="hero-buttons">
                        <a href="service.php" class="btn btn-primary">Get Started</a>
                        <a href="about.php" class="btn btn-secondary">Learn More</a>
                    </div>
                </div>
                <div class="hero-image">
                    <div id="aiverse-logo-container">
                        <div class="aiverse-text">AIVERSE</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials Section -->
    <section class="testimonials section" id="testimonials">
        <div class="container">
            <div class="section-title text-center">
                <h2>What Our Users Say</h2>
                <p>Don't just take our word for it - hear from users that have transformed with AIverse</p>
            </div>
            <div class="grid grid-cols-3">
                <div class="card">
                    <div class="testimonial-content">
                        "AIverse has completely transformed our customer service operations. The AI chatbot handles 80% of inquiries, allowing our team to focus on complex issues. The implementation was seamless and the results were immediate."
                    </div>
                    <div class="testimonial-author">
                        <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Sarah Johnson" class="author-avatar">
                        <div class="author-info">
                            <h4>Sarah Johnson</h4>
                            <p>CEO, TechSolutions</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="testimonial-content">
                        "The predictive analytics tools have given us a competitive edge we didn't know was possible. We're making data-driven decisions faster than ever, and our revenue has increased by 35% since implementation."
                    </div>
                    <div class="testimonial-author">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Chen" class="author-avatar">
                        <div class="author-info">
                            <h4>Michael Chen</h4>
                            <p>Director of Analytics, RetailCorp</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="testimonial-content">
                        "As a small business, we never thought AI would be accessible to us. AIverse has proven us wrong with affordable, powerful tools that scaled with our growth. The content generation features alone have saved us hundreds of hours."
                    </div>
                    <div class="testimonial-author">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Emma Rodriguez" class="author-avatar">
                        <div class="author-info">
                            <h4>Emma Rodriguez</h4>
                            <p>Founder, Bloom & Grow</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta section" id="contact">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="text-white">Are You Ready to Explore the AI Universe?</h2>
                <p class="text-white">Join the AI revolution with AIverse — the free platform empowering you to access multiple AI engines, automate tasks, and innovate faster. No cost, no limits</p>
                <a href="service.php" class="btn btn-white">Get Started Today</a>
            </div>
        </div>
    </section>

    

    <script type="module">
        import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.167.1/build/three.module.js';

        class AiverseLogo {
            constructor(containerId) {
                this.container = document.getElementById(containerId);
                this.scene = new THREE.Scene();
                this.camera = new THREE.PerspectiveCamera(75, this.container.clientWidth / this.container.clientHeight, 0.1, 1000);
                this.renderer = new THREE.WebGLRenderer({ alpha: true });
                this.particles = [];
                this.ringRadius = 2.3;
                this.particleCount = 1800; // Increased for denser effect
                this.basePositions = new Float32Array(this.particleCount * 3); // Store initial positions
                this.angles = new Float32Array(this.particleCount); // Store particle angles for fading
                
                this.init();
                this.animate();
            }

            init() {
                // Set up renderer
                this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
                this.container.appendChild(this.renderer.domElement);
                this.camera.position.z = 5;

                // Create particle ring with gradient colors
                const geometry = new THREE.BufferGeometry();
                const positions = new Float32Array(this.particleCount * 3);
                const colors = new Float32Array(this.particleCount * 3);
                const sizes = new Float32Array(this.particleCount);
                const opacities = new Float32Array(this.particleCount);

                // Expanded light blue gradient colors
                const colorPalette = [
                    new THREE.Color('#B0E0E6'), // Pale blue
                    new THREE.Color('#87CEEB'), // Light sky blue
                    new THREE.Color('#00B7EB'), // Vibrant sky blue
                    new THREE.Color('#ADD8E6'), // Light cyan
                    new THREE.Color('#E0FFFF'), // Very pale cyan
                ];

                for (let i = 0; i < this.particleCount; i++) {
                    const theta = Math.random() * Math.PI * 2;
                    const radius = this.ringRadius + (Math.random() - 0.5) * 0.2;
                    const x = Math.cos(theta) * radius;
                    const y = Math.sin(theta) * radius;
                    const z = (Math.random() - 0.5) * 0.2;

                    positions[i * 3] = x;
                    positions[i * 3 + 1] = y;
                    positions[i * 3 + 2] = z;

                    // Store base positions and angles
                    this.basePositions[i * 3] = x;
                    this.basePositions[i * 3 + 1] = y;
                    this.basePositions[i * 3 + 2] = z;
                    this.angles[i] = theta;

                    // Assign gradient color
                    const color = colorPalette[Math.floor(Math.random() * colorPalette.length)];
                    colors[i * 3] = color.r;
                    colors[i * 3 + 1] = color.g;
                    colors[i * 3 + 2] = color.b;

                    sizes[i] = 0.05 + Math.random() * 0.03; // Base size for pulsing
                    opacities[i] = 0.8; // Initial opacity
                }

                geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
                geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
                geometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));
                geometry.setAttribute('alpha', new THREE.BufferAttribute(opacities, 1));

                const material = new THREE.PointsMaterial({
                    size: 0.05,
                    vertexColors: true,
                    transparent: true,
                    opacity: 0.8,
                    sizeAttenuation: true,
                    alphaTest: 0.1,
                    vertexColors: true,
                    alphaAttribute: 'alpha' // Custom attribute for per-particle opacity
                });

                // Custom shader for per-particle opacity
                material.onBeforeCompile = (shader) => {
                    shader.vertexShader = shader.vertexShader.replace(
                        'void main() {',
                        `
                        attribute float alpha;
                        varying float vAlpha;
                        void main() {
                            vAlpha = alpha;
                        `
                    );
                    shader.fragmentShader = shader.fragmentShader.replace(
                        'void main() {',
                        `
                        varying float vAlpha;
                        void main() {
                            gl_FragColor.a *= vAlpha;
                        `
                    );
                };

                this.particles = new THREE.Points(geometry, material);
                this.scene.add(this.particles);

                // Add ambient and point light
                const ambientLight = new THREE.AmbientLight(0x87CEEB, 0.5);
                this.scene.add(ambientLight);
                const pointLight = new THREE.PointLight(0x87CEEB, 0.5, 10);
                pointLight.position.set(0, 0, 5);
                this.scene.add(pointLight);

                // Handle window resize
                window.addEventListener('resize', () => {
                    this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
                    this.camera.aspect = this.container.clientWidth / this.container.clientHeight;
                    this.camera.updateProjectionMatrix();
                });
            }

            animate() {
                requestAnimationFrame(() => this.animate());

                // Update particle positions, sizes, and opacities
                const positions = this.particles.geometry.attributes.position.array;
                const sizes = this.particles.geometry.attributes.size.array;
                const opacities = this.particles.geometry.attributes.alpha.array;
                const time = Date.now() * 0.001;

                for (let i = 0; i < this.particleCount; i++) {
                    // Vertical floating effect
                    positions[i * 3 + 2] = this.basePositions[i * 3 + 2] + Math.sin(time + i) * 0.1;

                    // Radial oscillation
                    const theta = this.angles[i];
                    const baseRadius = Math.sqrt(this.basePositions[i * 3] ** 2 + this.basePositions[i * 3 + 1] ** 2);
                    const radiusOffset = Math.sin(time * 0.5 + i) * 0.05;
                    positions[i * 3] = this.basePositions[i * 3] * (1 + radiusOffset / baseRadius);
                    positions[i * 3 + 1] = this.basePositions[i * 3 + 1] * (1 + radiusOffset / baseRadius);

                    // Pulsing size effect
                    sizes[i] = 0.05 + 0.03 * Math.abs(Math.sin(time * 0.75 + i));

                    // Circular fading effect
                    const fadeSpeed = 1.5; // Speed of fading wave
                    const fadeRange = 0.5; // Opacity variation range
                    opacities[i] = 0.3 + 0.5 * (Math.sin(theta + time * fadeSpeed) * 0.5 + 0.5);
                }

                this.particles.geometry.attributes.position.needsUpdate = true;
                this.particles.geometry.attributes.size.needsUpdate = true;
                this.particles.geometry.attributes.alpha.needsUpdate = true;

                this.renderer.render(this.scene, this.camera);
            }
        }

        // Initialize the logo
        document.addEventListener('DOMContentLoaded', () => {
            new AiverseLogo('aiverse-logo-container');
        });
    </script>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="../js/main.js"></script>
</body>
</html>

<?php include 'footer.php'?>