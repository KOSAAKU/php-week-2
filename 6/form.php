<?php
session_start();


if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    echo "You have been logged out.<br>";
    echo "<a href='form.php'>Login again</a>";
    exit();
}


if (!isset($_SESSION['Counter'])) {
    $_SESSION['Counter'] = 0;
}
$_SESSION['Counter']++;


if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $_SESSION['username'] = $username;
    echo "Welcome, " . $username . "!<br>";
    echo "<a href='?logout=1'>Logout</a>";
    exit();
}
?>
<h1>Login</h1>
<form method="POST">
    <label for="username">username :</label>
    <input type="text" id="username" name="username" required><br><br>
    <input type="submit" value="Login">
</form>
