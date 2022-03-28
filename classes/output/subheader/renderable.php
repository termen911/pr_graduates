<?php

namespace local_pr_graduates\output\subheader;

use renderer_base;

class renderable implements \renderable, \templatable {

	private string $name;

	public function __construct(string $name) {
		$this->name = $name;
	}

	public function export_for_template(renderer_base $output): array {
		return ['name' => $this->name];
	}
}