<html>
<head>
<title>View Comments</title>
<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body style="background-color:#D0D3D4;">
<?php
//have all users read comments of the post they choose
function login()
{
	$db = new mysqli('localhost', 'quizhpi', 'jessica2052', 'quizhpi_site');
	return $db;
}

$db = login();
if (mysqli_connect_errno()) {
	echo 'Error: Could not connect to database. Please try again.';
	exit;
}
$id = $_GET['id'];
$query = "SELECT * FROM Comments WHERE postID = $id";
$stmt = $db -> prepare($query);
echo $db -> error;
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $uName, $bComment, $pID, $datePosted);
echo "<div class='container'>";
while ($stmt->fetch())
{
	echo "<p class='font-weight-bold'>".$uName. "</p>";
	echo "<p>".$bComment. "</p>";
	echo "<p>".$datePosted. "</p></br>";
	
}
echo "</div>";
$stmt->free_result();
$db->close();
?>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>
</html>