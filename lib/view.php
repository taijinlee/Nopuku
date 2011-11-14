<?php
namespace lib;

class view {

  private $variables;
  protected $twig_environment;

  public function __construct($tier) {
    // get Twig loader
    $template_paths = array($_SERVER['NP_ROOT'] . "/templates/$tier", $_SERVER['NP_ROOT'] . '/templates');
    $loader = new \Twig_Loader_Filesystem($template_paths);

    // get Twig Environment based on loader
    $this->twig_environment = new \Twig_Environment($loader, self::get_options());
    $this->variables = array();
  }

  protected function set($key, $value) {
    $this->variables[$key] = $value;
  }

  protected function render($template, $return = false) {
    $this->set('constants', get_class_vars('\lib\conf\constants'));
    $rendered = $this->twig_environment->render($template, $this->variables);
    if ($return) {
      return $rendered;
    } else {
      echo $rendered;
    }
  }



  private static function get_options() {
    $options = array('cache' => false, 'debug' => false, 'strict_variables' => true);

    if (\lib\conf\constants::$twig_cache_on) {
      $options['cache'] = $_SERVER['NP_ROOT'] . '/cache/twig/';
    }
    if (\lib\conf\constants::$twig_debug_on) {
      $options['debug'] = true;
    }

    return $options;
  }

}
