<?php

/**
 * Description of Contact_Submission
 *
 * @author Allen
 */
class Contact_Submission extends DataObject {
	
	private static $db = array(
		'Status' => "Enum('New,Read,Replied,Archived','New')",
		'FirstName' => 'Varchar',
		'LastName' => 'Varchar',
		'Email' => 'Varchar',
		'Message' => 'Text',
		'Date' => 'SS_Datetime'
	);
	
	private static $has_one = array(
		//'Form' => 'Contact_Form',
		'Page' => 'SiteTree'
	);
	
	private static $has_many = array();
	
	private static $defaults = array(
	);
	
	private static $searchable_fields = array(
		'FirstName',
		'LastName',
		'Email'
	);
	
	private static $field_labels = array(
	);
	
	private static $summary_fields = array(
	);
	
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->removeByName('SortOrder');
		$fields->removeByName('PageID');
		
		// Date
		if($this->Date) {
			$fields->addFieldToTab('Root.Main', new LiteralField('Date', 
				'<div id="Date" class="field text">
					<label class="left">Date</label>
					<div class="middleColumn">'.$this->getFriendlyDateLong().'</div>
				</div>'
			));
		}
		
		// Status
		$Status = new DropdownField('Status', 'Status', singleton($this->ClassName)->dbObject('Status')->enumValues());
		if($this->Status && $this->Status == 'New') {
			if(Controller::curr()->getRequest()->httpMethod() !== 'POST') {
				$this->Status = 'Read';
				$this->write();
			}
		}
		$fields->addFieldToTab('Root.Main', $Status);
		
		// FirstName
		$FirstName = new TextField('FirstName', 'First Name');
		if( ! empty($this->FirstName)) $FirstName->setDisabled(true);
		$fields->addFieldToTab('Root.Main', $FirstName);
		
		// LastName
		$LastName = new TextField('LastName', 'Last Name');
		if( ! empty($this->LastName)) $LastName->setDisabled(true);
		$fields->addFieldToTab('Root.Main', $LastName);
		
		// Email
		$Email = new TextField('Email', 'Email');
		if( ! empty($this->Email)) $Email->setDisabled(true);
		$fields->addFieldToTab('Root.Main', $Email);
		
		// Message
		$Message = new TextareaField('Message', 'Message');
		if( ! empty($this->Message)) $Message->setDisabled(true);
		$fields->addFieldToTab('Root.Main', $Message);
		
		return $fields;
	}
	
	public function getFriendlyDate() {
		if($this->Date) {
			$Date = $this->dbObject('Date');
			$date = $Date->NiceUS();
			if($Date->isToday()) {
				$date = $Date->format('g:i a');
			} else {
				$date = $Date->format('M j');
			}
			
			return $date;
		}
	}
	
	public function getFriendlyDateLong() {
		if($this->Date) {
			$Date = $this->dbObject('Date');
			$date = $Date->NiceUS();
			if($Date->isToday()) {
				$date = $Date->format('g:i a').' ('.$Date->TimeDiff(false).' ago)';
			} else {
				$date = $Date->format('M j').' ('.$Date->TimeDiff(false).' ago)';
			}
			
			return $date;
		}
	}
	
	public function getActionFields() {
		return new FieldList(
			FormAction::create("submit")->setTitle("Submit")
		);
	}
	
	public function getValidationFields() {
		return new RequiredFields( // validation
			'Email', 'FirstName'
		);
	}
	
	
	public function Title() {
		return $this->Name();
	}
	
	public function Name() {
		return $this->FirstName.' '.$this->LastName;
	}
	
	public function DisplayNice() {
		return $this->Display ? 'Yes' : 'No';
	}
	
	
	// PERMISSIONS
	public function canView($member = null) {
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
	}
	public function canEdit($member = null) {
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
	}
	public function canDelete($member = null) {
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }
	public function canCreate($member = null) {
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
	}
}

?>
