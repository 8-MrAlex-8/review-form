<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_destroy();
    setcookie("username", $_POST["user"], time() - 1000, "/"); // delete cookie upon logout.
    header("Location: MaltoE5-3LogIn.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./MaltoE5-3.css">
</head>

<body>

    <?php
    // Required fields
    $courseError = $yearError = $feedbackError  = "";
    // Fields that shouldn't contain numbers
    $lastError = $firstError = "";
    $emailError = "";

    // checking for the values of these variables. this is done so that, 
    // if the user tests the submission of the form with an error made on-purpose,
    // the values are fed back into the input fields, improving UI.

    // NOTE: ternary form done instead of if-else to shorten code.
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $year = isset($_POST['yrlvl']) ? $_POST['yrlvl'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
    $errorFlag = 0;
    ?>

    <?php
    // Only perform validation if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // test for course field content
        if (empty($_POST["course"])) {
            $courseError = "Course is required!";
            $errorFlag++;
        } else {
            $_SESSION["course"] = $_POST["course"];
        }

        // test for year level section content
        if (empty($_POST["yrlvl"])) {
            $yearError = "Level is required!";
            $errorFlag++;
        } else {
            $_SESSION["yrlvl"] = $_POST["yrlvl"];
        }

        // test for feedback field content
        if (empty($_POST["feedback"])) {
            $feedbackError = "Your feedback is required!";
            $errorFlag++;
        } else {
            $_SESSION["feedback"] = $_POST["feedback"];
        }

        if (isset($_POST["lname"])) {
            if (!empty($_POST["lname"])) {
                // lname value must include only letters.
                if (!preg_match('/^[a-zA-Z]+$/', $_POST["lname"])) {
                    $lastError = "Last Name must not contain numbers!";
                    $errorFlag++;
                } else
                    $_SESSION["lname"] = $_POST["lname"];
            } else
                $_SESSION["lname"] = $_POST["lname"];
        }

        if (isset($_POST["fname"])) {
            if (!empty($_POST["fname"])) {
                // fname value must include only letters.
                if (!preg_match('/^[a-zA-Z]+$/', $_POST["fname"])) {
                    $firstError = "First Name must not contain numbers!";
                    $errorFlag++;
                } else
                    $_SESSION["fname"] = $_POST["fname"];
            } else
                $_SESSION["fname"] = $_POST["fname"];
        }

        if (isset($_POST["email"])) {
            if (!empty($_POST["email"])) {
                // email value must follow a valid format.
                if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $_POST["email"])) {
                    $emailError = "Please enter a valid email address!";
                    $errorFlag++;
                } else
                    $_SESSION["email"] = $_POST["email"];
            } else
                $_SESSION["email"] = $_POST["email"];
        }

        if ($errorFlag == 0) {
            header("Location: MaltoE5-3Summary.php");
        }
    }

    ?>

    <div class="form-content" id="target">
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-power-icon lucide-power">
                        <path d="M12 2v10" />
                        <path d="M18.4 6.6a9 9 0 1 1-12.77.04" />
                    </svg>
                </button>
            </form>
        </header>

        <section class="feedback-form">
            <form method="POST" class="feedback">

                <h1> FEEDBACK FORM </h1>

                <section id="name">

                    <section class="feedback-field">
                        <label for="lname" class="fb-form">Last Name:</label>
                        <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>">
                        <?php if (!empty($lastError)) {
                            echo "<span class = 'red-error'>  $lastError </span>";
                        } ?>
                    </section>

                    <br><br>

                    <section class="feedback-field">
                        <label for="fname" class="fb-form">First Name:</label>
                        <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>">
                        <?php if (!empty($firstError)) {
                            echo "<span class = 'red-error'>  $firstError </span>";
                        } ?>
                    </section>

                </section>

                <br><br>

                <section class="course-section">

                    <div class="course">
                        <div class="item-one">
                            <label for="course" class="fb-form">Course:</label>
                            <select id="course" name="course" size="1">
                                <option value=""></option>
                                <option value="BSIT" <?php echo ($course == 'BSIT') ? 'selected' : ''; ?>>Information Technology</option>
                                <option value="BSCS" <?php echo ($course == 'BSCS') ? 'selected' : ''; ?>>Computer Science</option>
                                <option value="BSIS" <?php echo ($course == 'BSIS') ? 'selected' : ''; ?>>Information Systems</option>
                                <option value="BLIS" <?php echo ($course == 'BLIS') ? 'selected' : ''; ?>>Library and Information Science</option>
                            </select>
                            <?php if (!empty($courseError)) {
                                echo "<span class = 'red-error'>  $courseError </span>";
                            } ?>
                        </div>
                    </div>

                    <div class="email-section">
                        <label for="email" class="fb-form">E-mail:</label>
                        <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                        <?php if (!empty($emailError)) {
                            echo "<span class = 'red-error'>  $emailError </span>";
                        } ?>
                    </div>

                </section>

                <br><br>

                <div class="bottom-section">
                    <section class="year-radio">
                        <div class="options">
                            <label for="yrlvl" class="fb-form">Year Level:</label>

                            <div class="first">
                                <input type="radio" id="lvl-i" name="yrlvl" value="I" <?php echo ($year == 'I') ? 'checked' : ''; ?>>
                                <label for="lvl-i" class="light fb-form">Level I</label>
                            </div>

                            <div class="second">
                                <input type="radio" id="lvl-ii" name="yrlvl" value="II" <?php echo ($year == 'II') ? 'checked' : ''; ?>>
                                <label for="lvl-ii" class="light fb-form">Level II</label>
                            </div>

                            <div class="third">
                                <input type="radio" id="lvl-iii" name="yrlvl" value="III" <?php echo ($year == 'III') ? 'checked' : ''; ?>>
                                <label for="lvl-iii" class="light fb-form">Level III</label>
                            </div>

                            <div class="fourth">
                                <input type="radio" id="lvl-iv" name="yrlvl" value="IV" <?php echo ($year == 'IV') ? 'checked' : ''; ?>>
                                <label for="lvl-iv" class="light fb-form">Level IV</label>
                            </div>
                        </div>
                        <br>
                        <div clsas="yrlvl-msg">
                            <?php if (!empty($yearError)) {
                                echo "<span class = 'red-error'>  $yearError </span>";
                            } ?>
                        </div>
                    </section>

                    <section class="feedback-section">
                        <div class="prompt">
                            <div class="feedback-one">
                                <label for="feedback" class="fb-form">Tell us about your CCS experience:</label>
                            </div>
                            <div class="feedback-two">
                                <textarea name="feedback" id="feedback" class="form-1" rows="5" cols="36"><?php echo $feedback; ?></textarea>
                            </div>
                            <div class="feedback-three">
                                <?php if (!empty($feedbackError)) {
                                    echo "<span class = 'red-error'>  $feedbackError </span>";
                                } ?>
                            </div>
                        </div>
                        <div class="submit-form">
                            <input type="submit">
                        </div>

                    </section>
                </div>


            </form>
        </section>
    </div>
</body>

</html>