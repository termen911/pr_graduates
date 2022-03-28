<?php

namespace local_pr_graduates\services\api;

use coding_exception;
use dml_exception;
use JsonException;
use moodle_exception;

class chat extends base {

	/**
	 * @throws coding_exception
	 * @throws dml_exception
	 * @throws moodle_exception
	 */
	public function __construct(string $application, string $object_id) {
		$this->set_host();
		$this->set_login();
		$this->set_password();

		$this->set_application($application);
		$this->set_object_type($object_id);

		parent::__construct();
	}

	/**
	 * @param string $application
	 */
	private function set_application(string $application): void {
		$this->application = $application;
	}

	/**
	 * @throws moodle_exception
	 * @throws coding_exception
	 * @throws dml_exception
	 */
	protected function set_host(): void {
		$this->host = $this->get_or_fail_config_parameter('host_chat');
	}

	/**
	 * @throws coding_exception
	 * @throws dml_exception
	 * @throws moodle_exception
	 */
	protected function set_login(): void {
		$this->login = $this->get_or_fail_config_parameter('login_chat');
	}

	/**
	 * @throws coding_exception
	 * @throws dml_exception
	 * @throws moodle_exception
	 */
	protected function set_password(): void {
		$this->password = $this->get_or_fail_config_parameter('password_chat');
	}

	/**
	 * @return array
	 * @throws JsonException
	 * @throws coding_exception
	 * @throws dml_exception
	 * @throws moodle_exception
	 */
	public function get_messages(): array {
		$this->get_curl()->setopt(['CURLOPT_USERPWD' => $this->get_base_auth()]);
		$result = $this->get_curl()->get(
			$this->get_host($this->get_or_fail_config_parameter('endpoint_get_messages')),
			[
				'application' => $this->get_application(),
				'object_type' => $this->get_object_type()
			]
		);

		$this->checkError($result);

		return (array) json_decode($result, false, 512, JSON_THROW_ON_ERROR);
	}

	/**
	 * @param string $sender
	 * @param string $uid_quote
	 * @param string $message
	 * @return array
	 * @throws JsonException
	 * @throws coding_exception
	 * @throws moodle_exception
	 */
	public function send_message(string $sender, string $uid_quote, string $message): array {
		$this->get_curl()->setopt(['CURLOPT_USERPWD' => $this->get_base_auth()]);

		$uri = "?application={$this->get_application()}";
		$uri .= "&object_type={$this->get_object_type()}";
		$uri .= "&sender={$sender}";
		$uri .= "&uid_quote={$uid_quote}";

		$result = $this->get_curl()->post(
			$this->get_host($this->get_or_fail_config_parameter('endpoint_send_message')) . $uri,
			json_encode(['message' => $message], JSON_THROW_ON_ERROR));

		$this->checkError($result);

		return (array) json_decode($result, false, 512, JSON_THROW_ON_ERROR);
	}
}