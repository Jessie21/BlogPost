<html>
<head>
<title>Add Post</title>
<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body style="background-color:#D0D3D4;">
<?php
session_start();
date_default_timezone_set('America/New_York');//
function login()
{
	$db = new mysqli('localhost', 'quizhpi', 'jessica2052', 'quizhpi_site');
	return $db;
}
if (!isset($_SESSION['valid_user']))
{
	echo "Sorry, you need to be an authorized user to do this!";
	echo "<a href='login.php'><button>Click here</button></a>";
}
else if (isset($_SESSION['valid_user']))
{
	echo "<nav class='navbar navbar-expand-sm bg-dark navbar-dark'>
	  <!-- Brand/logo -->
	  <a class='navbar-brand' href='#'>Adding New Post</a>
	  </nav></br>
	  <div class='container'>
		<form  method='Post' id='usrform'>
			  Title: <input type='text' name='title'></br></br>
			  <input type='hidden' name='date' value='".date("Y-m-d h:i:s")."'>
			  Create Post:
			  <input type='hidden' name='".$_SESSION['valid_user']."'></br></br> 
			  <textarea rows='4' cols='50' name='message' form='usrform'></textarea></br>
			  <input type='submit' name='submit' value='Submit Post'>
			</form>
		<br>
		</div>";
	
	$username = "";
	$comments = "";
	$date = "";
	$title = "";
	if (isset($_POST['submit'])){
		$username = $_SESSION['valid_user'];
		if(isset($_POST['date'])){
			$date = $_POST['date'];
		}
		if(isset($_POST['message'])){
			$comments = $_POST['message'];
		}
		if(isset($_POST['title'])){
			$title = $_POST['title'];
		}
		
		$db = login();
		if (mysqli_connect_errno()) {
			echo 'Error: Could not connect to database. Please try again.';
			exit;
		}
		$insertQ = "INSERT INTO Post (title, bodyPost, username, date_time)
						VALUES('$title', '$comments','$username','$date') ";
		//$stmt = $db -> prepare($insertQ);
		echo $db -> error;
		mysqli_query($db, $insertQ);
		$db->close();
	
		echo "You have successfully submitted!";
		echo "<a href='index.php'><button>Return to home page</button></a>";
	}	
}
?>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>
</html>