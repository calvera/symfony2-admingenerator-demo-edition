<?php

namespace Admingenerator\DoctrineOrmDemoBundle\Exception;

class InvalidForm extends \Admingenerator\GeneratorBundle\Exception\ValidationException {
	public function __construct($form) {
		parent::__construct();

		$this->form = $form;
	}

	public function getForm() {
		return $this->form;
	}
}
