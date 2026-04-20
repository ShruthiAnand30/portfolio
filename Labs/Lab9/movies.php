<?php
include('includes/init.inc.php');
include('includes/functions.inc.php');
?>
<title>PHP &amp; MySQL - ITWS</title>

<?php include('includes/head.inc.php'); ?>
<style>
   #movieTable th, #movieTable td {
      text-align: left;
   }
</style>


<h1>PHP &amp; MySQL</h1>

<?php include('includes/menubody.inc.php'); ?>

<?php
$dbOk = false;

@$db = new mysqli('localhost', 'root', 'Shruthi@30', 'iit');

if ($db->connect_error) {
   echo '<div class="messages">Could not connect to the database. Error: ';
   echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} else {
   $dbOk = true;
}

if ($dbOk) {
   $query = 'select * from movies order by year';
   $result = $db->query($query);
   $numRecords = $result->num_rows;

   echo '<h3>Movies</h3>';
   echo '<table id="movieTable">';
   echo '<tr><th>Title:</th><th>Year:</th></tr>';

   for ($i = 0; $i < $numRecords; $i++) {
      $record = $result->fetch_assoc();
      if ($i % 2 == 0) {
         echo "\n" . '<tr id="movie-' . $record['movieid'] . '"><td>';
      } else {
         echo "\n" . '<tr class="odd" id="movie-' . $record['movieid'] . '"><td>';
      }
      echo htmlspecialchars($record['title']);
      echo '</td><td>';
      echo htmlspecialchars($record['year']);
      echo '</td></tr>';
   }

   echo '</table>';
   $result->free();
   $db->close();
}
?>

<?php include('includes/foot.inc.php'); ?>