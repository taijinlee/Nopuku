<?php
namespace lib;

class log {

  private static $stop_enabled = true;

  public static function error($message) {
    trigger_error(print_r($message, true), E_USER_ERROR);
  }

  public static function debug($message) {
    trigger_error(print_r($message, true), E_USER_NOTICE);
  }

  public static function warning($message) {
    trigger_error(print_r($message, true), E_USER_WARNING);
  }

  public static function error_handler($errno, $errstr, $errfile, $errline) {
    $stop = false;
    switch ($errno) {
      case E_USER_NOTICE:
        $errors = "DEBUG";
        break;
      case E_NOTICE:
        $errors = "NOTICE";
        break;
      case E_WARNING:
      case E_USER_WARNING:
        $errors = "WARNING";
        break;
      case E_ERROR:
      case E_USER_ERROR:
        $errors = "FATAL";
        $stop = true;
        break;
      default:
        $errors = "UNKNOWN";
        break;
    }

    /*
    if (ini_get("display_errors")) {
      printf ("<br />\n<b>%s</b>: %s in <b>%s</b> on line <b>%d</b><br /><br />\n", $errors, $errstr, $errfile, $errline);
    }
    */
    $bt = self::form_compact_backtrace();
    error_log(sprintf("[%s] %s in $bt", $errors, $errstr));

    if ($stop && self::$stop_enabled) {
      die;
    }
    return true;
  }

  /**
   * Allows log error to continue execution
   */
  public static function enable_debug_mode() {
    self::$stop_enabled = false;
  }


  private static function form_compact_backtrace($depth = 0) {
    $backtrace = debug_backtrace();
    
    $printable_backtrace_array = array();
    reset($backtrace);
    while ($call = current($backtrace)) {
      // remove log.php and function error_handler backtrace items
      if (empty($call['file']) || strstr($call['file'], '/lib/log.php')) {
        next($backtrace);
        continue;
      }

      
      $call['file'] = strstr($call['file'], $_SERVER['NP_ROOT']);
      $printable_backtrace_array[] = $call['file'] . ':' . $call['line'];
      next($backtrace);
    }

    if ($depth) {
      $printable_backtrace_array = array_slice($printable_backtrace_array, 0, $depth);
    }

    return implode(' -> ', $printable_backtrace_array);
  }

}
