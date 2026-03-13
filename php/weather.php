 <?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<?php
$weatherData = null; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $city = htmlspecialchars($_POST['city']); 
    $apiKey = '717aa625d6e9f10a7d41c3de8f46c990'; 
    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

    try {
        $response = file_get_contents($url);

        if ($response === FALSE) {
            throw new Exception("Failed to retrieve data from the API.");
        }

        $weatherData = json_decode($response, true);

        if (!$weatherData || $weatherData['cod'] != 200) {
            throw new Exception("City not found or invalid API response.");
        }
    } catch (Exception $e) {
        $weatherData = null; 
        $error = $e->getMessage(); 
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='https://unpkg.com/boxicons@latest/css/boxicons.min.css'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIverse | Weather Forecast</title>
    <link rel="icon" href="../img\Screenshot_2025-06-29_121809-removebg-preview.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css\font.css">
    <link rel="stylesheet" href="../css/weather.css">
</head>
<body>
    <?php include 'header.php'; include 'background.php'; ?>
        <div style="padding: 20px 30px; background: linear-gradient(to right, #e0f7faaa, #f0fcff54); border-radius: 12px; margin: 30px auto; max-width: 600px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); color: #0077b6; display: flex; align-items: center; gap: 10px; font-size: 18px; margin-top:150px;">
  <i class="fa-solid fa-house" style="color: #00b4d8;"></i>
  <a href="index.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Home</a>
  <span>/</span>
  <i class="fa-solid fa-briefcase" style="color: #00b4d8;"></i>
  <a href="service.php" style="color: #0077b6; text-decoration: none; font-weight: 500;">Services</a>
  <span>/</span>
  <span style="font-weight: bold;">Weather</span>
</div>

    <div class="glass-card">
        <h2>
            <i class="bi bi-cloud rotate weather-icon" style="font-size: 40px; margin-right: 15px;"></i>
            Weather Insights
        </h2>

        <form method="POST">
            <div class="form-group">
                <input type="text" name="city" class="form" placeholder="Enter city name" required>
            </div>
            <button type="submit" class="btn-glass" data-toggle="tooltip" title="Click to get weather for the city!">
                Get Weather
            </button>
        </form>

        <?php if ($weatherData): ?>
            <div class="weather-card">
                <h5 style="font-weight: 600; margin-bottom: 20px; color: var(--primary-color);">
                    Weather in <?php echo htmlspecialchars($city); ?>
                </h5>
                
                <p class="data-label">
                    <i class="bi bi-thermometer weather-icon"></i>
                    Temperature:
                </p>
                <p class="data-value"><?php echo $weatherData['main']['temp']; ?> °C</p>
                
                <p class="data-label">
                    <i class="bi bi-droplet weather-icon"></i>
                    Humidity:
                </p>
                <p class="data-value"><?php echo $weatherData['main']['humidity']; ?> %</p>
                
                <p class="data-label">
                    <i class="bi bi-speedometer weather-icon"></i>
                    Pressure:
                </p>
                <p class="data-value"><?php echo $weatherData['main']['pressure']; ?> hPa</p>
                
                <p class="data-label">
                    <i class="bi bi-stickies weather-icon"></i>
                    Description:
                </p>
                <p class="data-value"><?php echo ucfirst($weatherData['weather'][0]['description']); ?></p>
                
                <p class="data-label">
                    <i class="bi bi-wind weather-icon"></i>
                    Wind Speed:
                </p>
                <p class="data-value"><?php echo $weatherData['wind']['speed']; ?> m/s (1 mile ≈ 1.6 km)</p>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <div class="alert alert-danger" role="alert" style="margin-top: 20px; border-radius: 8px;">
                City not found. Please try again.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'footer.php'?>