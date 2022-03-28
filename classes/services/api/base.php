<?php

namespace local_pr_graduates\services\api;
global $CFG;
require_once($CFG->libdir . '/filelib.php');

use coding_exception;
use curl;
use dml_exception;
use moodle_exception;

abstract class base {

	protected string $host = '';
	protected string $login = '';
	protected string $password = '';
	protected string $application;
	protected string $object_type;
	private curl $curl;

	public function __construct() {
		$this->set_curl();
	}

	public function get_curl(): curl {
		return $this->curl;
	}
	public function get_host(string $uri = ''): string {
		return $this->host . $uri;
	}
	public function get_login(): string {
		return $this->login;
	}
	public function get_password(): string {
		return $this->password;
	}
	public function get_base_auth(): string {
		return $this->login . ":" . $this->password;
	}

	/**
	 * @return string
	 */
	public function get_object_type() : string {
		return $this->object_type;
	}

	/**
	 * @return string
	 * @throws dml_exception
	 */
	public function get_application(): string {
		if (
			get_config('local_pr_graduates', 'enable_test_mode')
			&& get_config('local_pr_graduates', 'test_application_id')
		) {
			return get_config('local_pr_graduates', 'test_application_id');
		}
		return $this->application;
	}


	/**
	 * @param string $object_type
	 */
	protected function set_object_type(string $object_type): void {
		$this->object_type = $object_type;
	}

	abstract protected function set_host(): void;
	abstract protected function set_login(): void;
	abstract protected function set_password(): void;

	private function set_curl(): void {
		$this->curl = new curl();
		$this->curl->setopt(['CURLOPT_TIMEOUT' => 30]);
	}

	/**
	 * @throws moodle_exception
	 */
	protected function checkError($result): void {
		$code = 500;
		$error = "Неизвестная ошибка на серверах информационной системы";
		$curl_info = (array) $this->get_curl()->get_info();

		if (array_key_exists('http_code', $curl_info)) {
			$code = (int) $curl_info['http_code'];
		}
		if ($code !== 200) {
			if ($code === 401) {
				$error = "Ошибка авторизации в информационной системе";
			}
			$debug_info = sprintf(
				"Ошибка при обращение к основному серверу код - %d. Возвращен ответ %s",
				$code,
				$result
			);
			throw new moodle_exception($error, 'pr_graduates_graduate_api', '', null, $debug_info);
		}
	}

	/**
	 * @param string $key
	 * @return string
	 * @throws coding_exception
	 * @throws dml_exception
	 * @throws moodle_exception
	 */
	protected function get_or_fail_config_parameter(string $key): string {
		if(!get_config('local_pr_graduates', $key)){
			throw new moodle_exception(get_string(
				'not_found',
				'local_pr_graduates',
				['message' => get_string($key . '_desc', 'local_pr_graduates')]
			));
		}
		return get_config('local_pr_graduates', $key);
	}

}