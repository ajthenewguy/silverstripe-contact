<?php

/**
 * Description of Contact_Admin
 *
 * @author Allen
 */
class Contact_Admin extends ModelAdmin {

	private static $menu_title = 'Form Submissions';
	
	private static $url_segment = 'submissions';

	private static $managed_models = array(
		'Contact_Submission',
		'Contact_FormInstance'
	);
	
	
	// EDIT FORM
	public function getEditForm($id = null, $fields = null) {
		$form = parent::getEditForm($id, $fields);
		$gridField = $form->Fields()->fieldByName($this->sanitiseClassName($this->modelClass));
		$gridField->getConfig()->addComponent(new GridFieldFilterHeader());
		return $form;
	}

	
	
	// IMPORT/EXPORT
	public function getExportFields() {
		return array(
			'Name' => 'Name',
			'ProductCode' => 'Product Code',
			'Category.Title' => 'Category'
		);
	}
}