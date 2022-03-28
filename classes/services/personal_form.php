<?php

namespace local_pr_graduates\services;

use coding_exception;
use local_pr_graduates\output\buttons\renderable as buttons_renderable;
use moodle_exception;
use moodleform;
use MoodleQuickForm;

class personal_form extends moodleform {

	use base_form;

	private MoodleQuickForm $form;
	private string $consent_message = '';
	private int $consent;
	private array $fields_edit;
	private object $data;

	public function __construct(object $data, array $fields_edit) {
		$this->data = $data;
		$this->fields_edit = $fields_edit;
		parent::__construct();
	}

	/**
	 * @return void;
	 * @throws coding_exception
	 * @throws moodle_exception
	 */
	protected function definition(): void {

		$this->form = $this->_form;
		$this->form->addElement('header', 'graduate_header', tools::get_localization('second_tab'));
		$this->build_hidden(optional_param('tab', 1, PARAM_INT), 'tab');

		$publication_consent = false;

		foreach ($this->data as $key => $item) {

			if ($key === 'publication_consent') {
				$publication_consent = $item;
				continue;
			}

			[$type, $name, $attributes] = $this->build_element_params($key);

			if ($type === 'textarea') {
				$this->build_textarea($item, $key, $name, $attributes);
			}
			if ($type === 'checkbox') {
				$this->build_checkbox($item, $key, $name, $attributes);
			}

			if ($type === 'number') {
				$this->build_number($item, $key, $name, $attributes);
			}

			if ($type === 'text') {
				$this->build_text($item, $key, $name, $attributes);
			}
		}
		$this->getConsentInformation($publication_consent);
		$this->add_buttons();
	}

	/**
	 * @throws coding_exception
	 */
	protected function add_buttons(): void {
		global $PAGE;
		$buttons_renderer = $PAGE->get_renderer('local_pr_graduates', 'buttons');
		$this->form->addElement('html', $buttons_renderer->render(new buttons_renderable($this->consent_message, $this->consent)));
	}

	/**
	 * @param string $key
	 * @return array
	 */
	private function build_element_params(string $key): array {

		$readonly = true;
		$type = 'text';
		$length = 150;

		$name = tools::get_localization($key);

		if ($name === "[[$key]]") {
			$name = $key;
		}

		if (array_key_exists($key, $this->fields_edit)) {
			$readonly = false;

			$length = (int) $this->fields_edit[$key]->length;

			if ($length === 0) {
				$length = 150;
			}

			if ($length > 150 && mb_strtolower((string) $this->fields_edit[$key]->type) === 'string') {
				$type = 'textarea';
			}

			if (mb_strtolower((string) $this->fields_edit[$key]->type) === 'boolean') {
				$type = 'checkbox';
			}

			if (mb_strtolower((string) $this->fields_edit[$key]->type) === 'integet') {
				$type = 'number';
			}

		}

		$attributes = [
			'maxlength' => $length,
			'style' => 'width: 100%'
		];

		!$readonly || $attributes['readonly'] = true;

		if ($type === 'checkbox') {
			$attributes = [];
			!$readonly || $attributes['disabled'] = 'disabled';
		}

		return [$type, $name, $attributes];
	}

	/**
	 * @param bool $publication_consent
	 * @return void
	 */
	private function getConsentInformation(bool $publication_consent): void {
		if ($publication_consent) {
			$this->consent_message = 'Отозвать согласие на обработку персональных данных';
			$this->consent = 0;
			return;
		}
		$this->consent_message = 'Дать согласие на обработку персональных данных';
		$this->consent = 1;
	}

}