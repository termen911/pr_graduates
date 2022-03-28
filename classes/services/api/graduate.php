<?php

namespace local_pr_graduates\services\api;

use coding_exception;
use dml_exception;
use JsonException;
use moodle_exception;

class graduate extends base {

	private object $data;
	private array $education_data = [];
	private array $fields_edit = [];
	private string $doc_id;
	private string $sender;

	/**
	 * @throws coding_exception
	 * @throws dml_exception
	 * @throws moodle_exception
	 */
	public function __construct() {
		$this->set_host();
		$this->set_login();
		$this->set_password();
		parent::__construct();
	}

	/**
	 * @return object
	 */
	public function get_data(): object {
		return $this->data;
	}

	/**
	 * @return array
	 */
	public function get_education_data(): array {
		return $this->education_data;
	}

	/**
	 * @return array
	 */
	public function get_fields_edit(): array {
		return $this->fields_edit;
	}

	/**
	 * @return string
	 */
	public function get_doc_id(): string {
		return $this->doc_id;
	}

	/**
	 * @return string
	 */
	public function get_sender(): string {
		return $this->sender;
	}

	/**
	 * @throws coding_exception
	 * @throws moodle_exception
	 * @throws JsonException
	 */
	public function get_graduate_info(): void {
		global $USER;

		$params = ['user_id' => $USER->id];

		if (
			get_config('local_pr_graduates', 'enable_test_mode')
			&& get_config('local_pr_graduates', 'test_user_id')
		) {
			$params = ['user_id' => get_config('local_pr_graduates', 'test_user_id')];
		}


		$this->get_curl()->setopt(['CURLOPT_USERPWD' => $this->get_base_auth()]);

		$result = $this->get_curl()->get(
			$this->get_host($this->get_or_fail_config_parameter('endpoint_get_graduate_info')),
			$params
		);

		$this->checkError($result);

		$result = json_decode($result, false, 512, JSON_THROW_ON_ERROR);

		$this->data = (object) $result->data;
		$this->education_data = (array) $result->education_data;
		$this->fields_edit = (array) $result->fields_for_edit;
		$this->doc_id = (string) $result->doc_id;
		$this->sender = (string) $result->sender;
		$this->application = (string) $result->application;
		$this->object_type = (string) $result->object_type;
	}

	/**
	 * @param array $body
	 * @throws coding_exception
	 * @throws moodle_exception
	 * @throws JsonException
	 */
	public function set_graduate_info(array $body): void {
		$body['doc_id'] = $this->get_doc_id();
		$this->get_curl()->setopt(['CURLOPT_USERPWD' => $this->get_base_auth()]);
		$params = json_encode($body, JSON_THROW_ON_ERROR);

		$result = $this->get_curl()->post(
			$this->get_host($this->get_or_fail_config_parameter('endpoint_set_graduate_info')),
			$params
		);

		$this->checkError($result);
	}

	/**
	 * @param int $consent
	 * @return mixed
	 * @throws JsonException
	 * @throws coding_exception
	 * @throws moodle_exception
	 */
	public function change_publication_consent(int $consent) {
		global $USER;
		$params = ['user_id' => $USER->id, 'consent' => $consent];

		if (
			get_config('local_pr_graduates', 'enable_test_mode')
			&& get_config('local_pr_graduates', 'test_user_id')
		) {
			$params = ['user_id' => get_config('local_pr_graduates', 'test_user_id')];
		}

		$this->get_curl()->setopt(['CURLOPT_USERPWD' => $this->get_base_auth()]);

		$result = $this->get_curl()->get(
			$this->get_host($this->get_or_fail_config_parameter('endpoint_change_publication_consent')),
			$params
		);

		$this->checkError($result);

		return json_decode($result, false, 512, JSON_THROW_ON_ERROR);
	}

	/**
	 * @throws coding_exception
	 * @throws dml_exception
	 * @throws moodle_exception
	 */
	protected function set_host(): void {
		$this->host = $this->get_or_fail_config_parameter('host_graduate');
	}

	/**
	 * @throws coding_exception
	 * @throws dml_exception
	 * @throws moodle_exception
	 */
	protected function set_login(): void {
		$this->login = $this->get_or_fail_config_parameter('login_graduate');
	}

	/**
	 * @throws coding_exception
	 * @throws dml_exception
	 * @throws moodle_exception
	 */
	protected function set_password(): void {
		$this->password = $this->get_or_fail_config_parameter('password_graduate');
	}
}