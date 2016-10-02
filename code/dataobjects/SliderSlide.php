<?php
class SliderSlide extends DataObject {

  private static $singular_name = 'Slide';
  private static $plural_name = 'Slides';

  private static $db = [
    'Title' => 'Varchar(255)',
    'Content' => 'Text',
    'Link' => 'NamedLinkField',
    'ShowTitle' => 'Boolean'
  ];

  private static $has_one = [
    'Image' => 'Image'
  ];

  private static $belongs_to = [];
  private static $has_many = [];
  private static $many_many = [];
  private static $belongs_many_many = [
    'Pages' => 'Page'
  ];

  // private static $many_many_extraFields = [
    // 'RelationName' => ['FieldName' => 'FieldType']
  // ];

  // private static $searchable_fields = [];
  private static $summary_fields = [
    'Image.CMSThumbnail' => 'Vorschau',
    'Title' => 'Titel',
    'NiceActive' => 'Aktiv'
  ];

  // private static $default_sort = 'Title';

  private static $defaults = [];

  public function populateDefaults() {
    parent::populateDefaults();
  }

  public function onBeforeWrite() {
    parent::onBeforeWrite();
  }

  public function onAfterWrite() {
    parent::onAfterWrite();
  }

  public function onBeforeDelete() {
    parent::onBeforeDelete();
  }

  public function onAfterDelete() {
    parent::onAfterDelete();
  }

  /*
  public function canCreate($member = null) {
    $can = Permission::check(['ADMIN', 'CMSACCESSLeftAndMain', 'SITETREEEDITALL']);
    return $can;
  }

  public function canEdit($member = null) {
    $can = Permission::check(['ADMIN', 'CMSACCESSLeftAndMain', 'SITETREEEDITALL']);
    return $can;
  }

  public function canDelete($member = null) {
    $can = Permission::check(['ADMIN', 'CMSACCESSLeftAndMain', 'SITETREEEDITALL']);
    return $can;
  }

  public function canView($member = null) {
    $can = Permission::check(['ADMIN', 'CMSACCESSLeftAndMain', 'SITETREEVIEWALL']);
    return $can;
  }
  */

  public function getCMSValidator() {
    // $requiredFields = parent::getCMSValidator();
    // $requiredFields->addRequiredField('FieldName');
    $requiredFields = RequiredFields::create('Title', 'Image');
    return $requiredFields;
  }

  /*
  public function validate() {
    $result = parent::validate();
    if($this->Value == 'Key') {
      $result->error('Custom Error Message');
    }
    return $result;
  }
  */

  public function getCMSFields() {
    // $fields = parent::getCMSFields();
    // $fields->addFieldsToTab('Root.Main', []);
    
    $fields = FieldList::create(
      TabSet::create('Root',
        Tab::create('Main', 'Hauptteil',
          DropdownField::create('ManyMany[Active]', 'Aktiv', [1 => 'Ja', 0 => 'Nein'], 1),
          TextField::create('Title', 'Titel'),
          DropdownField::create('ShowTitle', 'Titel ausgeben', [1 => 'Ja', 0 => 'Nein'], 1),
          TextareaField::create('Content', 'Beschreibung'),
          NamedLinkFormField::create('Link', 'Link'),
          UploadField::create('Image', 'Bild')
            ->setFolderName('slider')
            ->setDisplayFolderName('slider')
        )
      )
    );

    if($this->Pages()->count() > 1) {
      $fields->insertBefore(LiteralField::create(
        'MultiplePagesNotice',
        '<div class="message warning">
          <strong>Achtung dieser Slide wird auf mehreren Seiten verwendet!</strong><br>
          Änderungen an diesem Slide werden daher auf allen anderen Seiten ebenso angewandt. (Außer "Aktiv")
        </div>'
      ), '');
    };
    
    $this->extend('updateCMSFields', $fields);

    return $fields;
  }

  public function NiceActive() {
    if($this->Active) {
      return 'Ja';
    } else {
      return 'Nein';
    }
  }
}