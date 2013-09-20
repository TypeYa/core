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
	 *  | last_online | online |
	 * -+-------------+--------+-
	 *  |             |
	 *  | timestamp of last time online
	 *                | online status
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
		 * The constructor method
		 */
		public function __construct($database) {
			$this->database = $database;
		}



		/**
		 * Adds a user to the settings list
		 */
		public function add($id, $displayName = '', $status = 'I am new on TypeYa!', $location = '') {
			if(strlen($displayName) > 50) {
				$displayName = '';
			}
			if(strlen($status) > 140) {
				$status = '';
			}
			if(strlen($location) > 30) {
				$location = '';
			}

			//Other settings
			$lastSeen = date("Y-m-d H:i:s", time());
			$lastOnline = $lastSeen;
			$online = 0;

			// Create statement
			$statement = $this->database->getStatement('INSERT INTO settings (id,display_name,status,location,last_seen,last_online,online) VALUES(?, ?, ?, ?, ?, ?, ?)');

			// Bind and execute
			$statement->bind_param('isssssi', $id, $displayName, $status, $location, $lastSeen, $lastOnline, $online);
			if($statement->execute()) {
				return true;	// User settings created
			}
			else {
				return false;	// Error
			}
		}



		/**
		 * Gets value for settings $key
		 */
		public function get($id, $key) {
			// Create statement
			$statement = $this->database->getStatement('SELECT ? FROM settings WHERE (id=?)');

			// Bind and execute statement
			$statement->bind_param('si', $key, $id);
			$statement->execute();

			// Return status
			return $statement->get_result()->fetch_array()[0];
		}



		/**
		 * Sets $value for setting $key
		 */
		public function set($id, $key, $value) {
			// Create statement
			$statement = $this->database->getStatement('UPDATE users SET status=? WHERE username=?');

			// Bind and execute statement
			$statement->bind_param('is', $status, $username);
			if($statement->execute()) {
				return true;	// User settings edited
			}
			else {
				return false;	// Error
			}
		}
	}

?>