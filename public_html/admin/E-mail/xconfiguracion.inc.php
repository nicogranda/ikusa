
<?php
  $db_host = ($_ENV['DB_HOST'] ?? '');
  $db_user = ($_ENV['DB_USER'] ?? '');
  $db_password = ($_ENV['DB_PASS'] ?? '');
  $db_db = ($_ENV['DB_NAME'] ?? '');
 
  $mysqli = @new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
  );
	
  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '<br>';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }

?>

