<?php

namespace local_pr_graduates\output\buttons;

use plugin_renderer_base;
use local_pr_graduates\output\buttons\renderable as element;

class renderer extends plugin_renderer_base {
	/**
	 * @param element $element
	 * @return string
	 */
	public function render_renderable(element $element): string {
		try {
			return $this->render_from_template(
				'local_pr_graduates/components/buttons',
				$element->export_for_template($this)
			);
		} catch (\moodle_exception $e) {
			return "<p style='color: red;'>{$e->getMessage()}</p>";
		}
	}
}