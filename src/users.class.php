<?php
	/**
	 * Users class
	 *
	 * @author Haris2201 <haris2201@gmail.com>
	 */
	
	/**
	 * Users class
	 *
	 * Base user informations controlled with this
	 * functions.
	 *
	 * INFO
	 * users.sql looks like this:
	 *
	 *  | id | username | password | token | registered | status |
	 * -+----+----------+----------+-------+------------+--------+-
	 *  |    |          |          |       |            |        |
	 *  | user id       | hashed password  | registration time
	 *       | username            | random generated token
	 *                                                  | status [0/1/2/3]
	 */
	class Users {
		/**
		 * The database object
		 */
		protected $database;



		/**
		 * The constructor method
		 */
		public function __construct($database) {
			$this->database = $database;
		}



		/**
		 * Adds a new (activated) user
		 */
		public function add($username, $password) {
			if($this->exists($username)) {
				// $username already in use
				return false;
			}

			if(strlen($username) > 50 || strlen($username) < 6) {
				// $username to short or to long
				return false;
			}

			if(strlen($password) > 50 || strlen($password) < 6) {
				// $password to short or to long
				return false;
			}

			// Generate random token
			$token = hash('sha256', rand(0, 2048) . 'x' . rand(0, 2048) . 'x' . rand(0, 2048) . 'x' . rand(0, 2048));

			// Hash $password with new token
			$password = hash('sha256', $token . $password);

			// Write down current time
			$registered = date("Y-m-d H:i:s", time());

			// Set status to 1 (active)
			$status = 1;

			// Create statement
			$statement = $this->database->getStatement('INSERT INTO users (username,password,token,registered,status) VALUES(?, ?, ?, ?, ?)');
			if($statement === false) return false;

			// Bind and execute
			$statement->bind_param('ssssi', $username, $password, $token, $registered, $status);
			if($statement->execute()) {
				return true;	// User created
			}
			else {
				return false;	// Error
			}
		}



		/**
		 * Removes a user
		 */
		public function remove($username) {
			// Create statement
			$statement = $this->database->getStatement('DELETE FROM users WHERE (username=?)');

			// Bind and execute statement
			$statement->bind_param('s', $username);
			$statement->execute();

			// Return true
			return true;
		}



		/**
		 * Changes the status from a user
		 */
		public function status($username, $status = false) {
			// false = get status, 0 = banned, 1 = active, 2 = pro, 3 = dev
			if($status === false) {
				// Create statement
				$statement = $this->database->getStatement('SELECT status FROM users WHERE (username=?)');

				// Bind and execute statement
				$statement->bind_param('s', $username);
				$statement->execute();

				// Return status
				return $statement->get_result()->fetch_array()[0];
			}
			else {
				// Create statement
				$statement = $this->database->getStatement('UPDATE users SET status=? WHERE username=?');

				// Bind and execute statement
				$statement->bind_param('is', $status, $username);
				$statement->execute();

				// Return true
				return true;
			}
		}



		/**
		 * Returns username by $id
		 */
		public function username($id) {
			// Create statement
			$statement = $this->database->getStatement('SELECT username FROM users WHERE (id=?)');

			// Bind and execute statement
			$statement->bind_param('i', $id);
			$statement->execute();

			// Return id
			return $statement->get_result()->fetch_array()[0];
		}



		/**
		 * Checks if $username exists
		 */
		public function exists($username) {
			// Create statement
			$statement = $this->database->getStatement('SELECT * FROM users WHERE (username=?)');

			// Bind and execute statement
			$statement->bind_param('s', $username);
			$statement->execute();

			// Check database for user
			if($statement->get_result()->num_rows === 1) {
				return true;
			}
			else {
				return false;
			}
		}



		/**
		 * Returns id by $username
		 */
		public function id($username) {
			// Create statement
			$statement = $this->database->getStatement('SELECT id FROM users WHERE (username=?)');

			// Bind and execute statement
			$statement->bind_param('s', $username);
			$statement->execute();

			// Return id
			return $statement->get_result()->fetch_array()[0];
		}



		/**
		 * Returns password for $username
		 */
		protected function password($username) {
			// Create statement
			$statement = $this->database->getStatement('SELECT password FROM users WHERE (username=?)');

			// Bind and execute statement
			$statement->bind_param('s', $username);
			$statement->execute();

			// Return password
			return $statement->get_result()->fetch_array()[0];
		}



		/**
		 * Returns token for $username
		 */
		protected function token($username) {
			// Create statement
			$statement = $this->database->getStatement('SELECT token FROM users WHERE (username=?)');

			// Bind and execute statement
			$statement->bind_param('s', $username);
			$statement->execute();

			// Return token
			return $statement->get_result()->fetch_array()[0];
		}



		/**
		 * Changes password from user
		 */
		public function changePassword($username, $password) {
			if(strlen($password) > 50 || strlen($password) < 6) {
				// $password to short or to long
				return false;
			}

			// Hash $password with token
			$password = hash('sha256', $this->token($username) . $password);

			// TODO save password in database
		}



		/**
		 * Returns boolean if input is valid
		 */
		public function check($username, $password) {
			// Hash $password with token
			$password = hash('sha256', $this->token($username) . $password);

			if($password === $this->password($username)) {
				// Valid input
				return true;
			}
			else {
				// Invalid input
				return false;
			}
		}
	}

?>