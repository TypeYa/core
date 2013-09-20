<?php
	/**
	 * Database class
	 *
	 * @author Haris2201 <haris2201@gmail.com>
	 */

	/**
	 * Database class
	 *
	 * We use a MySQL database server for storing messages, user datas,
	 * files etc.
	 *
	 * The class is created with the intention to change the database
	 * system from MySQL to an other if it's required.
	 */
	class Database {
		/**
		 * The database host
		 *
		 * localhost (do not allow other hosts for security reasons!)
		 */
		private static $dbhost = 'localhost';



		/**
		 * The database user
		 */
		private static $dbuser = 'typeya';



		/**
		 * The database password
		 */
		private static $dbpass = '';



		/**
		 * The database name
		 */
		private static $dbname = 'typeya';



		/**
		 * Boolean saves the connection status
		 */
		protected $connected;



		/**
		 * The Mysqli object
		 */
		protected $mysqli;



		/**
		 * The constructor method
		 */
		public function __construct() {
			$this->connected = false;
			$this->connect();
		}



		/**
		 * Protected connect function
		 */
		protected function connect() {
			if($this->connected) {
				return true;	// Already connected
			}
			$this->mysqli = new mysqli(self::$dbhost, self::$dbuser, self::$dbpass, self::$dbname);
			if($this->mysqli->connect_errno) {
				return false;	// Can't connect to server
			}
			else {
				$this->connected = true;
				return true;
			}
		}



		/**
		 * Returns boolean $connected
		 */
		public function isConnected() {
			return $this->connected;
		}



		/**
		 * Disconnects from the Database
		 */
		public function disconnect() {
			if($this->connected) {
				if($this->mysqli->close()) {
					$this->connected = false;
					return true;
				}
				else {
					return false;	// Unknown error
				}
			}
			else {
				return true;	// Already disconnected
			}
		}



		/**
		 * Sends a query to the database & returns result
		 */
		public function query($query) {
			if($result = $this->mysqli->query($query)) {
				return $result;
			}
			else {
				return false;
			}
		}



		/**
		 *  Prepares statement
		 */
		public function getStatement($string) {
			if($statement = $this->mysqli->prepare($string)) {
				return $statement;
			}
			else {
				return false;
			}
		}



		/**
		 * Function returns escaped $string (anti SQL injection)
		 */
		public function escapeString($string) {
			return $this->mysqli->escape_string($string);
		}
	}

?>