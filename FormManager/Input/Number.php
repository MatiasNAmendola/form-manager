<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Number extends Input implements InputInterface {
	public static $error_message = 'This value is not a valid number';
	protected $attributes = array('type' => 'number');

	public function validate () {
		$value = $this->val();

		if (!empty($value) && !filter_var($value, FILTER_VALIDATE_FLOAT)) {
			$this->error(static::$error_message);
			return false;
		}

		return parent::validate();
	}
}
