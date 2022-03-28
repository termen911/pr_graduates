<?php

require_once(__DIR__ . '/../../config.php');
global $PAGE, $OUTPUT, $DB, $CFG;

defined('MOODLE_INTERNAL') || die();

//TODO сделать проверку прав

$context = context_system::instance();
$PAGE->set_context($context);

$consent = required_param('consent', PARAM_INT);

echo $OUTPUT->header();
echo $consent;
echo $OUTPUT->footer();