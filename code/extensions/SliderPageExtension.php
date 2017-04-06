<?php
class SliderPageExtension extends DataExtension {

  private static $db = [
    'DisplaySlidesOnChildren' => 'Boolean'
  ];

  private static $has_one = [
    'SlidesFrom' => 'Page'
  ];

  private static $many_many = [
    'Slides' => 'SliderSlide'
  ];

  private static $many_many_extraFields = [
    'Slides' =>[
      'SortOrder' => 'Int',
      'Active' => 'Boolean'
    ],
  ];

  public function onBeforeWrite() {
    $from = $this->owner->SlidesFrom();
    if($from->exists()) {
      foreach($from->Slides() as $slide) {
        $this->owner->Slides()->add($slide, ['Active' => true]);
      }
    }

    $this->owner->SlidesFromID = null;
  }

  public function updateCMSFields(FieldList $fields) {
    if($this->owner->ClassName != 'RedirectorPage' && $this->owner->ClassName != 'VirtualPage') {
      $pageIDs = [];

      foreach(SliderSlide::get() as $slide) {
        $pageIDs = array_merge($pageIDs, $slide->Pages()->getIDList());
      }

      $pageIDs = array_unique($pageIDs);
      $pageIDs = array_diff($pageIDs, [$this->owner->ID]);

      $source = [];
      foreach(Page::get()->byIDs($pageIDs) as $page) {
        $source[$page->ID] = $page->MenuTitle;
      }

      $fields->insertBefore(Tab::create('Slider'), 'Share');
      $fields->addFieldsToTab('Root.Slider', [
        DropdownField::create('SlidesFromID', 'Slides übernehmen von', $source)
          ->setRightTitle('Zeigt die Slides der ausgewählten Seite an.')
          ->setEmptyString('(Bitte wählen Sie eine Seite)'),
        DropdownField::create('DisplaySlidesOnChildren', 'Auf Unterseiten anzeigen', [1 => 'Ja', 0 => 'Nein'], 1)
          ->setRightTitle('Zeigt die Slides auch auf den Unterseiten an, sollten diese keine eigenen haben.'),
        GridField::create('Slides', 'Slides', $this->owner->Slides(), $gridConf = GridFieldConfig_RelationEditor::create())
      ]);

      $gridConf->removeComponentsByType('GridFieldAddExistingAutocompleter');
      $gridConf->addComponent(new GridFieldAddExistingSearchButton());
      $gridConf->addComponent(new GridFieldOrderableRows('SortOrder'));

      if(!count($source)) {
        $fields->removeByName('SlidesFromID');
      }
    }
  }
}  