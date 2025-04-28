<?php
$apiKey = "b1fd6e14799699504191b6bdbcadfc35"; // Replace with your API key!
$weatherToday = null;
$forecastData = null;
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["city"])) {
    $city = htmlspecialchars($_POST["city"]);
    // Current weather
    $curUrl = "https://api.openweathermap.org/data/2.5/weather?q=".urlencode($city)."&units=metric&appid=".$apiKey;
    // Forecast
    $foreUrl = "https://api.openweathermap.org/data/2.5/forecast?q=".urlencode($city)."&units=metric&appid=".$apiKey;
    $curRes = @file_get_contents($curUrl);
    $foreRes = @file_get_contents($foreUrl);
    if ($curRes !== FALSE && $foreRes !== FALSE) {
        $weatherToday = json_decode($curRes, true);
        $forecastData = json_decode($foreRes, true);
        if ($weatherToday["cod"] !== 200 || $forecastData["cod"] !== "200") {
            $error = "City not found or error from API.";
            $weatherToday = null; $forecastData = null;
        }
    } else {
        $error = "Could not retrieve data.";
    }
}
function getMainWeatherClass($desc) {
    $desc = strtolower($desc);
    if (strpos($desc, "cloud") !== false) return "bg-cloudy";
    if (strpos($desc, "rain") !== false) return "bg-rainy";
    if (strpos($desc, "clear") !== false) return "bg-sunny";
    if (strpos($desc, "snow") !== false) return "bg-snowy";
    return "bg-default";
}
$weatherClass = ($weatherToday) ? getMainWeatherClass($weatherToday["weather"][0]["description"]) : "bg-default";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weather App Modern</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo $weatherClass; ?>">
    <div class="weather-app">
        <header>
            <h1>Weather App</h1>
            <form method="POST">
                <input type="text" name="city" placeholder="Search city..." value="<?php echo isset($city) ? $city : ''; ?>" required>
                <button type="submit">🔍</button>
            </form>
        </header>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php elseif ($weatherToday): ?>
            <div class="current-weather-card">
                <div class="main">
                    <div class="city"><?php echo htmlspecialchars($weatherToday["name"]); ?></div>
                    <div class="icon-temp">
                        <img src="https://openweathermap.org/img/wn/<?php echo $weatherToday["weather"][0]["icon"]; ?>@4x.png" alt="icon">
                        <span class="temp"><?php echo round($weatherToday["main"]["temp"]); ?>&deg;C</span>
                    </div>
                    <div class="desc"><?php echo ucfirst($weatherToday["weather"][0]["description"]); ?></div>
                </div>
                <div class="details-row">
                    <div><img src="icons/humidity.png" alt="humidity"><span><?php echo $weatherToday["main"]["humidity"]; ?>%</span></div>
                    <div><img src="icons/wind.png" alt="wind"><span><?php echo $weatherToday["wind"]["speed"]; ?> m/s</span></div>
                    <div><img src="icons/pressure.png" alt="pressure"><span><?php echo $weatherToday["main"]["pressure"]; ?> hPa</span></div>
                </div>
            </div>
            <div class="forecast-carousel">
                <h2>5-Day Forecast</h2>
                <div class="carousel-row">
                <?php
                // Pick one forecast per day (at noon)
                $days = [];
                foreach($forecastData["list"] as $entry) {
                    $date = date("Y-m-d", strtotime($entry["dt_txt"]));
                    $hour = date("H", strtotime($entry["dt_txt"]));
                    if (!isset($days[$date]) && $hour === "12") {
                        $days[$date] = $entry;
                    }
                }
                $i=0;
                foreach($days as $date => $entry): if ($i++>=5) break; ?>
                    <div class="forecast-card">
                        <div class="f-date"><?php echo date("D", strtotime($date)); ?></div>
                        <img src="https://openweathermap.org/img/wn/<?php echo $entry["weather"][0]["icon"]; ?>@2x.png" alt="icon">
                        <div class="f-temp"><?php echo round($entry["main"]["temp"]); ?>&deg;C</div>
                        <div class="f-desc"><?php echo ucfirst($entry["weather"][0]["description"]); ?></div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>