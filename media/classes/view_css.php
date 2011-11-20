<?php
namespace media\classes;

class view_css extends view {

  protected function render_media() {
    header('Content-type: text/css');
    parent::render_media();
  }

}
