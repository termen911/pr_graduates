<?php

namespace local_pr_graduates\services;

global $PAGE, $OUTPUT, $DB, $CFG, $ADMIN;

class tools {

	private static array $localization_list = [];

	public static function get_localization(string $key) {
		self::set_localization();
		if(
			is_array(self::$localization_list)
			&& array_key_exists(current_language(), self::$localization_list)
			&& array_key_exists($key, self::$localization_list[current_language()])) {
			return self::$localization_list[current_language()][$key];
		}
		debugging("Не удалось найти значение для ключа {$key}! Задайте его в административном разделе!", DEBUG_DEVELOPER);
		return $key;
	}

	private static function set_localization(): void {
		if (!count(self::$localization_list)) {
			foreach (preg_split('/\n|\r\n?\s*/', get_config('local_pr_graduates', 'localization_parameters')) as $item) {
				[$key, $name, $lang] = explode('|', $item);
				self::$localization_list[$lang][$key] = $name;
			}
		}
	}
}