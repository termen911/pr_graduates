<?php

namespace local_pr_graduates\services;

use coding_exception;
use local_pr_graduates\output\subheader\renderable as subheader_renderable;

trait base_form {

	/**
	 * @param string $subheader
	 * @throws coding_exception
	 */
	protected function add_subheader(string $subheader): void {
		global $PAGE;
		$subheader_renderer = $PAGE->get_renderer('local_pr_graduates', 'subheader');
		$this->form->addElement('html', $subheader_renderer->render(new subheader_renderable($subheader)));
	}

	/**
	 * @param $item
	 * @param $key
	 * @param $name
	 * @param $attributes
	 */
	protected function build_text($item, $key, $name, $attributes): void {
		if ($item === false && $attributes['readonly']) {
			$item = "Нет";
		}
		if ($item === true && $attributes['readonly']) {
			$item = "Да";
		}
		$this->form->addElement('text', $key, $name, $attributes);
		$this->form->setType($key, PARAM_TEXT);
		$this->form->setDefault($key, $item);
	}

	/**
	 * @param $item
	 * @param $key
	 * @param $name
	 * @param $attributes
	 */
	protected function build_textarea($item, $key, $name, $attributes): void {
		$attributes["wrap"] = 'virtual';
		$attributes["rows"] = 10;
		$attributes["cols"] = 20;

		$this->form->addElement('textarea', $key, $name, $attributes);
		$this->form->setDefault($key, $item);
	}

	/**
	 * @param $item
	 * @param $key
	 * @param $name
	 * @param $attributes
	 */
	protected function build_checkbox($item, $key, $name, $attributes): void {
		$this->form->addElement('checkbox', $key, $name, '', $attributes);
		$this->form->setDefault($key, $item);
	}

	/**
	 * @param $item
	 * @param $key
	 * @param $name
	 * @param $attributes
	 */
	protected function build_number($item, $key, $name, $attributes): void {
		$this->form->addElement('float', $key, $name, $attributes);
		$this->form->setDefault($key, $item);
	}

	/**
	 * @param $item
	 * @param $key
	 */
	protected function build_hidden($item, $key): void {
		$this->form->addElement('hidden', $key, $item);
		$this->form->setType($key, PARAM_RAW);
	}
}