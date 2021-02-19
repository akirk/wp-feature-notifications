<?php

class WPNotify_Factory {

	const MESSAGE = 'message';
	const RECIPIENTS = 'recipients';

	/**
	 * Message factory implementation to use.
	 *
	 * @var WPNotify_MessageFactory
	 */
	private $message_factory;

	/**
	 * Recipient factory implementation to use.
	 *
	 * @var WPNotify_RecipientFactory
	 */
	private $recipient_factory;

	/**
	 * Sender factory implementation to use
	 *
	 * @var WPNotify_SenderFactory
	 */
	private $sender_factory;

	public function __construct(
		WPNotify_MessageFactory $message_factory,
		WPNotify_RecipientFactory $recipient_factory,
		WPNotify_SenderFactory $sender_factory
	) {
		$this->message_factory   = $message_factory;
		$this->recipient_factory = $recipient_factory;
		$this->sender_factory    = $sender_factory;
	}

	/**
	 * Create a notification instance
	 *
	 * @param $args
	 *
	 * @return WPNotify_BaseNotification
	 */
	public function create( $args ) {

		[ $message_args, $recipients_args, $sender_args ] = $this->validate( $args );

		$sender     = $this->sender_factory->create( $sender_args );
		$recipients = new WPNotify_RecipientCollection();
		$message    = $this->message_factory->create( $message_args );

		foreach ( $recipients_args as $type => $value ) {
			$recipients->add(
				$this->recipient_factory->create( $value, $type )
			);
		}

		return new WPNotify_BaseNotification( $sender, $recipients, $message );
	}

	private function validate( $args ) {
		// TODO: Validate args.
		if ( is_string( $args ) ) {
			$args = json_decode( $args );
		}

		list( $message_args, $recipients_args, $sender_args ) = $args;

		return array(
			$this->get_message_args( $message_args ),
			$this->get_recipients_args( $recipients_args ),
			$this->get_sender_args( $sender_args ),
		);
	}

	private function get_message_args( $args ) {
		// TODO: Parse message args.
		return $args;
	}

	private function get_recipients_args( $args ) {
		// TODO: Parse recipients args.
		return $args;
	}

	public function get_sender_args( $args ) {
		// TODO: Parse sender args.
		return $args;
	}
}