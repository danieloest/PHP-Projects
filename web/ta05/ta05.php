<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Team 5</title>
</head>

<body>
   <h1>Scripture Resources</h1>
</body>

<textarea name="" id="searchbar" cols="30 " rows="1"></textarea>
<button onclick="search(document.getElementById('searchbar').value)">Search</button>
<br>
<script>
   function search(text) {
      let url = "ta05.php?search=" + text;
      window.location = url;
   }
</script>
<?php
try {
   $dbUrl = getenv('DATABASE_URL');

   $dbOpts = parse_url($dbUrl);

   $dbHost = $dbOpts["host"];
   $dbPort = $dbOpts["port"];
   $dbUser = $dbOpts["user"];
   $dbPassword = $dbOpts["pass"];
   $dbName = ltrim($dbOpts["path"], '/');

   $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
   echo 'Error!: ' . $ex->getMessage();
   die();
}

// If we are searching
if (isset($_GET['search'])) {
   $stmt = $db->prepare('SELECT book, chapter, verse, id FROM scripture WHERE book=:book');
   $stmt->execute(array(':book' => $_GET['search']));
   $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


   foreach ($rows as $scripture) {
      echo "<b><a href=\"ta05.php?id=" . $scripture['id'] . "\">" . $scripture['book'] . " " . $scripture['chapter'] . ": " . $scripture['verse'] . "</b></a>";
      echo '<br/>';
   }
}
else if (isset($_GET['id'])) {
   // We clicked on a scripture. Pull up the info
   $stmt = $db->prepare('SELECT book, chapter, verse, content FROM scripture WHERE id=:id');
   $stmt->execute(array(':id' => $_GET['id']));
   $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
   foreach ($rows as $scripture) {
      echo "<br><b>" . $scripture['book'] . " " . $scripture['chapter'] . ": " . $scripture['verse'] . "</b> - " . $scripture['content'];
      echo '<br/>';
   }
}
else {
   // we are not searching
   foreach ($db->query('SELECT book, chapter, verse, content FROM scripture') as $scripture) {
      echo "<b>" . $scripture['book'] . " " . $scripture['chapter'] . ": " . $scripture['verse'] . "</b> - " . $scripture['content'];
      echo '<br/>';
   }
}

?>

</html>

