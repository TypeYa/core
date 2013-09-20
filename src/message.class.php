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
		 * Main sending method
		 */
		public function send($from, $to, $type, $content) {
			// TODO support other types (as fast as possible)
			switch($type) {
				case self::$TY_TYPE_MSG:
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
		public function getConversations($from, $count = 10) {
			// TODO get $from's last $count conversations
		}



		/**
		 * Sends a (text) message
		 */
		protected function sendMessage($from, $to, $message) {
			// TODO send message $message to $to from $from
		}



		/**
		 * Gets new messages
		 */
		public function getNew($id, $time) {
			// TODO get unread messages since $time
		}
	}

?>