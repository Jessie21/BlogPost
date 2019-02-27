<?php
session_start();
?>
<html>
<head>
<title> LOGIN </title>
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

<?php
function putForm($LInfo,$LInfo2)
{	
	echo "<div class='login-page'>";
	echo "<div class='form'>";
	echo "<h1> Login Page </h1>";
	echo "<form class='login-form' action='login.php' method='post'>";
	echo "Username: <input type='text' name='uName' > </br></br>";
	echo "Password: <input type='password' name='pWord'> </br></br>";
	echo "<input type='submit' name='submit' value='Submit'>";
	echo "</form>";
	echo "</div>";
	echo "</div>";
}
?>
<body>
<?php
$userid = "";
$password = "";

if (!isset($_POST['submit'])){
	
	if(isset($_POST['uName'])){
		$_POST['uName'] = filter_var($_POST['uName'], FILTER_SANITIZE_STRING);
		$userid=$_POST['uName'];
	}
	if(isset($_POST['pWord'])){
		$password=trim($_POST['pWord']);
	}
	putForm($userid,$password); 
	
}

else if (isset($_POST['submit']))
{
	$userid = $_POST['uName'];
	$password = $_POST['pWord'];

    $db_conn = new mysqli('localhost', 'quizhpi', 'jessica2052', 'quizhpi_site');
	//echo "This is the php script running...</br>";
	if (mysqli_connect_errno()) {
		echo 'Connection to database failed:'.mysqli_connect_error();
		exit();
	}
	$query = "SELECT username FROM Users "
               . "WHERE username= ? and password = sha1(?)";
		   
	
	$stmt = $db_conn -> prepare($query);
	$stmt->bind_param('ss',$userid,$password);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($user);
	
	if ($stmt->num_rows >0 )
	{
		// if they are in the database register the user id
		$_SESSION['valid_user'] = $userid;
		$_SESSION['success'] = "You are now logged in";
		header('Location: index.php');
		exit();
	}
	else
		echo "Sorry, invalid user.";
	$stmt->free_result();
	$db_conn->close();
	
}

?>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>
</html>