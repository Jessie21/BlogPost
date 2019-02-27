<html>
<head>
<title>Add Comments</title>
<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body style="background-color:#D0D3D4;">
<?php
//have only authorized users add comments
session_start();
date_default_timezone_set('America/New_York');//
function login()
{
	$db = new mysqli('localhost', 'quizhpi', 'jessica2052', 'quizhpi_site');
	return $db;
}
//form to insert comments
//-------------------------------------------------------------------------------
if (isset($_SESSION['valid_user']))
{
	echo "<nav class='navbar navbar-expand-sm bg-dark navbar-dark'>
	  <!-- Brand/logo -->
	  <a class='navbar-brand' href='#'>Adding Comment</a>
	  </nav></br>
	  <div class='container'>
	<form  method='Post' id='usrform'>
		  <input type='hidden' name='date' value='".date("Y-m-d h:i:s")."'>
		  Comment:
		  <input type='hidden' name='".$_SESSION['valid_user']."'></br></br>  
		  <textarea rows='4' cols='50' name='message' form='usrform'></textarea>
		  </br>
		  <input type='submit' name='submit' value='Post Comment'>
		</form>
		<br>
		</div>";
	$username = "";//Name: 
	$comments = "";
	$date = "";
	if (isset($_POST['submit'])){
		$username = $_SESSION['valid_user'];
		if(isset($_POST['date'])){
			$date = $_POST['date'];
		}
		if(isset($_POST['message'])){
			$comments = $_POST['message'];
		}
		
		$db = login();
		if (mysqli_connect_errno()) {
			echo 'Error: Could not connect to database. Please try again.';
			exit;
		}
		$id = $_GET['id'];
			/*if (empty($username)) 
			{ 
				echo "Username is required"; 
			}
			if (empty($comments)) 
			{ 
				echo "Need to write something"; 
			}*/
			
		$query = "SELECT postID FROM Post WHERE postID = $id";
		$stmt = $db -> prepare($query);
		echo $db -> error;
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($postID);
		$stmt->fetch();
			
		$insertQuery = "INSERT INTO Comments (username, bodyComment, postID, date_time)
						VALUES('$username','$comments','$postID','$date') ";
			//$stmt = $db -> prepare($insertQuery);
		echo $db -> error;
		mysqli_query($db, $insertQuery);
		$db->close();

		echo "You have successfully submitted!";
		echo "<a href='index.php'><button>Return to home page</button></a>";
	}
}
else if (!isset($_SESSION['valid_user']))
{
	echo "Sorry, you need to be an authorized user to do this!";
	echo "<a href='login.php'><button>Click here</button></a>";
}
?>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>
</html>