<?php

use local_pr_graduates\external\chat;
use local_pr_graduates\external\consent;

defined('MOODLE_INTERNAL') || die();

$functions = [
	'local_pr_graduate_consent' => [
		'classname' => consent::class,
		'methodname' => 'change',
		'description' => '',
		'type' => 'read',
		'ajax' => true,
		'loginrequired' => true,
	],
	'local_pr_graduate_chat_get_messages' => [
		'classname' => chat::class,
		'methodname' => 'get_messages',
		'description' => '',
		'type' => 'read',
		'ajax' => true,
		'loginrequired' => true,
	],
	'local_pr_graduate_chat_send_message' => [
		'classname' => chat::class,
		'methodname' => 'send_message',
		'description' => '',
		'type' => 'read',
		'ajax' => true,
		'loginrequired' => true,
	]
];
