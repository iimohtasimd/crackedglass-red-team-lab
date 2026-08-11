<?php
session_start();

// Three users for students to practice with
$users = [
    "admin"   => "password123",
    "Mohan"   => "mohan2004",
    "Roy@EMP-105"   => "onceagain123"
    "kriti1998@gmail.com"     => "kritilovesbruno@9455345519",
];

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];

    // No rate limiting — intentionally vulnerable to brute force
    if (isset($users[$user]) && $users[$user] === $pass) {
        echo "<!DOCTYPE html><html><body>";
        echo "<h2>Login Successful! Welcome, " . $user . "</h2>";
        echo "<p>You cracked it! The password was: <strong>" . $pass . "</strong></p>";
        echo "</body></html>";
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>vocHackingShop — Login</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; display: flex;
           justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .box { background: #fff; padding: 2rem; border-radius: 10px;
           box-shadow: 0 2px 12px rgba(0,0,0,0.1); width: 320px; }
    h2 { margin-bottom: 1.5rem; text-align: center; color: #111; }
    input { width: 100%; padding: 0.6rem; margin-bottom: 1rem;
            border: 1px solid #ddd; border-radius: 6px; font-size: 1rem; }
    button { width: 100%; background: #e94560; color: #fff; padding: 0.7rem;
             border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
    .error { color: red; font-size: 0.9rem; margin-bottom: 1rem; }
  </style>
</head>
<body>
  <div class="box">
    <h2>vocHackingShop Login</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
      <input name="username" placeholder="Username" autocomplete="off" />
      <input name="password" type="password" placeholder="Password" />
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
