<?php

namespace local_pr_graduates\external;

use coding_exception;
use external_api;
use external_function_parameters;
use external_value;
use JsonException;
use local_pr_graduates\services\api\graduate;
use moodle_exception;

class consent extends external_api {
	/**
	 * @return external_function_parameters
	 */
	public static function change_parameters(): external_function_parameters {
		return new external_function_parameters([
			'consent' => new external_value(PARAM_INT),
		]);
	}

	/**
	 * @throws coding_exception
	 * @throws moodle_exception
	 * @throws JsonException
	 */
	public static function change(int $consent) {
		return (new graduate())->change_publication_consent($consent);
	}

	/**
	 * @return null
	 */
	public static function change_returns() {
		return null;
	}
}