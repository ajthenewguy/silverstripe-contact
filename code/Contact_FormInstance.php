<?php

/**
 * Description of Contact_FormInstance
 *
 * @author Allen
 */
class Contact_FormInstance extends DataObject {
	
	private static $db = array();
	
	private static $form_class = 'Contact_Form';
	
	private static $has_many = array(
		'Submissions' => 'Contact_Submission'
	);
	
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		return $fields;
	}
	
	
	/**
	 * Get a (customized?) Form
	 */
	public function Form($controller) {
		$FormClass = static::$form_class;
		if(!isset($this->Form)) $this->Form = new $FormClass($controller, $name = $FormClass);
		return $this->Form;
	}
	
	
	/**
	 * Get Submission Class
	 */
	public function Submission() {
		if(!isset($this->Submission)) $this->Submission = new static::$save_into();
		return $this->Submission;
	}
}

?>
