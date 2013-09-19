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
		 * Add a new (activated) user
		 */
		protected function add($username, $password) {
			if($this->exists($username) {
				// $username already in user
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
		}



		/**
		 * Remove a user
		 */
		protected function remove($username) {
			// TODO remove user, messages and so on
		}



		/**
		 * Change the status from a user
		 */
		public function status($username, $status = 1) {
			// TODO change user status
			// INFO
			// 0 = banned, 1 = active, 2 = pro, 3 = dev
		}



		/**
		 * Return username by $id
		 */
		public function username($id) {
			// TODO return username by $id
		}



		/**
		 * Check if $username exists
		 */
		public function exists($username) {
			// TODO check if user exists
		}



		/**
		 * Return id by $username
		 */
		public function id($username) {
			// TODO return user id by $username
		}



		/**
		 * Returns password for $username
		 */
		private function password($username) {
			// TODO return password from user
		}



		/**
		 * Returns token for $username
		 */
		private function token($username) {
			// TODO return token from user
		}



		/**
		 * Changes password from user
		 */
		public function changePassword($username, $password) {
			// Hash $password with token
			$password = hash('sha256', $this->token($username) . $password);

			//TODO save password in database
		}



		/**
		 * Return boolean if input is valid
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