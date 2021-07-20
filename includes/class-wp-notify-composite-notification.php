<?php

/**
 * Class WP_Notify_Composite_Notification
 *
 * Allows a notification to be extended with optional fields
 */
class WP_Notify_Composite_Notification extends WP_Notify_Base_Notification {

	const FIELD_TITLE = 'title';

	/**
	 * Associative array, keys must match the class FIELD_* constants.
	 *
	 * @var array
	 */
	private $additional_fields = array();

	/**
	 * @param WP_Notify_Notification $notification
	 * @return WP_Notify_Composite_Notification
	 */
	public static function from_notification( $notification ) {
		return new self(
			$notification->get_sender(),
			$notification->get_recipients(),
			$notification->get_message(),
			$notification->get_timestamp(),
			$notification->get_id()
		);
	}

	public function add( $name, $value ) {
		$this->additional_fields[ $name ] = $value;
	}

	public function get_field( $name ) {
		if ( array_key_exists( $name, $this->additional_fields ) ) {
			return $this->additional_fields[ $name ];
		}
	}

	public function jsonSerialize() {
		return array_merge(
			parent::jsonSerialize(),
			$this->additional_fields
		);
	}

	public static function json_unserialize( $json ) {
		$composite_notification = self::from_notification( parent::json_unserialize( $json ) );

		foreach ( json_decode( $json ) as $name => $value ) {
			if ( WP_Notify_Composite_Notification::FIELD_TITLE === $name ) {
				$composite_notification->add( $name, $value );
			}
		}

		return $composite_notification;
	}
}