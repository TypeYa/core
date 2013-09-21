<?php
	/**
	 * Message class
	 *
	 * @author Haris2201 <haris2201@gmail.com>
	 */

	/**
	 * Message class
	 *
	 * Methods including sending, receiving and managing
	 * messages are included here.
	 *
	 * TypeChat Protocol
	 * {
	 *		id:		message id,
	 *		from:	user id,
	 *		to:		[user#1 id, user#2 id, ...],
	 *		type:	msg|loc|set|pic|aud|vid,
	 *		content:CONTENT,
	 *		time:	UNIX timestamp
	 * }
	 */
	class Message {
		/**
		 * The database object
		 */
		protected $database;



		/**
		 * The message type
		 */
		public static $TY_TYPE_MESSAGE	= 'msg';



		/**
		 * The picture type
		 */
		public static $TY_TYPE_PICTURE	= 'pic';



		/**
		 * The location type
		 *
		 * [lat,long]
		 */
		public static $TY_TYPE_LOCATION	= 'loc';



		/**
		 * The setting type
		 *
		 * Settings:
		 * 		group_name
		 *		anonym
		 *
		 * TODO other settings
		 */
		public static $TY_TYPE_SETTING	= 'set';



		/**
		 * The audio type
		 */
		public static $TY_TYPE_AUDIO	= 'aud';



		/**
		 * The video type
		 */
		public static $TY_TYPE_VIDEO	= 'vid';



		/**
		 * The constructor method
		 */
		public function __construct($database) {
			$this->database = $database;
		}



		/**
		 * Main sending method
		 */
		public function send($from, $to, $type, $content) {
			// TODO support other types (as fast as possible)
			switch($type) {
				case self::$TY_TYPE_MESSAGE:
					return $this->sendMessage($from, $to, $content);
				default:
					return false;
			}
		}



		/**
		 * Gets messages
		 */
		public function get($from, $to, $count = 10, $mid = false) {
			// INFO if isset($mid) (message id) get messages from there
			// TODO get $from's last $count messages with $to
		}



		/**
		 * Gets conversations
		 */
		public function getConversations($to, $count = 10) {
			// TODO get last $count conversations with $to
		}



		/**
		 * Sends a (text) message
		 */
		protected function sendMessage($from, $to, $message) {
			if($to > 124) {
				return false;	// Ups.
			}

			if(!$receivers = json_decode($to, true)) {
				return false;	// Invalid $to
			}

			if(strlen($message) > 8000 || strlen($message) === 0) {
				return false;	// $message to long or null
			}

			$time = date("Y-m-d H:i:s", time());

			// TODO Crypt here with RSA-2048 //

			// Send message to everyones inbox
			foreach($receivers as $receiver) {
				// Create statement
				$statement = $this->database->getStatement('INSERT INTO '.$this->database->escapeString($receiver).'_messages (`from`,`to`,type,content,time) VALUES(?, ?, ?, ?, ?)');	// From and to are special strings from MySQL
				if($statement === false) return false;

				// Bind and execute statement
				$statement->bind_param('issss', $from, $to, self::$TY_TYPE_MESSAGE, $message, $time);
				$statement->execute();
			}
		}



		/**
		 * Gets new messages
		 */
		public function getNew($id, $time) {
			// TODO get unread messages since $time
		}
	}

?>