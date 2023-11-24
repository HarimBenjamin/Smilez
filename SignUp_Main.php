<?php
  include 'php.connect.php';
  $success = 0;
  $unsuccess = 0;

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['name'];    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $mysql = "SELECT * FROM people WHERE username='$username'";
    $myresult = mysqli_query($connect, $mysql);

    if ($myresult) {
      $recordnumber = mysqli_num_rows($myresult);

      // If there is a record with the same email, set 'unsuccess' to 1
      if ($recordnumber > 0) {
        $unsuccess = 1;
      } else {
        // Insert values into the database
        $sql = "INSERT INTO people(username, email, password) VALUES('$username','$email', '$password_hash')";
        $result = mysqli_query($connect, $sql);

        if ($result) {
          $success = 1;
          header("location: Login_main.php");
          exit(); // Ensure script stops after redirect
        } else {
          echo "Not inserted: " . mysqli_error($connect);
          // Add appropriate error handling here
        }
      }
    } else {
      echo "Error in query: " . mysqli_error($connect);
      // Add appropriate error handling here
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>
   <link rel="stylesheet" href="smile.css">
</head>
<body>
   <header class="primary header">
      <!-- ... -->
   </header>
   
   <div class="form-container">
      <form action="" method="post" onsubmit="return validateForm(event)">
         <h3>Register <span>Now!</span></h3>
         <input type="text" name="name" required placeholder="Enter your name">
         <input type="email" name="email" required placeholder="Enter your email">
         <input type="password" name="password" required placeholder="Enter your password">
         <input type="password" name="cpassword" required placeholder="Confirm your password">
         <input type="submit" name="submit" value="Register Now" class="form-btn">
         <p>Already have an account? <a href="Login_main.php">Login now</a></p>
      </form>
      <div class="sideimg">
         <img src="9.png" alt="Share Image">
      </div>
   </div>

   <!-- JavaScript validation script -->
   <script>
      function validateForm(event) {
         let name = document.getElementsByName("name")[0];
         let email = document.getElementsByName("email")[0];
         let password = document.getElementsByName("password")[0];
         let submit = document.getElementsByName("submit")[0];

         submit.disabled = !(name.value && email.value && password.value);

         if (event.submitter && event.submitter.name === "submit") {
            if (name.value === "" || email.value === "" || password.value === "") {
               alert("Please fill in all fields.");
               return false;
            }

            if (!/^[a-zA-Z]+$/.test(name.value)) {
               alert("Username should contain only alphabetic characters.");
               return false;
            }

            if (!isValidEmail(email.value)) {
               alert("Invalid email address");
               return false;
            }

            if (!/^[0-9a-zA-Z]+$/.test(password.value)) {
               alert("Password should contain only numbers and alphabets.");
               return false;
            }

            alert("You have successfully registered: " + name.value);
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
