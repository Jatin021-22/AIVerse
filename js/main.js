        document.addEventListener('DOMContentLoaded', function() {
            initComponents();
        });

        // Initialize all components
        function initComponents() {
            // Initialize particles
            initParticles();
            
            // Initialize animations
            initAnimations();
            
            // Initialize mobile menu
            initMobileMenu();
            
            // Initialize scroll effects
            initScrollEffects();
        }

        // ====== Particle Background ======
        function initParticles() {
            const canvas = document.getElementById('particle-canvas');
            const ctx = canvas.getContext('2d');
            let particlesArray = [];

            // Set canvas size
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            // Handle window resize
            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                initParticles();
            });

            // Particle class
            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 2 + 1;
                    this.speedX = (Math.random() - 0.5) * 0.8;
                    this.speedY = (Math.random() - 0.5) * 0.8;
                    this.color = '#8ED6FF';
                    this.opacity = Math.random() * 0.4 + 0.1;
                }
                
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;

                    // Bounce off edges
                    if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
                    if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
                }
                
                draw() {
                    ctx.fillStyle = this.color;
                    ctx.globalAlpha = this.opacity;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.globalAlpha = 1;
                }
            }

            // Initialize particles
            function initParticleArray() {
                particlesArray = [];
                for (let i = 0; i < 100; i++) {
                    particlesArray.push(new Particle());
                }
            }

            // Animate particles
            function animateParticles() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                particlesArray.forEach(particle => {
                    particle.update();
                    particle.draw();
                });

                requestAnimationFrame(animateParticles);
            }

            initParticleArray();
            animateParticles();
        }

        // ====== Animations ======
        function initAnimations() {
            // Register GSAP plugins
            gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);
            
            // Preloader animation
            const preloader = document.getElementById('preloader');
            gsap.to(preloader, {
                opacity: 0,
                duration: 0.5,
                onComplete: () => preloader.style.display = 'none'
            });
            
            // Floating elements animation
            initFloatingElements();
            
            // Hero image parallax
            initHeroParallax();
            
            // About image parallax
            initAboutParallax();
            
            // Section reveal animations
            initSectionReveals();
            
            // Stats counter animation
            initStatsCounter();
            
            // Header scroll effect
            initHeaderScroll();
            
            // Card hover animations
            initCardHoverEffects();
            
            // Button hover animations
            initButtonHoverEffects();
            
            // Smooth scrolling for anchor links
            initSmoothScrolling();
        }

        // Floating elements animation
        function initFloatingElements() {
            const floating1 = document.getElementById('floating-1');
            const floating2 = document.getElementById('floating-2');
            const floating3 = document.getElementById('floating-3');
            const floating4 = document.getElementById('floating-4');
            
            // Set initial styles
            gsap.set([floating1, floating2, floating3, floating4], {
                width: '200px',
                height: '200px',
                backgroundColor: 'rgba(0, 180, 216, 0.1)',
                zIndex: -1
            });
            
            // Position elements
            gsap.set(floating1, { x: '20%', y: '20%' });
            gsap.set(floating2, { x: '70%', y: '40%' });
            gsap.set(floating3, { x: '40%', y: '70%' });
            gsap.set(floating4, { x: '80%', y: '80%' });
            
            // Animate elements
            gsap.to(floating1, {
                y: '+=50',
                x: '+=30',
                duration: 10,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });
            
            gsap.to(floating2, {
                y: '+=70',
                x: '-=40',
                duration: 15,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });
            
            gsap.to(floating3, {
                y: '-=60',
                x: '+=50',
                duration: 12,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });
            
            gsap.to(floating4, {
                y: '+=80',
                x: '-=30',
                duration: 14,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });
        }

        // Hero image parallax
        function initHeroParallax() {
            const heroImg = document.getElementById('hero-img');
            gsap.to(heroImg, {
                y: 50,
                scrollTrigger: {
                    trigger: '.hero',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true
                }
            });
        }

        // About image parallax
        function initAboutParallax() {
            const aboutImg = document.getElementById('about-img');
            gsap.to(aboutImg, {
                y: 50,
                scrollTrigger: {
                    trigger: '.about',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true
                }
            });
        }

        // Section reveal animations
        function initSectionReveals() {
            gsap.utils.toArray('section').forEach(section => {
                gsap.from(section, {
                    opacity: 0,
                    y: 50,
                    duration: 1,
                    scrollTrigger: {
                        trigger: section,
                        start: 'top 80%',
                        toggleActions: 'play none none none'
                    }
                });
            });
        }

        // Stats counter animation
        function initStatsCounter() {
            const statItems = document.querySelectorAll('.stat-item');
            statItems.forEach(item => {
                const numberElement = item.querySelector('.stat-number');
                const target = parseInt(numberElement.textContent);
                let count = 0;
                
                ScrollTrigger.create({
                    trigger: item,
                    start: 'top 80%',
                    onEnter: () => {
                        const duration = 2;
                        const increment = target / (duration * 60);
                        
                        const timer = setInterval(() => {
                            count += increment;
                            if (count >= target) {
                                count = target;
                                clearInterval(timer);
                            }
                            numberElement.textContent = Math.floor(count).toLocaleString();
                        }, 1000/60);
                    }
                });
            });
        }

        // Header scroll effect
        function initHeaderScroll() {
            const header = document.getElementById('header');
            ScrollTrigger.create({
                start: 50,
                onUpdate: (self) => {
                    if (self.direction === 1) {
                        // Scrolling down
                        header.classList.add('scrolled');
                    } else {
                        // Scrolling up
                        if (window.scrollY < 50) {
                            header.classList.remove('scrolled');
                        }
                    }
                }
            });
        }

        // Card hover animations
        function initCardHoverEffects() {
            gsap.utils.toArray('.card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    gsap.to(card, {
                        y: -10,
                        boxShadow: '0 15px 30px rgba(0, 180, 216, 0.2)',
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                    
                    if (card.querySelector('.card-icon')) {
                        gsap.to(card.querySelector('.card-icon'), {
                            scale: 1.1,
                            backgroundColor: 'rgba(0, 180, 216, 0.2)',
                            duration: 0.3,
                            ease: 'power2.out'
                        });
                    }
                });

                card.addEventListener('mouseleave', () => {
                    gsap.to(card, {
                        y: 0,
                        boxShadow: '0 5px 15px rgba(0, 0, 0, 0.05)',
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                    
                    if (card.querySelector('.card-icon')) {
                        gsap.to(card.querySelector('.card-icon'), {
                            scale: 1,
                            backgroundColor: 'rgba(0, 180, 216, 0.1)',
                            duration: 0.3,
                            ease: 'power2.out'
                        });
                    }
                });
            });
        }

        // Button hover animations
        function initButtonHoverEffects() {
            gsap.utils.toArray('.btn').forEach(btn => {
                btn.addEventListener('mouseenter', () => {
                    gsap.to(btn, {
                        y: -3,
                        duration: 0.2,
                        ease: 'power2.out'
                    });
                });

                btn.addEventListener('mouseleave', () => {
                    gsap.to(btn, {
                        y: 0,
                        duration: 0.2,
                        ease: 'power2.out'
                    });
                });
            });
        }

        // Smooth scrolling for anchor links
        function initSmoothScrolling() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        gsap.to(window, {
                            duration: 0.8,
                            ease: 'power2.out',
                            scrollTo: {
                                y: targetElement,
                                offsetY: 80
                            }
                        });
                    }
                });
            });
        }

        // ====== Mobile Menu ======
        function initMobileMenu() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const navLinks = document.getElementById('navLinks');
            
            mobileMenuBtn.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                mobileMenuBtn.textContent = navLinks.classList.contains('active') ? '✕' : '☰';
            });
            
            // Close menu when clicking on a link
            navLinks.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    navLinks.classList.remove('active');
                    mobileMenuBtn.textContent = '☰';
                });
            });
        }

        // ====== Scroll Effects ======
        function initScrollEffects() {
            // Add any additional scroll effects here
        }