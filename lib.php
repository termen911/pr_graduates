<?php

/**
 * @param global_navigation $nav
 * @return void
 * @throws coding_exception
 */
function local_pr_graduates_extend_navigation(global_navigation $nav): void {

	//TODO добавить проверку прав для выпускника
	if (get_config('local_pr_graduates', 'enable_test_mode') && !is_siteadmin()) {
		return;
	}

	if (get_config('local_pr_graduates', 'check_permission')) {
		$eval_string =
			preg_replace('/([^{,:])"(?![},:])/', "$1" . '\'' . "$2", get_config('local_pr_graduates', 'check_permission'));
		if (strpos($eval_string, 'return') !== false) {
			return;
		}
	}

	$node = navigation_node::create(
		get_string('link_name', 'local_pr_graduates'),
		new moodle_url('/local/pr_graduates/index.php'),
		navigation_node::TYPE_CONTAINER,
		get_string('link_short_name', 'local_pr_graduates'),
		'graduates',
		new pix_icon('i/graduates', 'test', 'local_pr_graduates')
	);

	$node->showinflatnavigation = true;
	$nav->add_node($node, 'mycourses');
}

/**
 * @return string[]
 */
function local_pr_graduates_get_fontawesome_icon_map(): array {
	return [
		'local_pr_graduates:i/graduates' => 'fa-graduation-cap',
		'local_pr_graduates:i/send' => 'fa-paper-plane',
		'local_pr_graduates:i/remove' => 'fa-times',
	];
}