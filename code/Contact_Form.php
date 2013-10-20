<?php

/**
 * Description of Contact_Form
 *
 * @author Allen
 */
class Contact_Form extends Form {
	
	public static $secure = false;

	private static $save_into = 'Contact_Submission';
	
	
	public function __construct($controller, $name, $fields = null, $actions = null, $validation = null) {
		$Submission = $this->Submission();
		
		if(null === $fields) {
			// DEFAULT FIELDS
			$fields = $Submission->getCMSFields();
		}
				
		if(null !== $actions) {
			// DEFAULT ACTION
			$actions = $Submission->getActionFields();
		}
		
		if(null === $validation) {
			// DEFAULT REQUIRED FIELDS
			$validation = $Submission->getValidationFields();
		} else {
			// CUSTOM REQUIRED FIELDS
			if(!$validation instanceof RequiredFields) {
				if(is_array($validation)) {
					$validation = new RequiredFields();
					foreach($validation as $required) {
						$validation->addRequiredField($required);
					}
				} else {
					throw new InvalidArgumentException('Fifth parameter must be array of field names or instace of RequiredFields.');
				}
			}
		}
		
		parent::__construct($controller, $name, $fields, $actions, $validation);
	}
	
	public function Submission() {
		if(!isset($this->Submission)) $this->Submission = new static::$save_into();
		return $this->Submission;
	}
	
	public function submit(array $data, Form $form) {
		
		if(!filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
			$form->sessionMessage("Invalid email address!", 'bad');
			return $this->redirectBack();
		}
		
		$Submission = $this->Submission();
        $form->saveInto($Submission);
        $Submission->write();
        return Controller::curr()->redirectBack();
	}
	
	public function forTemplate() {
		return $this->renderWith(array($this->class, 'Form'));
	}
	
	public function httpError($code, $message = null) {
		$response = ErrorPage::response_for($code);
		if (empty($response)) $response = $message;
		throw new SS_HTTPResponse_Exception($response);
	}
}

?>
