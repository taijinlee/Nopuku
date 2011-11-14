<?php
namespace user;

include_once $_SERVER['NP_ROOT'] . '/user/init.php';
$GLOBALS['login_manager']->login_not_required();

class page extends classes\view {
  
  public function run() {

    if ($GLOBALS['login_manager']->is_logged_in()) {
      \lib\redirect::full(\lib\conf\constants::$domain . '/wines/');
    }

    $this->set('login_url', $GLOBALS['login_manager']->get_facebook_login_url());
    $this->render('user/homepage.twig');
  }

}

$page = new page();
$page->run();
