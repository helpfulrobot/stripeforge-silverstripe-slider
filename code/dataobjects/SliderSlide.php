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

  private static $belongs_many_many = [
    'Pages' => 'Page'
  ];

  private static $summary_fields = [
    'Image.CMSThumbnail' => 'Vorschau',
    'Title' => 'Titel',
    'NiceActive' => 'Aktiv'
  ];

  public function getCMSValidator() {
    $requiredFields = RequiredFields::create('Title', 'Image');
    return $requiredFields;
  }

  public function getCMSFields() {
    $fields = FieldList::create(
      TabSet::create('Root',
        Tab::create('Main', 'Hauptteil',
          CheckboxSetField::create('ManyMany[Active]', 'Aktiv', [1 => 'Ja'], 1),
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