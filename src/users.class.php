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
		protected function add($username, $password) {
			// TODO add user, generate token, write down
			// registration time etc
		}

		protected function remove($username) {
			// TODO remove user, messages and so on
		}

		public function register_via_mail($mail, $username, $password) {
			// TODO add user via mail
		}

		public function reigster_via_phone($phone, $username, $password) {
			// TODO add user via phone number
		}

		public function activate($username) {
			// TODO set activation status to 1
			// INFO
			// 0 = unactive, 1 = active, 2 = pro, 3 = dev
		}
	}

?>