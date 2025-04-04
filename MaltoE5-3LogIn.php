<?php
session_start();
$session_id = session_id();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Execution returns here after submitting the form. Initialize values for uname and pword:
    $username = "8-MrAlex-8";
    $password = "admin";

    //no need to check for isset since input fields have been made required in HTML.

    if ($_POST["user"] == $username && $_POST["pass"] == $password) {

        $_SESSION["username"] = $_POST["user"]; //store username in session for global access -> appearance in headerbar.

        setcookie("username", $_POST["user"], time() + (86400 * 30), "/"); //create a cookie for the username
        header("Location: MaltoE5-3Form.php"); // page redirect with header().
        exit();
    } else {
        $message = "Invalid username or password."; // message with conditional rendering with !empty() at around line 53.
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./MaltoE5-3.css">
</head>

<body>

    <header id="session-header">
        <?php echo "<p>Session ID: " . $session_id . "</p>" ?>
    </header>

    <div id="login-section">

        <form id="login-form" method="POST">

            <h1 id="login-title"> LOGIN FORM</h1>

            <?php
            if (!empty($message)) {
                echo "<p id='warning-notif'> $message </p>";
            }
            ?>

            <section class="username-sec">
                <label for="uname">Username:</label>
                <input type="text" placeholder="Enter Username" id="username"
                    name="user" required>
            </section>

            <section class="password-sec">
                <label for="psw">Password:</label>
                <input type="password" placeholder="Enter Password" id="password"
                    name="pass" required>
            </section>

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>