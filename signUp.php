<html>
<head>
	<title> Sign-Up </title>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<style>
	.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4CAF50;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
body {
  background: #76b852; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  background: -moz-linear-gradient(right, #76b852, #8DC26F);
  background: -o-linear-gradient(right, #76b852, #8DC26F);
  background: linear-gradient(to left, #76b852, #8DC26F);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
</style>
</head>
<body>
<div class="login-page">
	<h1>SIGN UP FORM</h1>
	<p>Please fill out the form below: </p>
	<div class="form">
	
	

	<form class="login-form" method="post" action="signUp.php">
		<div class="input-group">
		  <label>Username</label>
		  <input type="text" name="uName">
		</div></br></br>
		<div class="input-group">
		  <label>Email</label>
		  <input type="email" name="email">
		</div></br></br>
		<div class="input-group">
		  <label>Password</label>
		  <input type="password" name="pWord1">
		</div></br></br>
		<div class="input-group">
		  <label>Confirm password</label>
		  <input type="password" name="pWord2">
		</div></br></br>
		<div class="input-group">
		  <button type="submit" class="btn" name="reg_user">Register</button>
		</div></br></br>
		<p>
			Already a member? <a href="login.php">Sign in</a>
		</p>
	  </form>
	  </div>
</div>
  
  <?php
session_start();

// initializing variables
$username = "";
$email    = ""; 

// connect to the database
$db_conn = new mysqli('localhost', 'quizhpi', 'jessica2052', 'quizhpi_site');
	//echo "This is the php script running...</br>";
	if (mysqli_connect_errno()) {
		echo 'Connection to database failed:'.mysqli_connect_error();
		exit();
	}
// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  if ($_POST['uName'] != ""){
	$_POST['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$username = $_POST['uName'];
  }
  if ($_POST['email'] != ""){
	  $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	  $email = $_POST['email'];
  }
  $password_1 = $_POST['pWord1'];
  $password_2 = $_POST['pWord2'];

  // form validation: ensure that the form is correctly filled
  if (empty($username)) 
	{ 
		echo "Username is required"; 
	}
  if (empty($email)) 
	{ 
		echo "Email is required"; 
	}
  if (empty($password_1)) 
	{ 
		echo "Password is required"; 
	}
  if ($password_1 != $password_2) {
	echo "The two passwords do not match";
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $checkUser_query = "SELECT * FROM Users WHERE username='$username' OR emailAddress='$email' LIMIT 1";
  
$stmt = $db_conn -> prepare($checkUser_query);
echo $db_conn -> error;
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($user, $Email);
while ($stmt->fetch())
{
   //$result = mysqli_query($db, $user_check_query);
  //$user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['uName'] === $username) {
      echo "Username already exists";
    }

    if ($user['email'] === $email) {
      echo "email already exists";
    }
  }
}
  // Finally, register user if there are no errors in the form

		$password = sha1($password_1);//encrypt the password before saving in the database

		$query = "INSERT INTO Users (username, emailAddress, password) 
				  VALUES('$username', '$email', '$password')";
		mysqli_query($db_conn, $query);
		$_SESSION['valid_user'] = $username;
		header('location: index.php');
	
  
}
?>  
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>
</html>