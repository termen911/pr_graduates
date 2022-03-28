<?php

require_once(__DIR__ . '/../../config.php');

global $PAGE, $OUTPUT, $DB, $CFG;

use local_pr_graduates\services\api\graduate;
use local_pr_graduates\services\graduate_form;
use local_pr_graduates\services\personal_form;
use local_pr_graduates\services\tools;

defined('MOODLE_INTERNAL') || die();

//TODO добавить проверку прав для выпускника
if (get_config('local_pr_graduates', 'enable_test_mode') && !is_siteadmin()) {
	echo 'При включенном тестовом режиме, страница доступно только администратору!';
	return;
}
if (get_config('local_pr_graduates', 'check_permission')) {
	$eval_string = preg_replace('/([^{,:])"(?![},:])/', "$1" . '\'' . "$2", get_config('local_pr_graduates', 'check_permission'));
	if (strpos($eval_string, 'return') === false) {
		eval($eval_string);
	} else {
		return eval($eval_string);
	}
}

$context = context_system::instance();
$PAGE->set_context($context);

$title = get_string('pluginname', 'local_pr_graduates');
$url = new moodle_url('/local/pr_graduates/index.php');
$url_text = get_string('link_name', 'local_pr_graduates');

$PAGE->set_title($title);
$PAGE->set_url($url);
$PAGE->set_heading($url_text);

$tab = optional_param('tab', 1, PARAM_INT);

$graduate_api = new graduate();
$graduate_api->get_graduate_info();

$tabs = [
	new tabobject(1, new moodle_url($url, ['tab' => 1]), tools::get_localization('first_tab')),
	new tabobject(2, new moodle_url($url, ['tab' => 2]), tools::get_localization('second_tab')),
	new tabobject(3, new moodle_url($url, ['tab' => 3]), tools::get_localization('third_tab'))
];

$graduate_form = new graduate_form($graduate_api->get_education_data());
$personal_form = new personal_form($graduate_api->get_data(), $graduate_api->get_fields_edit());

if ($data = $personal_form->get_data()) {
	$graduate_api->set_graduate_info((array) $data);
	redirect(new moodle_url($url, ['tab' => 2]), 'Успешно обновлено');
}

echo $OUTPUT->header();

$PAGE->requires->css_theme(new moodle_url('/local/pr_graduates/styles.css'));
$PAGE->requires->js_call_amd('local_pr_graduates/main', 'init');

echo $OUTPUT->tabtree($tabs, $tab);
if ($tab === 1) {
	$graduate_form->display();
} else if ($tab === 2) {
	$personal_form->display();
} else {
	$param_js = [
		$graduate_api->get_application(),
		$graduate_api->get_sender(),
		$graduate_api->get_object_type(),
		get_config('local_pr_graduates', 'interval_upload_chat')
	];
	$PAGE->requires->js_call_amd('local_pr_graduates/Chat', 'init', $param_js);
	echo $OUTPUT->render_from_template('local_pr_graduates/chat', []);
}
echo $OUTPUT->footer();