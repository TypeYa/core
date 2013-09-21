<?php
	/**
	 * Settings class
	 *
	 * @author Haris2201 <haris2201@gmail.com>
	 */

	/**
	 * Settings class
	 *
	 * Change settings for users via this functions.
	 *
	 * INFO
	 * settings.sql looks like this:
	 *
	 * 1/2
	 *  | id | display_name | status | location | last_seen |
	 * -+----+--------------+--------+----------+-----------+-
	 *  |    |              |        |          |           |
	 *  | user id           | little text about the user
	 *       | name shown            | no word. | timestamp of last
	 *                                          | time active on TypeYa
	 *
	 * 2/2
	 *  | last_online | online | email | phone |
	 * -+-------------+--------+-------+-------+-
	 *  |             |        |       |
	 *  | last time online     | email address
	 *                | online status  | phone number
	 *
	 */
	class Settings {
		/**
		 * The database object
		 */
		protected $database;



		/**
		 * String of table column DISPLAYNAME
		 */
		public static $TY_SET_DISPLAYNAME	= 'display_name';



		/**
		 * String of table column STATUS
		 */
		public static $TY_SET_STATUS		= 'status';



		/**
		 * String of table column LOCATION
		 */
		public static $TY_SET_LOCATION		= 'location';



		/**
		 * String of table column LASTSEEN
		 */
		public static $TY_SET_LASTSEEN		= 'last_seen';



		/**
		 * String of table column LASTONLINE
		 */
		public static $TY_SET_LASTONLINE	= 'last_online';



		/**
		 * String of table column ONLINE
		 */
		public static $TY_SET_ONLINE		= 'online';



		/**
		 * String of table column EMAIL
		 */
		public static $TY_SET_EMAIL			= 'email';



		/**
		 * String of table column PHONE
		 */
		public static $TY_SET_PHONE			= 'phone';



		/**
		 * The constructor method
		 */
		public function __construct($database) {
			$this->database = $database;
		}



		/**
		 * Adds a user to the settings list
		 */
		public function add($id, $displayName = '', $status = 'I am new to TypeYa!', $location = '', $email = '', $phone = '') {
			// Create statement
			$statement = $this->database->getStatement('SELECT * FROM settings WHERE (id=?)');

			// Bind and execute statement
			$statement->bind_param('i', $id);
			$statement->execute();

			// Check database for user settings
			if($statement->get_result()->num_rows !== 0) {
				return false;	// Settings for user already exist
			}

			if(strlen($displayName) > 50) {
				$displayName = '';
			}
			if(strlen($status) > 140) {
				$status = '';
			}
			if(strlen($location) > 30) {
				$location = '';
			}
			if(strlen($email) > 100) {
				$email = '';
			}
			if(strlen($phone) > 20) {
				$phone = '';
			}

			// Validate e-mail address
			if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email)) {
				//E-Mail address isn't valid
			 	$email = '';
			}

			// TODO Check phone number

			//Other settings
			$lastSeen = date("Y-m-d H:i:s", time());
			$lastOnline = $lastSeen;
			$online = 0;

			// Create statement
			$statement = $this->database->getStatement('INSERT INTO settings (id,display_name,status,location,last_seen,last_online,online,email,phone) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');

			// Bind and execute
			$statement->bind_param('isssssiss', $id, $displayName, $status, $location, $lastSeen, $lastOnline, $online, $email, $phone);
			if($statement->execute()) {
				return true;	// User settings created
			}
			else {
				return false;	// Error
			}
		}



		/**
		 * Removes user settings
		 */
		public function remove($id) {
			// Create statement
			$statement = $this->database->getStatement('DELETE FROM settings WHERE (id=?)');

			// Bind and execute statement
			$statement->bind_param('i', $id);
			$statement->execute();

			// Return true
			return true;
		}


		/**
		 * Gets value for settings $key
		 */
		public function get($id, $key) {
			// Create statement
			$statement = $this->database->getStatement('SELECT '.$this->database->escapeString($key).' FROM settings WHERE id=?');

			// Bind and execute statement
			$statement->bind_param('i', $id);
			$statement->execute();

			// Return status
			return $statement->get_result()->fetch_array()[0];
		}



		/**
		 * Sets $value for setting $key
		 */
		public function set($id, $key, $value) {
			// Create statement
			$statement = $this->database->getStatement('UPDATE settings SET '.$this->database->escapeString($key).'=? WHERE id=?');

			// Bind and execute statement
			if($key === self::$TY_SET_ONLINE) {
				$statement->bind_param('ii', $value, $id);
			}
			else {
				$statement->bind_param('si', $value, $id);
			}
			if($statement->execute()) {
				return true;	// User settings edited
			}
			else {
				return false;	// Error
			}
		}
	}

?>