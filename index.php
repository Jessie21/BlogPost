<?php
session_start();
?>
<html>
<head>
	<title>Index</title>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

</head>
<body style="background-color:#D0D3D4;">
<!--<h1>BLOG POSTS</h1>-->
<?php
function login()
{
	$db = new mysqli('localhost', 'quizhpi', 'jessica2052', 'quizhpi_site');
	return $db;
}
?>
<?php
if (isset($_SESSION['valid_user'])){
?>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#">BLOG POSTS</a>

	<ul class="nav justify-content-end">
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
		<?php echo "Welcome ".$_SESSION['valid_user']. "!"; ?>       
		  </a>
		  <div class="dropdown-menu">
			<a class="dropdown-item" href="addBlogPosting.php">Add Post</a>
			<a class="dropdown-item" href="logOut.php">Log Out</a>
		  </div>
		</li>
	  </ul>
</nav>
<?php
}
else if(!isset($_SESSION['valid_user'])){
?>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#">BLOG POSTS</a>
	<ul class="nav justify-content-end">
		<li class="nav-item dropdown">
		  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">      
		  Guest</a>
		  <div class="dropdown-menu">
			<a class="dropdown-item" href="login.php">Login</a>
			<a class="dropdown-item" href="signUp.php">Sign Up</a>
		  </div>
		</li>
	  </ul>
</nav>
<?php
}
	
$db = login();
if (mysqli_connect_errno()) {
	echo 'Error: Could not connect to database. Please try again.';
	exit;
}
//add in the following
  if (isset($_GET['page']))
	  $thispage = $_GET['page'];
  else
	  $thispage = 1;
  
$recordsperpage = 5;   //set the number of records that you want on each page that renders
$offset = ($thispage - 1) * $recordsperpage;

//-------------------------------------------------------------------------------------
$query = "SELECT * FROM Post ORDER BY date_time DESC LIMIT $offset, $recordsperpage";

$stmt = $db -> prepare($query);
//echo $db -> error;
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id,$title, $post, $userN, $DatePosted);
echo "<div class='container'>";
while ($stmt->fetch()) {
	

	echo "<p class='font-weight-bold'>".$title. "</p>";
	echo "<p>".$post. "</p>";
	echo "<p>".$userN. "</p>";
	echo "<p>".$DatePosted. "</p>";
	
	echo "<a href='addComment.php?id=".$id."'><button>Add Comment</button></a>";
	echo "<a href='viewComment.php?id=".$id."'><button>Read Comment</button></a>";
	echo "</br></br>";
	
  }
  echo "</div>";
//----------------------------------------------------------------------------------

//this is for counting the pages
$total = "SELECT COUNT(*) FROM Post ORDER BY date_time DESC";
$stmt = $db -> prepare($total);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($totrecords);
$stmt->fetch();

//how many pages are needed to show all the records
$totalpages =  ceil($totrecords / $recordsperpage);  //should give 2 for now since totrecords is 10

			

$stmt->free_result();


$db->close();
//create a bar for the pages
echo "<div class='container'>";
for ($i = 1; $i <= $totalpages; $i++){

	echo '<a href="index.php?page=' .$i. '">' .$i. '</a> ';

}
echo "</div>";
?>
</br>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

</body>
</html>