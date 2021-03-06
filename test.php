<?php
use FormManager\Form;
use FormManager\Input;

include('FormManager/autoloader.php');

class MyForm extends Form {
	public function __construct () {
		$this->attr('action', 'test.php');

		$this->setInputContainer("<p>%s</p> \n");

		$this->inputs(array(
			'name' => Input::text()->maxlength(50)->required()->label('Your name'),
			'dni' => Input::text()->pattern('[\d]{8}[\w]')->label('DNI'),
			'search' => Input::search()->label('What are you looking for?'),
			'comment' => Input::textarea()->label('A comment')->maxlength(30)->sanitize(function ($value) {
				return strip_tags($value);
			}),
			'email' => Input::email()->label('Your email'),
			'website' => Input::url()->label('Your website')->required(),
			'age' => Input::number()->min(5)->max(110)->label('How old are you?'),
			'height' => Input::range()->min(50)->max(220)->label('How height are you?'),
			'telephone' => Input::tel()->label('Telephone number'),
			'is-happy' => Input::checkbox()->label('Are you happy?')->setInputContainer('<hr>%s<hr>')

		), 'first-group');

		$this->inputs(array(
			'gender' => Input::select()->options(array(
				'm' => 'Male',
				'f' => 'Female'
			))->label('Gender'),
			'color' => Input::Choose([
				'red' => Input::radio()->label('Red'),
				'green' => Input::radio()->label('Green'),
				'blue' => Input::radio()->label('Blue')
			])->setInputContainer('%s'),
			'action' => Input::Choose([
				'update' => Input::button()->type('submit')->html('Update data'),
				'duplicate' => Input::button()->type('submit')->html('Duplicate element')
			])
			//or also: 'submit' => Input::submit()->val('Send data') 
		), 'second-group');
	}
}

$Form = new MyForm;

if ($_GET) {
	$Form->load($_GET, $_POST, $_FILES);

	if ($Form->isValid()) {
		print_r($Form->val());
	} else {
		echo 'There was an error';
	}
}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		
		<title>Form manager tests</title>
		<style type="text/css">
			body {
				font-family: sans-serif;
			}
		</style>
	</head>

	<body>
		<?php echo $Form->openHtml(); ?>
		<fieldset>
			<legend>First group</legend>
			<?php echo $Form->inputsHtml('first-group'); ?>
		</fieldset>

		<fieldset>
			<legend>Second group</legend>
			<?php echo $Form->inputsHtml('second-group'); ?>
		</fieldset>
		<?php echo $Form->closeHtml(); ?>
	</body>
</html>
