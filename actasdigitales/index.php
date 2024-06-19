<?php
require_once './conexion/Jwt.php'; 
require_once './conexion/Conexion.php';

$token = $_GET['token'] ?? null;
$username = 'Guest'; 

if ($token) {
    try {
        $jwt = new Jwt(Config::SECRET_KEY);
        $decoded = $jwt->decode($token);
        
        // Assuming token payload structure like { "name": "Firstname Lastname" }
        if (isset($decoded['name'])) {
            $username = explode(" ", $decoded['name'])[0]; // Get first part of name
        }
    } catch (Exception $e) {
        error_log('Error decoding token: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="./CSS/styleHome.css">
    <title>Welcome</title>
</head>
<body>

    <h1 id="index-text">Welcome, <?php echo $username; ?> </h1>

</body>
</html>
