<?php

/**
 * Contact_Config
 * 
 * Contains all settings for contact.
 *
 * @author Allen
 */
class Contact_Config extends DataExtension {
	
	private static $db = array(
		'FromName' => 'Varchar',
		'FromEmail' => 'Varchar',
		'ReplyToName' => 'Varchar',
		'ReplyToEmail' => 'Varchar',
		'SendNotification' => 'Boolean',
		'StoreDatabase' => 'Boolean',
		'ToName' => 'Varchar',
		'ToEmail' => 'Varchar'
	);
	
	private static $has_many = array(
	);
	
	private static $tabs = array(
		'GeneralSettings' => 'General Settings'
	);
 
	public function updateCMSFields(FieldList $fields) {
		
		$config = SiteConfig::current_site_config();
		$domain = substr(substr(Director::absoluteURL('/'), 7), 0, -1);
		
		$AutoResponderTab = null;
		if($AutosResponders = AutoResponder::get()) {
			$gridConfig = GridFieldConfig_RecordEditor::create();
			$AutoResponderGridField = new GridField('AutoResponders', 'AutoResponders', $AutosResponders, $gridConfig);
			$AutoResponderTab = new Tab('AutoResponders', $AutoResponderGridField);
		}
		
		$fields->addFieldToTab('Root',
			new TabSet('Contact',
				// GENERAL SETTINGS
				new Tab('General',
					new LiteralField(
						'HeaderLine1',
						'<h2 style="margin-bottom:0">Autoresponder From Email</h2>When the site sends an email'
					),
					new TextField('FromName', 'From Name<br><span style="font-size:10px"><u>name</u>&nbsp;&lt;email@'.$domain.'&gt;</span>'),
					new TextField('FromEmail', 'From Email<br><span style="font-size:10px">name&nbsp;&lt;&nbsp;<u>email@'.$domain.'</u>&nbsp;&gt;</span>'),
					new LiteralField(
						'HeaderLine2',
						'<h2 style="margin-bottom:0">ReplyTo Email</h2>When the user clicks "reply" to any autoresponer email'
					),
					new TextField('ReplyToName', 'ReplyTo Name<br><span style="font-size:10px"><u>name</u>&nbsp;&lt;email@'.$domain.'&gt;</span>'),
					new TextField('ReplyToEmail', 'ReplyTo Email<br><span style="font-size:10px">name&nbsp;&lt;&nbsp;<u>email@'.$domain.'</u>&nbsp;&gt;</span>'),
					new LiteralField(
						'HeaderLine3',
						'<h2 style="margin-bottom:0">Notify by Email</h2>Email me with submission info, ready for reply'
					),
					new CheckboxField('SendNotification', 'Send Email to Contact below'),
					new TextField('ToName', 'To Name<br><span style="font-size:10px"><u>name</u>&nbsp;&lt;email@'.$domain.'&gt;</span>'),
					new TextField('ToEmail', 'To Email<br><span style="font-size:10px">name&nbsp;&lt;&nbsp;<u>email@'.$domain.'</u>&nbsp;&gt;</span>'),
					new LiteralField(
						'HeaderLine4',
						'<h2 style="margin-bottom:0">Save Submissions to Database</h2>Disable if getting tons of spam'
					),
					new CheckboxField('StoreDatabase', 'Save Submissions')
				),
				// OTHER SETTINGS
				$AutoResponderTab
			),
			'Main'
		);
	}
	
	
	public function getTab($name) {
		$name = static::tab_name_from_title($name);
		$title = static::tab_title_from_name($name);
		if(!array_key_exists($name, static::$tabs)) {
			static::$tabs[$name] = $title;
		}
		
		return $name;
	}
	
	private static function tab_name_from_title($title) {
		return ucfirst(preg_replace("/[^a-zA-Z\s]/", '', $title));
	}
	
	private static function tab_title_from_name($name) {
		$matches = array();
		preg_match_all('/((?:^|[A-Z])[a-z]+)/', $name, $matches);
		if(isset($matches[1]) && !empty($matches[1])) return implode($matches[1]);
		return false;
	}
	
}