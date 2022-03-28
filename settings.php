<?php

use local_pr_graduates\services\setting\admin_setting_localization_list;

require_once(__DIR__ . '/../../config.php');
global $PAGE, $OUTPUT, $DB, $CFG, $ADMIN;

//is prod

if ($hassiteconfig) {
	$settings = new admin_settingpage('local_pr_graduates', 'PR и работа с выпускниками');
	$ADMIN->add('localplugins', $settings);

	$heading = 'Информация по выпускника';
	$information = 'В данном блоке отображается вся информация необходимая для корректной работы раздела работа с выпускниками';

	$settings->add(new admin_setting_heading('heading_element_1', $heading, $information));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/host_graduate',
		get_string('host_graduate', 'local_pr_graduates'),
		get_string('host_graduate_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/login_graduate',
		get_string('login_graduate', 'local_pr_graduates'),
		get_string('login_graduate_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));

	$settings->add(new admin_setting_configpasswordunmask(
		'local_pr_graduates/password_graduate',
		get_string('password_graduate', 'local_pr_graduates'),
		get_string('password_graduate_desc', 'local_pr_graduates'),
		''
	));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/endpoint_get_graduate_info',
		get_string('endpoint_get_graduate_info', 'local_pr_graduates'),
		get_string('endpoint_get_graduate_info_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/endpoint_set_graduate_info',
		get_string('endpoint_set_graduate_info', 'local_pr_graduates'),
		get_string('endpoint_set_graduate_info_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/endpoint_change_publication_consent',
		get_string('endpoint_change_publication_consent', 'local_pr_graduates'),
		get_string('endpoint_change_publication_consent_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));

	$heading = 'Информация по чату';
	$information = 'В данном блоке отображается вся информация необходимая для корректной работы раздела с чатом';

	$settings->add(new admin_setting_heading('heading_element_2', $heading, $information));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/host_chat',
		get_string('host_chat', 'local_pr_graduates'),
		get_string('host_chat_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/login_chat',
		get_string('login_chat', 'local_pr_graduates'),
		get_string('login_chat_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));

	$settings->add(new admin_setting_configpasswordunmask(
		'local_pr_graduates/password_chat',
		get_string('password_chat', 'local_pr_graduates'),
		get_string('password_chat_desc', 'local_pr_graduates'),
		''
	));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/endpoint_get_messages',
		get_string('endpoint_get_messages', 'local_pr_graduates'),
		get_string('endpoint_get_messages_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/endpoint_send_message',
		get_string('endpoint_send_message', 'local_pr_graduates'),
		get_string('endpoint_send_message_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/interval_upload_chat',
		get_string('interval_upload_chat', 'local_pr_graduates'),
		get_string('interval_upload_chat_desc', 'local_pr_graduates'),
		'',
		PARAM_INT,
		30
	));

	$heading = 'Локализация';
	$information = 'В данном блоке отображается вся информация для локализации динамический полей поступающих на форму';

	$settings->add(new admin_setting_heading('heading_element_3', $heading, $information));

	$settings->add(new admin_setting_localization_list(
		'local_pr_graduates/localization_parameters',
		get_string('localization_parameters', 'local_pr_graduates'),
		get_string('localization_parameters_desc', 'local_pr_graduates'),
		"",
		PARAM_TEXT,
		30
	));

	$heading = 'Дополнительно';
	$settings->add(new admin_setting_heading('heading_element_4', $heading, $information));

	$settings->add(new admin_setting_configtextarea(
		'local_pr_graduates/check_permission',
		get_string('check_permission', 'local_pr_graduates'),
		get_string('check_permission_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));


	$heading = 'Тестирование';
	$information = 'В данном блоке отображается вся информация необходимая для проведения тестирования данного плагина';

	$settings->add(new admin_setting_heading('heading_element_5', $heading, $information));

	$settings->add(new admin_setting_configcheckbox(
		'local_pr_graduates/enable_test_mode',
		get_string('enable_test_mode', 'local_pr_graduates'),
		get_string('enable_test_mode_desc', 'local_pr_graduates'),
		''
	));

	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/test_user_id',
		get_string('test_user_id', 'local_pr_graduates'),
		get_string('test_user_id_desc', 'local_pr_graduates'),
		'',
		PARAM_INT
	));
	$settings->add(new admin_setting_configtext(
		'local_pr_graduates/test_application_id',
		get_string('test_application_id', 'local_pr_graduates'),
		get_string('test_application_id_desc', 'local_pr_graduates'),
		'',
		PARAM_TEXT
	));
}
