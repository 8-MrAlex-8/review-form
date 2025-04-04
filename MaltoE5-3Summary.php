<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['logout'])) {
        session_destroy();
        setcookie("username", $_POST["user"], time() - 1000, "/"); // delete cookie upon logout.
        header("Location: MaltoE5-3LogIn.php"); // kill session post-logout
        exit;
    } else if (isset($_POST['back'])) {
        header("Location: MaltoE5-3Form.php"); // redirect to eval form for new feedback.
    }
}

$lname = $_SESSION["lname"];
$fname = $_SESSION["fname"];
$course = $_SESSION["course"];
$year = $_SESSION["yrlvl"];
$email = $_SESSION["email"];
$feedback = $_SESSION["feedback"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./MaltoE5-3.css">
</head>

<body>
    <div class="form-content">
        <header id="form-header">
            <div class="user-info">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<h3>Hello, " . $_SESSION['username'] . "!</h3>";
                }
                // just in case
                else {
                    echo "<i>[ERROR]: User not initialized.<i>";
                }
                ?>
            </div>

            <form method="POST" id="logoutbtn">
                <button class="logout" type="submit" name="logout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-power-icon lucide-power">
                        <path d="M12 2v10" />
                        <path d="M18.4 6.6a9 9 0 1 1-12.77.04" />
                    </svg>
                </button>
            </form>
        </header>

        <div>
            <p id="thanks-notif"> Thank you! Your response has been recorded. </p>
        </div>

        <div class="summary-form">
            <div class="info">
                <?php
                echo "<h3>Review Summary:</h3>";

                // Check if first name, last name, and email are all provided:
                if ($lname != "" && $fname != "" && $email != "") {
                    echo
                    "<p>
                            Reviewed by: <br>
                            $lname, $fname ($course, $year) - $email
                        </p>";
                }

                // If all are empty, only show course and year.
                else if ($lname == "" && $fname == "" && $email == "") {
                    echo
                    "<p>
                            Reviewed by: <br>
                            $course, $year
                        </p>";
                }

                // if ONLY email is empty:
                else if ($lname != "" && $fname != "" && $email == "") {
                    echo
                    "<p>
                            Reviewed by: <br>
                            $lname, $fname ($course, $year)
                        </p>";
                }

                // if ONLY email is supplied:
                else if ($lname == "" && $fname == "" && $email != "") {
                    echo
                    "<p>
                            Reviewed by: <br>
                            $email ($course, $year)
                        </p>";
                }

                // if one name + the email is supplied:
                else if (($lname != "" || $fname != "") && $email != "") {
                    echo
                    "<p>
                            Reviewed by: <br>
                            $lname $fname [$email] ($course, $year)
                        </p>";
                }

                // if only one name, and no email is supplied:
                else {
                    echo
                    "<p>
                            Reviewed by: <br>
                            $lname $fname - $course, $year
                        </p>";
                }

                // print this part regardless of edge case
                echo
                "<p>
                        Review:<br>
                        $feedback
                    </p>";

                ?>
            </div>

            <div id="back-btn">
                <form method="POST" id="backbtn">
                    <button class="back" type="submit" name="back">
                        <p>Back</p>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>