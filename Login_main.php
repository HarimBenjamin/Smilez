<?php
include 'php.connect.php';

$success = 0;
$unsuccess = 0;
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];

    // Check if the user exists
    $sql = "SELECT * FROM people WHERE email = ?";
    $stmt = mysqli_prepare($connect, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            echo "Email: $email<br>";


            // Verify the password
            if ($row && password_verify($password, $row['password'])) {
                $success = 1;
                header("location: User_Home.php");
                exit();
            } else {
                $unsuccess = 1; // Incorrect password
                $error_message = "Incorrect email or password. Please try again.";
                echo $error_message;
            }

            mysqli_free_result($result);
        } else {
            $unsuccess = 1; // Query failed
            $error_message = "Login failed. Please try again later.";
            echo $error_message;

        }

        mysqli_stmt_close($stmt);
    } else {
        $unsuccess = 1; // Statement preparation failed
        $error_message = "Login failed. Please try again later.";
        echo $error_message;

    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>
   <link rel="stylesheet" href="smile.css">
</head>
<body>
   <header class="primary header">
      <!-- ... -->
   </header>
   
   <div class="form-container">
      <form action="" method="post" onsubmit="return validateForm(event)">
         <h3>Login to <span>Your Account</span></h3>
         <input type="email" name="email" required placeholder="Enter your email">
         <input type="password" name="password" required placeholder="Enter your password">
         <input type="submit" name="submit" value="Login" class="form-btn">
         <p>Don't have an account? <a href="SignUp_Main.php">Register now</a></p>
      </form>
      <div class="sideimg">
         <img src="9.png" alt="Share Image">
      </div>
   </div>

   <!-- JavaScript validation script -->
   <script>
      function validateForm(event) {
         let email = document.getElementsByName("email")[0];
         let password = document.getElementsByName("password")[0];
         let submit = document.getElementsByName("submit")[0];

         submit.disabled = !(email.value && password.value);

         if (event.submitter && event.submitter.name === "submit") {
            if (email.value === "" || password.value === "") {
               alert("Please fill in all fields.");
               return false;
            }

            if (!isValidEmail(email.value)) {
               alert("Invalid email address");
               return false;
            }

            alert("Logging in...");
            return true;
         }
      }

      function isValidEmail(email) {
         const emailPattern = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;
         return emailPattern.test(email);
      }
   </script>
</body>
</html>
