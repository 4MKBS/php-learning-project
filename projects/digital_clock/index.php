<?php
date_default_timezone_set("Asia/Dhaka"); // Set timezone to Bangladesh
$hour = date("H");
$minute = date("i");
$second = date("s");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Bangladesh Digital Clock</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background-color: #000;
            color: #0f0;
            font-size: 60px;
            text-align: center;
            margin-top: 20%;
        }
    </style>
</head>

<body>
    <div id="clock"></div>

    <script>
        let hour = <?php echo $hour; ?>;
        let minute = <?php echo $minute; ?>;
        let second = <?php echo $second; ?>;

        function updateClock() {
            second++;
            if (second >= 60) {
                second = 0;
                minute++;
            }
            if (minute >= 60) {
                minute = 0;
                hour++;
            }
            if (hour >= 24) {
                hour = 0;
            }

            let session = "AM";
            if (hour >= 12) {
                session = "PM";
            }
            let displayHour = hour % 12;
            displayHour = displayHour ? displayHour : 12; // 0 becomes 12
            let h = displayHour < 10 ? "0" + displayHour : displayHour;
            let m = minute < 10 ? "0" + minute : minute;
            let s = second < 10 ? "0" + second : second;

            document.getElementById("clock").innerHTML = h + ":" + m + ":" + s + " " + session;
        }

        setInterval(updateClock, 1000);
        updateClock(); // initial call
    </script>
</body>

</html>