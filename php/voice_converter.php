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
  <title>AIverse | Glass TTS</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../css/font.css">
  <link rel="stylesheet" href="../css/tts.css">
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
  <span style="font-weight: bold;">Voice Convertor</span>
</div>
<div class="wrapper">
  <div class="container">
    <div class="glass-card">
      <h2><i class="fas fa-wave-square" style="margin-right: 10px;"></i> Speak Your Text with AI</h2>
      
        <textarea id="textInput" placeholder="Enter your text here...">Welcome to AIverse, your gateway to the future of intelligent automation. With cutting-edge technologies and seamless integration, our platform empowers users to harness the full potential of artificial intelligence. From smart analytics to real-time communication, AIverse makes your digital experience faster, smarter, and more personalized than ever before.</textarea>

      <div class="controls">
        <select id="voiceSelect">
          <option value="EXAVITQu4vr4xnSDxMaL">Rachel</option>
          <option value="21m00Tcm4TlvDq8ikWAM">Domi</option>
          <option value="AZnzlk1XvdvUeBnXmlld">Bella</option>
        </select>

        <button class="btn btn-primary" onclick="convertToSpeech()">
          <i class="fas fa-play" style="margin-right: 8px;"></i> Speak
        </button>
        
        <button class="btn btn-warning" onclick="stopSpeech()">
          <i class="fas fa-stop" style="margin-right: 8px;"></i> Stop
        </button>

        <button class="btn btn-success" onclick="downloadAudio()">
          <i class="fas fa-download" style="margin-right: 8px;"></i> Download
        </button>
      </div>

      <div class="voice-visualizer" id="visualizer">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
      </div>

      <div class="status-message" id="statusMessage"></div>
    </div>
  </div>
</div>
<script>
  let audioBlob = null;
  let audio = null;
  let isPlaying = false;

  // Add ripple effect to buttons
  document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      
      const ripple = document.createElement('span');
      ripple.classList.add('ripple');
      ripple.style.left = `${x}px`;
      ripple.style.top = `${y}px`;
      
      this.appendChild(ripple);
      
      setTimeout(() => {
        ripple.remove();
      }, 600);
    });
  });

  function showStatus(message, type = 'info') {
    const statusElement = document.getElementById('statusMessage');
    statusElement.textContent = message;
    statusElement.className = `status-message ${type} show`;
    
    setTimeout(() => {
      statusElement.classList.remove('show');
    }, 3000);
  }

  function toggleVisualizer(show) {
    const visualizer = document.getElementById('visualizer');
    if (show) {
      visualizer.classList.add('active');
    } else {
      visualizer.classList.remove('active');
    }
  }

  function convertToSpeech() {
    const text = document.getElementById('textInput').value;
    const voiceId = document.getElementById('voiceSelect').value;

    if (!text.trim()) {
      showStatus("Please enter some text.", "error");
      return;
    }

    // Show loading state
    showStatus("Generating speech...", "info");
    toggleVisualizer(false);

    fetch('speak.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ text, voice_id: voiceId })
    })
    .then(res => {
      if (!res.ok) throw new Error("Error generating voice");
      return res.blob();
    })
    .then(blob => {
      audioBlob = blob;
      const url = URL.createObjectURL(blob);
      audio = new Audio(url);
      
      audio.onplay = () => {
        isPlaying = true;
        toggleVisualizer(true);
        showStatus("Playing audio...", "success");
      };
      
      audio.onended = () => {
        isPlaying = false;
        toggleVisualizer(false);
        showStatus("Audio playback completed.", "success");
      };
      
      audio.onerror = () => {
        isPlaying = false;
        toggleVisualizer(false);
        showStatus("Error playing audio.", "error");
      };
      
      audio.play();
    })
    .catch(() => {
      showStatus("Error generating voice. Check API or backend.", "error");
      toggleVisualizer(false);
    });
  }

  function stopSpeech() {
    if (audio) {
      audio.pause();
      audio.currentTime = 0;
      isPlaying = false;
      toggleVisualizer(false);
      showStatus("Playback stopped.", "info");
    }
  }

  function downloadAudio() {
    if (!audioBlob) {
      showStatus("Please generate audio first.", "error");
      return;
    }

    const url = URL.createObjectURL(audioBlob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'speech.mp3';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    showStatus("Download started!", "success");
  }
</script>

</body>
</html>

<?php include 'footer.php'?>