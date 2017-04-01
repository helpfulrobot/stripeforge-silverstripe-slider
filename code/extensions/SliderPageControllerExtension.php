<?php
class SliderPageControllerExtension extends DataExtension {

  public function onAfterInit() {
    global $moduleSlider;

    Requirements::css($moduleSlider . '/css/slider.css');
    Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
    Requirements::javascript($moduleSlider . '/js/jquery.bxslider.js');
    Requirements::javascript($moduleSlider . '/js/slider.js');
  }

  public function ActiveSlides() {
    $slides = $this->owner->Slides();
    $parent = $this->owner->Parent();

    if(!$slides->first() && $parent && $parent->DisplaySlidesOnChildren) {
      $slides = $parent->Slides();
    }

    return $slides->filter('Active', true)->sort('SortOrder');
  }
}
