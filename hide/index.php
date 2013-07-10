<!-- 20121228 donj -->

<!DOCTYPE html> 
<html>
<head><title>Test Page</title></head>
	<body>
		<?php
		error_reporting(E_ALL);
		require_once 'login.php';
		echo "<h1>Test Connection to MySQL Using PHP</h1><br \>";
		$mysqli = mysqli_init();
		if (!$mysqli) {
			die('mysqli_init failed');
		}

		// Transaction must be manually committed with the COMMIT command
		if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
			die('Setting MYSQLI_INIT_COMMAND failed');
		}

		if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
			die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
		}

		if (!$mysqli->real_connect($DatabaseServer, $DatabaseUsername, $DatabasePassword, NULL, $DatabasePort)) {
			die('Connect Error (' . mysqli_connect_errno() . ')'); 
		}
		else {
			echo 'Success connecting to mysql server ' . $mysqli->host_info . '<br />';
		}

		$DatabaseName = 'mysql';
		if (!$mysqli->select_db($DatabaseName)) {
			die('Failure selecting database &quot' . $DatabaseName . '&quot with error number: ' . $mysqli->errno);
		}	
		else {
			echo 'Success selecting database &quot' . $DatabaseName . '&quot<br />';
		}

		$mysqli->close();
		
	?>
	</body>
</html>
