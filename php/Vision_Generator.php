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
    <title>Vision Generator | AIVerse</title>
    <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <!-- GSAP Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <link rel="stylesheet" href="../css/vision.css">
</head>
<?php include 'header.php' ?>
<?php include 'background.php' ?>
<body>
    <div style="padding: 20px 30px; background: linear-gradient(to right, #e0f7faaa, #f0fcff54); border-radius: 12px; margin: 30px auto; max-width: 600px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); color: #0077b6; display: flex; align-items: center; gap: 10px; font-size: 18px; margin-top:150px;">
  <i class="fa-solid fa-house" style="color: #00b4d8;"></i>
  <a href="index.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Home</a>
  <span>/</span>
  <i class="fa-solid fa-briefcase" style="color: #00b4d8;"></i>
  <a href="service.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Services</a>
  <span>/</span>
  <span style="font-weight: bold;">Vision Generator</span>
</div>

    <div class="containerV">
        <div class="p">
            <h1>Vision Image Generator</h1>
            <p class="subtitle">Transform your ideas into stunning visuals .</p>
    </div>
        
        <div class="content">
            <div class="input-group">
                <textarea id="prompt" placeholder="e.g. 'A futuristic cityscape at sunset with flying cars and neon lights'"></textarea>
            </div>
            
            <button id="generate-btn">
                <span class="btn-text">Generate Image</span>
                <span class="btn-icon">✨</span>
            </button>
            
            <div id="loading" class="loading">
                <div class="spinner-container">
                    <div class="spinner"></div>
                    <div class="spinner-inner"></div>
                </div>
                <p>Creating your masterpiece...</p>
                <div class="progress-text">0%</div>
            </div>
            
            <div id="result-area" class="result-area">
                <img id="generated-image" alt="Generated image will appear here">
                <button id="download-btn">Download Image</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate container entrance
            gsap.to(".container", {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: "back.out(1.2)"
            });
            
            // Animate header elements
            gsap.from("header h1, header .subtitle", {
                y: -20,
                opacity: 0,
                duration: 0.8,
                stagger: 0.2,
                delay: 0.3
            });
            
            // Animate content elements
            gsap.from(".input-group, #generate-btn", {
                y: 20,
                opacity: 1,
                duration: 0.6,
                stagger: 0.15,
                delay: 0.6
            });
            
            // DOM elements
            const generateBtn = document.getElementById('generate-btn');
            const btnText = generateBtn.querySelector('.btn-text');
            const promptInput = document.getElementById('prompt');
            const loadingDiv = document.getElementById('loading');
            const resultArea = document.getElementById('result-area');
            const generatedImage = document.getElementById('generated-image');
            const downloadBtn = document.getElementById('download-btn');
            const progressText = document.querySelector('.progress-text');
            
            // Create loading dots element
            function createLoadingDots() {
                const dots = document.createElement('span');
                dots.className = 'loading-dots';
                dots.innerHTML = '<span></span><span></span><span></span>';
                return dots;
            }
            
            // Generate image function (keeping original backend functionality)
            generateBtn.addEventListener('click', function() {
                const prompt = promptInput.value.trim();
                
                if (!prompt) {
                    // Shake animation for empty input
                    gsap.to(promptInput, {
                        x: [-5, 5, -5, 5, 0],
                        duration: 0.4,
                        ease: "power1.out",
                        onStart: () => {
                            promptInput.style.borderColor = '#ff5252';
                        },
                        onComplete: () => {
                            gsap.to(promptInput, {
                                borderColor: '#d1e7ff',
                                duration: 0.5,
                                delay: 0.5
                            });
                        }
                    });
                    return;
                }
                
                // Show loading with animation
                loadingDiv.style.display = 'block';
                resultArea.style.display = 'none';
                generateBtn.disabled = true;
                
                // Update button text and add loading dots
                btnText.textContent = 'Generating';
                const loadingDots = createLoadingDots();
                btnText.appendChild(loadingDots);
                
                // Simulate progress (will be replaced by actual progress from backend)
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += Math.random() * 10;
                    if (progress > 100) progress = 100;
                    progressText.textContent = Math.min(progress, 100).toFixed(0) + '%';
                    
                    if (progress >= 100) {
                        clearInterval(progressInterval);
                    }
                }, 300);
                
                // Original backend fetch call
                fetch('generate.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ prompt })
                })
                .then(res => res.json())
                .then(data => {
                    // Hide loading, show result
                    loadingDiv.style.display = 'none';
                    generateBtn.disabled = false;
                    clearInterval(progressInterval);
                    
                    // Restore button text
                    btnText.textContent = 'Generate Image';
                    btnText.querySelector('.loading-dots')?.remove();
                    
                    if (data.success) {
                        generatedImage.src = data.image;
                        
                        // Show result area with animation
                        resultArea.style.display = 'block';
                        gsap.to(resultArea, {
                            opacity: 1,
                            y: 0,
                            duration: 0.6,
                            ease: "back.out(1.2)"
                        });
                        
                        // Image load handler
                        generatedImage.onload = function() {
                            generatedImage.classList.add('loaded');
                            
                            // Scroll to result smoothly
                            resultArea.scrollIntoView({ 
                                behavior: 'smooth',
                                block: 'center'
                            });
                        };
                    } else {
                        // Error animation
                        gsap.to(generateBtn, {
                            backgroundColor: "#ff6b6b",
                            duration: 0.3,
                            yoyo: true,
                            repeat: 1,
                            onComplete: () => {
                                alert(data.error || 'Image generation failed');
                            }
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    loadingDiv.style.display = 'none';
                    generateBtn.disabled = false;
                    clearInterval(progressInterval);
                    
                    // Restore button text with error state
                    btnText.textContent = 'Try Again';
                    btnText.querySelector('.loading-dots')?.remove();
                    
                    // Network error animation
                    gsap.to([generateBtn, promptInput], {
                        backgroundColor: "#ff6b6b",
                        duration: 0.2,
                        yoyo: true,
                        repeat: 1,
                        onComplete: () => {
                            alert('Network error');
                        }
                    });
                });
            });
            
            // Download functionality
            downloadBtn.addEventListener('click', function() {
                if (!generatedImage.src) return;
                
                // Create temporary link
                const link = document.createElement('a');
                link.href = generatedImage.src;
                link.download = `ai-image-${Date.now()}.jpg`;
                
                // Add link to DOM, click it, then remove
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                // Add download confirmation animation
                const originalText = downloadBtn.textContent;
                downloadBtn.textContent = '✓ Downloaded!';
                downloadBtn.style.backgroundColor = '#4caf50';
                
                setTimeout(() => {
                    downloadBtn.textContent = originalText;
                    downloadBtn.style.backgroundColor = '';
                }, 2000);
            });
        });
    </script>
</body>
</html>

<?php include 'footer.php'?>