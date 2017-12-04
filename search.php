<?php
/*set varibles from form */
$searchterm = $_POST['searchterm'];
trim ($searchterm);
/*check if search term was entered*/
if (!$searchterm){
        echo 'Please enter a search term.';
}
/*add slashes to search term*/
if (!get_magic_quotes_gpc())
{
$searchterm = addslashes($searchterm);
}

/* connects to database */
@ $dbconn = new mysqli('localhost', 'root', '', 'koperasi'); 
if (mysqli_connect_errno()) 
{
 echo 'Error: Could not connect to database.  Please try again later.';
 exit;
}
/*query the database*/
$query = "select * from t_anggota where nama_anggota like '%".$searchterm."%'";
$result = $dbconn->query($query);
/*number of rows found*/
$num_results = $result->num_rows;

echo '<p>Found: '.$num_results.'</p>';
/*loops through results*/
for ($i=0; $i <$num_results; $i++)
{
 $num_found = $i + 1;
 $row = $result->fetch_assoc();
 echo "$num_found. ".($row['nama_anggota'])." <br />";
}
/*free database*/
$result->free();
$dbconn->close();
?>