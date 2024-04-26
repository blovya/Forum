<?php
  if (isset($_SESSION['username']))
  {
  header("Location:list_threads.php");
  exit;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>User Registration</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="Registration form of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
	  <script>
      function validateForm() {
        
        // Create a variable to refer to the form
        var form = document.register;
      
        // Tests if the username field is less than 6 characters long or more than 20 characters long
        if (form.uname.value.length < 6 || form.uname.value.length > 20) {
          alert('Username must be between 6 and 20 characters long.');
          return false;
        }
      
        // Tests if the password field is less than 8 characters long
        if (form.pword.value.length < 8) {
          alert('Password must be at least 8 characters long.');
          return false;
        }

        // Tests if the password and password confirmation fields do not match
        if (form.pword.value != form.pword_conf.value) {
          alert('Password does not match confirmation.');
          return false;
        }

        // Tests if the date of birth is empty
        if (form.dob.value == '') {
          alert('Date of Birth not specified.');
          return false;
        }
      
        // Tests if the "I Agree..." checkbox is unchecked
        if (!form.agree.checked) {
          alert('You must agree to the terms and conditions.');
          return false;
        }		
      }
    </script>
  </head>

  <body>
    <h3>Create Account</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
    <form name="register" method="post" action="register.php" onsubmit="return validateForm()">

      <fieldset><legend>User Credentials</legend>
  
        <label><span>Username<sup>*</sup>:</span><input type="text" name="uname" autofocus /></label>

        <label><span>Password<sup>*</sup>:</span><input type="password" name="pword" /></label>

        <label><span>Confirm Password<sup>*</sup>:</span><input type="password" name="pword_conf" /></label>
  
      </fieldset>
  
      <fieldset><legend>Other Details</legend>
  
        <label><span>Real Name:</span><input type="text" name="rname" /></label>

        <label><span>Date of Birth<sup>*</sup>:</span><input type="date" name="dob" /></label>

        <br />

        <label class="middle"><input type="checkbox" name="agree" /> I agree to all terms and conditions.</label>

        <input type="submit" name="submit" value="Submit" class="middle" />
      </fieldset>
    </form>
  </body>
</html>