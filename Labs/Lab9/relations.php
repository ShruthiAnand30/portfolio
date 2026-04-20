<?php
include('includes/init.inc.php');
include('includes/functions.inc.php');
?>
<title>PHP &amp; MySQL - ITWS</title>

<?php include('includes/head.inc.php'); ?>

<h1>PHP &amp; MySQL</h1>

<?php include('includes/menubody.inc.php'); ?>

<?php
$dbOk = false;

@$db = new mysqli('localhost', 'root', 'root', 'iit');

if ($db->connect_error) {
   echo '<div class="messages">Could not connect to the database. Error: ';
   echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} else {
   $dbOk = true;
}

if ($dbOk) {
   $query = '
      SELECT m.title, m.year, a.first_names, a.last_name, a.dob
      FROM movies m
      JOIN movie_actors ma ON m.movieid = ma.movieid
      JOIN actors a ON ma.actorid = a.actorid
      ORDER BY m.title, a.last_name
   ';

   $result = $db->query($query);
   $numRecords = $result->num_rows;

   echo '<h3>Movies &amp; Their Actors</h3>';
   echo '<table id="relationsTable">';
   echo '<tr><th>Movie Title</th><th>Year</th><th>Actor</th><th>Date of Birth</th></tr>';

   for ($i = 0; $i < $numRecords; $i++) {
      $record = $result->fetch_assoc();
      if ($i % 2 == 0) {
         echo '<tr>';
      } else {
         echo '<tr class="odd">';
      }
      echo '<td>' . htmlspecialchars($record['title']) . '</td>';
      echo '<td>' . htmlspecialchars($record['year']) . '</td>';
      echo '<td>' . htmlspecialchars($record['last_name']) . ', ' . htmlspecialchars($record['first_names']) . '</td>';
      echo '<td>' . htmlspecialchars($record['dob']) . '</td>';
      echo '</tr>';
   }

   echo '</table>';
   $result->free();
   $db->close();
}
?>

<?php include('includes/foot.inc.php'); ?>