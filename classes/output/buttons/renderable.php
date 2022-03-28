<?php

namespace local_pr_graduates\output\buttons;

use renderer_base;

class renderable implements \renderable, \templatable {

	private string $name;
	private int $consent;

	public function __construct(string $name, int $consent) {
		$this->name = $name;
		$this->consent = $consent;
	}

	public function export_for_template(renderer_base $output): array {
		return ['name' => $this->name, 'consent' => $this->consent];
	}
}