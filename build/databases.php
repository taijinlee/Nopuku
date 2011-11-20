<?php
namespace build;

class databases extends build {

  public static function get_databases($is_prod) {
    $databases = array();

    if ($is_prod) {
      $databases['main'] = array('host' => 'localhost', 'user' => 'nopuku', 'password' => 'nopuku');
      $databases['unit_test'] = array('host' => 'localhost', 'user' => 'nopuku', 'password' => 'nopuku');
    } else {
      $databases['main'] = array('host' => 'localhost', 'user' => 'nopuku', 'password' => 'nopuku');
      $databases['unit_test'] = array('host' => 'localhost', 'user' => 'nopuku', 'password' => 'nopuku');
    }
    return $databases;
  }

  protected static function _build($is_prod) {
    foreach (self::get_databases($is_prod) as $key => $value) {
      self::add_param($key, $value);
    }
  }

}
