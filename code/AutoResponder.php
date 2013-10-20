<?php
/**
 * Description of AutoResponder
 *
 * @author Allen
 */
class AutoResponder extends DataObject {
	
	private static $db = array(
		'Status' => "Enum('Active,Inactive','Active')",
		'From' => 'Varchar',
		'To' => 'Varchar',
		'Subject' => 'Varchar',
		'Body' => 'HTMLText'
	);
	
	private static $belongs_many_many = array(
		'Pages' => 'Page'
	);
	
	
	private static $summary_fields = array(
		'Status',
		'Subject',
		'Body'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$ToOptions = array('User' => 'Goes to User');
		$Config = SiteConfig::current_site_config();
		
		if($Config->ToEmail) {
			$ToOptions['Admin'] = 'Goes to '.($Config->ToName ? $Config->ToName.' <'.$Config->ToEmail.'>' : $Config->ToEmail);
		}
		
		$FromOptions = array();
		if($Config->FromEmail) {
			$email = ($Config->FromName ? $Config->FromName.' <'.$Config->FromEmail.'>' : $Config->FromEmail);
			$FromOptions[$email] = $email;
		}
		if($Config->ToEmail) {
			$email = ($Config->ToName ? $Config->ToName.' <'.$Config->ToEmail.'>' : $Config->ToEmail);
			$FromOptions[$email] = $email;
		}
		if($Config->ReplyToEmail) {
			$email = ($Config->ReplyToName ? $Config->ReplyToName.' <'.$Config->ReplyToEmail.'>' : $Config->ReplyToEmail);
			$FromOptions[$email] = $email;
		}
		
		$fields->addFieldToTab('Root.Main', new DropdownField('To', 'Send To', $ToOptions));
		$fields->addFieldToTab('Root.Main', new DropdownField('From', 'Email From', $FromOptions));
		$fields->addFieldToTab('Root.Main', new TextField('Subject', 'Subject'));
		$fields->addFieldToTab('Root.Main', new HtmlEditorField('Body', 'Body'));
		$fields->addFieldToTab('Root.Main', new DropdownField(
			'Status',
			'Status',
			singleton('AutoResponder')->dbObject('Status')->enumValues())
		);
		
		return $fields;
	}
}

?>
