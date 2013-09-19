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
	 *  | last_online | online | picture |
	 * -+-------------+--------+---------+-
	 *  | timestamp of last time online
	 *                | online status
	 *                         | uploaded picture (JPEG)
	 */
	class Settings {
		/**
		 * String of table column DISPLAYNAME
		 */
		public static $TY_SET_DISPLAYNAME	= 'display_name';



		/**
		 * String of table column DISPLAYNAME
		 */
		public static $TY_SET_STATUS		= 'status';



		/**
		 * String of table column DISPLAYNAME
		 */
		public static $TY_SET_LOCATION		= 'location';



		/**
		 * String of table column DISPLAYNAME
		 */
		public static $TY_SET_LASTSEEN		= 'last_seen';



		/**
		 * String of table column DISPLAYNAME
		 */
		public static $TY_SET_LASTONLINE	= 'last_online';



		/**
		 * String of table column DISPLAYNAME
		 */
		public static $TY_SET_ONLINE		= 'online';



		/**
		 * String of table column DISPLAYNAME
		 */
		public static $TY_SET_PICTURE		= 'picture';


		/**
		 * Get value for settings $key
		 */
		public function get($key) {
			// TODO return value for setting $key
		}



		/**
		 * Set $value for setting $key
		 */
		public function set($key, $value) {
			// TODO set setting $key with value $value
		}
	}

?>