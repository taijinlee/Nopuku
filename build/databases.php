<?php
namespace build;

class databases extends build {

  public static function get_databases($is_prod) {
    if ($is_prod) {
      /* $databases['wine']       = array('host' => 'localhost', 'user' => 'nopuku', 'password' => 'nopuku'); */
      /* $databases['logs']       = array('host' => 'localhost', 'user' => 'nopuku', 'password' => 'nopuku'); */
      /* $databases['sessions']   = array('host' => 'localhost', 'user' => 'nopuku', 'password' => 'nopuku'); */
    } else {
      $databases['wine']         = array('host' => 'localhost', 'user' => 'root', 'password' => '');
      /* $databases['logs']       = array('host' => 'localhost', 'user' => 'nopuku', 'password' => 'nopuku'); */
      /* $databases['sessions']   = array('host' => 'localhost', 'user' => 'nopuku', 'password' => 'nopuku'); */
    }
    return $databases;
  }

  protected static function _build($is_prod) {
    foreach (self::get_databases($is_prod) as $key => $value) {
      self::add_param($key, $value);
    }
  }

}
