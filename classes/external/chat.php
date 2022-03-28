<?php

namespace local_pr_graduates\external;

use coding_exception;
use dml_exception;
use external_api;
use external_function_parameters;
use external_value;
use JsonException;
use \local_pr_graduates\services\api\chat as chat_api;
use moodle_exception;

class chat extends external_api {

	/**
	 * @return external_function_parameters
	 */
	public static function get_messages_parameters(): external_function_parameters {
		return new external_function_parameters([
			'application' => new external_value(PARAM_TEXT),
			'object_id' => new external_value(PARAM_TEXT)
		]);
	}

	/**
	 * @throws coding_exception
	 * @throws moodle_exception
	 * @throws JsonException
	 */
	public static function get_messages(string $application, string $object_id): array {
		return (new chat_api($application, $object_id))->get_messages();
	}

	/**
	 * @return null
	 */
	public static function get_messages_returns() {
		return null;
	}

	/**
	 * @return external_function_parameters
	 */
	public static function send_message_parameters(): external_function_parameters {
		return new external_function_parameters([
			'application' => new external_value(PARAM_TEXT),
			'object_id' => new external_value(PARAM_TEXT),
			'sender' => new external_value(PARAM_TEXT),
			'uid_quote' => new external_value(PARAM_TEXT),
			'message' => new external_value(PARAM_TEXT),
		]);
	}

	/**
	 * @param string $application
	 * @param string $object_id
	 * @param string $sender
	 * @param string $uid_quote
	 * @param string $message
	 * @return array
	 * @throws JsonException
	 * @throws dml_exception
	 * @throws coding_exception
	 * @throws moodle_exception
	 */
	public static function send_message(string $application, string $object_id, string $sender, string $uid_quote, string $message): array {
		return (new chat_api($application, $object_id))->send_message($sender, $uid_quote, $message);
	}

	public static function send_message_returns() {
		return null;
	}
}