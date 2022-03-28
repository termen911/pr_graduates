<?php

namespace local_pr_graduates\services;

global $CFG;
require_once("{$CFG->libdir}/formslib.php");

use coding_exception;
use local_pr_graduates\output\subheader\renderable as subheader_renderable;
use moodleform;
use MoodleQuickForm;
use \local_pr_graduates\services\tools;

class graduate_form extends moodleform {

	use base_form;

	/**
	 * @var MoodleQuickForm
	 */
	private MoodleQuickForm $form;

	/**
	 * @var array
	 */
	private array $education_data;

	public function __construct(array $education_data) {
		$this->education_data = $education_data;
		parent::__construct();
	}

	/**
	 * @return void;
	 * @throws coding_exception
	 */
	protected function definition(): void {

		$this->form = $this->_form;
		$this->form->addElement('header', 'graduate_header', tools::get_localization('first_tab'));

		$step = 0;
		foreach ($this->education_data as $object) {
			$this->add_subheader('Информация о выпуске');
			foreach ($object as $key => $item) {
				$attributes = [
					'readonly' => true,
					'style' => 'width: 100%'
				];
				$element_name = "{$key}_{$step}";
				$this->form->addElement('text', $element_name, tools::get_localization($key), $attributes);
				$this->form->setType($element_name, PARAM_TEXT);
				$this->form->setDefault($element_name, $item);
			}
			$step++;
		}
	}
}