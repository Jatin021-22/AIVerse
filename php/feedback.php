<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Feedback | AIVerse</title>
  
  <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    :root {
      --primary: #e6f7ff;
      --accent: #0077b6;
      --gradient: linear-gradient(135deg, #00b4d8, #0077b6);
      --white: #fff;
      --radius: 20px;
      --shadow: 0 12px 30px rgba(0, 119, 182, 0.2);
      --glass-bg: rgba(255, 255, 255, 0.3);
      --glass-border: rgba(255, 255, 255, 0.5);
    }

    .feedback-container {
      width: 100%;
      max-width: 900px;
      background: var(--glass-bg);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: var(--radius);
      border: 1px solid var(--glass-border);
      box-shadow: var(--shadow);
      padding: 40px 30px;
      animation: fadeIn 1s ease forwards;
      margin-top:80px;
      margin-left:320px;
      margin-bottom:20px;
    }

    .feedback-container h2 {
      text-align: center;
      color: var(--accent);
      font-size: 26px;
      font-weight: 600;
      margin-bottom: 25px;
    }

    .form-icon {
      position: relative;
      margin-bottom: 20px;
    }

    .form-icon input,
    .form-icon textarea {
      width: 100%;
      padding: 15px 15px 15px 45px;
      border: 1px solid #b3e0ff;
      border-radius: var(--radius);
      background: rgba(255, 255, 255, 0.85);
      font-size: 15px;
      transition: all 0.3s ease;
      color: #333;
    }

    .form-icon textarea {
      resize: vertical;
      min-height: 120px;
    }

    .form-icon input:focus,
    .form-icon textarea:focus {
      border-color: var(--accent);
      outline: none;
      box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.2);
      background: #fff;
    }

    .form-icon::before {
      content: '';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      left: 15px;
      top: 14px;
      color: var(--accent);
      font-size: 18px;
      pointer-events: none;
    }

    .name-field::before { content: '\f007'; }   /* user */
    .email-field::before { content: '\f0e0'; }  /* envelope */
    .subject-field::before { content: '\f02b'; } /* tag */
    .message-field::before { content: '\f303'; top: 18px; } /* edit */

    button {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: var(--radius);
      font-size: 16px;
      font-weight: 600;
      color: #fff;
      background: var(--gradient);
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    button:hover {
      background: linear-gradient(135deg, #0096c7, #005f86);
      transform: translateY(-2px);
    }

    button i {
      font-size: 16px;
    }
    .rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: start;
    gap: 6px;
    font-size: 1.8rem;
    margin: 12px 0;
    }

    .rating input {
    display: none;
    }

    .rating label {
    cursor: pointer;
    color: #ccc;
    transition: transform 0.2s ease, color 0.2s ease, text-shadow 0.2s ease;
    filter: drop-shadow(0 0 2px rgba(0,0,0,0.1));
    }

    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
    color: gold;
    transform: scale(1.2);
    text-shadow: 0 0 8px rgba(255, 215, 0, 0.6);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
      .feedback-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>

<?php include 'background.php'?>
<?php include 'header.php'?>
<body>

    <div style="padding: 20px 30px; background: linear-gradient(to right, #e0f7fa39, #f0fcff54); border-radius: 12px; margin: 30px auto; max-width: 600px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); color: #0077b6; display: flex; align-items: center; gap: 10px; font-size: 18px; margin-top:150px;">
  <i class="fa-solid fa-house" style="color: #00b4d8;"></i>
  <a href="index.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Home</a>
  <span>/</span>
  <span style="font-weight: bold;">Feedback</span>
</div>
  <form class="feedback-container" action="submit_feedback.php" method="POST">
    <h2> We Value Your Feedback</h2>

    <div class="form-icon name-field">
      <input type="text" name="name" placeholder=" Your Name" required />
    </div>

    <div class="form-icon email-field">
      <input type="email" name="email" placeholder=" Your Email" required />
    </div>

    <div class="form-icon subject-field">
      <input type="text" name="subject" placeholder=" Subject" required />
    </div>

    <div class="form-icon message-field">
      <textarea name="message" placeholder=" Your Message..." required></textarea>
    </div>
    <div class="rating-group" required>
    <div class="rating">
        <input type="radio" id="star5" name="rating" value="5" required />
        <label for="star5" title="Amazing!">⭐</label>

        <input type="radio" id="star4" name="rating" value="4" />
        <label for="star4" title="Good">⭐</label>

        <input type="radio" id="star3" name="rating" value="3" />
        <label for="star3" title="Average">⭐</label>

        <input type="radio" id="star2" name="rating" value="2" />
        <label for="star2" title="Poor">⭐</label>

        <input type="radio" id="star1" name="rating" value="1" />
        <label for="star1" title="Terrible">⭐</label>
    </div>
    </div>
<button type="submit" class="feedback-submit-btn">
  <i class="fas fa-paper-plane"></i> Submit Feedback
</button>
  </form>

</body>
</html>
<?php include 'footer.php'?>