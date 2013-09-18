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
		private static $dbpass = '********';



		/**
		 * The database name
		 */
		private static $dbname = 'typeya';



		/**
		 * Boolean saves the connection status
		 */
		protected $connected;



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
			if(mysql_connect(self::$dbhost, self::$dbuser, self::$dbpass)) {
				if(mysql_select_db(self::$dbname)) {
					$this->connected = true;
					return true;
				}
				else {
					return false;	// Can't select database
				}
			}
			else {
				return false;	// Can't connect to server
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
				if(mysql_close()) {
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
		 * Gets the row from $result
		 */
		public function getRow($result) {
			if(!is_resource($result)) {
				return false;	// $result isn't a resource
			}
			if($row = mysql_fetch_array($result)) {
				return $row;
			}
			else {
				return false;	// Error
			}
		}

		/**
		 * Checks if one or more rows exist
		 */
		public function rowExists($result) {
			if(mysql_num_rows($result) == 0) {
				return false;	// Zero rows
			}
			else {
				return true;
			}
		}

		/**
		 * Function returns escaped $string (anti SQL injection)
		 */
		public function escapeString($string) {
			return mysql_real_escape_string($string);
		}
	}