<?php

class Cache_FS {
  private $_cache_dir;

  public function __construct($cache_dir) {
    $this->_cache_dir = $cache_dir;
  }

  public function get($key) {
    if (file_exists($path = $this->_cache_dir . '/' . $key))
      return file_get_contents($path);
    else
      return false;
  }

  public function set($key, $content) {
    file_put_contents($this->_cache_dir . '/' . $key, $content);
  }
}
