<?php
// Start the session
session_start();
?>
<?php
if (isset($_SESSION["user"])) {
?>
<h1>The content which only can user "user" access</h1>
<?php
} else {
    header("Location: /XSS_scenario/login.php");
    die();
}
?>