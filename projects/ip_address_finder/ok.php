<?php
function getClientIP() {
    $ip_keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($ip_keys as $key) {
        if (!empty($_SERVER[$key])) {
            $iplist = explode(',', $_SERVER[$key]);
            foreach ($iplist as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }
    return 'UNKNOWN';
}
$ip = getClientIP();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your IP Address</title>
  <style>
    body {
      font-family: sans-serif;
      background: #f0f0f0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    h1 {
      color: #333;
    }
    .ip {
      margin-top: 15px;
      font-size: 22px;
      color: #007bff;
    }
  </style>
</head>
<body>
  <div class="box">
    <h1>Your IP Address</h1>
    <div class="ip"><?php echo htmlspecialchars($ip); ?></div>
  </div>
</body>
</html>
