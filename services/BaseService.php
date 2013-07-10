<?php

/**
 * Base service class for all the service
 */

class BaseService {
	/*
	protected $username = "root";
	protected $password = "root";
	protected $server = "localhost";
	protected $port = "8889";
	protected $databasename = "landtrendr";
	*/
	
	protected $username = "root";
	protected $password = "jka9f#ccW3";
       	protected $server = "localhost";
	protected $port = "3306";
	protected $databasename = "landtrendr2";
	
	
	public $tablename;
	public $connection;

	/**
	 * Utility function to throw an exception if an error occurs
	 * while running a mysql command.
	 */
	protected function throwExceptionOnError($link = null) {
		if($link == null) {
			$link = $this->connection;
		}
		if(mysqli_error($link)) {
			$msg = mysqli_errno($link) . ": " . mysqli_error($link);
			throw new Exception('MySQL Error - '. $msg);
		}
	}

	protected function connect($autocommit=true) {
	  	$this->connection = mysqli_connect(
	  							$this->server,
	  							$this->username,
	  							$this->password,
	  							$this->databasename,
	  							$this->port
	  						);
		$this->throwExceptionOnError($this->connection);
		mysqli_autocommit($this->connection, $autocommit);
		$this->throwExceptionOnError($this->connection);
	}

  protected function close() {
    mysqli_close($this->connection);
  }

	protected function getIP() {
		$ip;
		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else
			$ip = "UNKNOWN";
		return $ip;
	}

}
