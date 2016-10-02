<?php
class SliderPageControllerExtension extends DataExtension {
  
  private static $allowed_actions = [
  ];

  public function onBeforeInit() {
    global $moduleSlider;
    // - Requirements Management CSS Files
    $moduleCSSFiles = Session::get('SFModuleCSSFiles');

    if(!$moduleCSSFiles) {
      $moduleCSSFiles = [];
    }

    $requiredCSSFiles = array_flip([
      $moduleSlider . '/css/slider.css',
    ]);

    $requiredCSSFiles = array_merge($moduleCSSFiles, $requiredCSSFiles);

    Session::set('SFModuleCSSFiles', $requiredCSSFiles);

    // - Requirements Management JS Files
    $moduleJSFiles = Session::get('SFModuleJSFiles');

    if(!$moduleJSFiles) {
      $moduleJSFiles = [];
    }

    $requiredJSFiles = array_flip([
      'bxslider.js',
      $moduleSlider . '/js/slider.js',
    ]);

    $requiredJSFiles = array_merge($moduleJSFiles, $requiredJSFiles);

    Session::set('SFModuleJSFiles', $requiredJSFiles);
  }

  public function ActiveSlides() {
    $slides = $this->owner->Slides();
    $parent = $this->owner->Parent();

    if(!$slides->first() && $parent && $this->owner->DisplaySlidesOnChildren) {
      $slides = $parent->Slides();
    }

    return $slides->filter('Active', true)->sort('SortOrder');
  }
}
