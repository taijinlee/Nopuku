<?php

include_once $_SERVER['NP_ROOT'] . '/lib/init-cli.php';

class databaseTest extends PHPUnit_Framework_TestCase {

  public static function setupBeforeClass() {
    exec('php ' . $_SERVER['NP_ROOT'] . '/build/build.php');
    \lib\log::enable_debug_mode();
  }

  public static function tearDownAfterClass() {
    $wine = new \lib\database('wine');
    $wine->query('TRUNCATE database_unit_test');
    exec('php ' . $_SERVER['NP_ROOT'] . '/build/build.php');
  }

  public function testConnect() {
    foreach (get_class_vars('\\lib\\conf\\databases') as $database_name => $database_credentials) {
      $database = new \lib\database($database_name);
      if ($database_name == 'unit_test_bad_database') {
        $this->assertEquals(is_resource($database->conn()), false);
      } else {
        $this->assertEquals(is_resource($database->conn()), true);
      }
    }
  }

  public function testQuery() {
    $data = array(
      'id' => 5,
      'varchar' => 'osi4uei%($(!}{N: }s0',
      'int' => -345,
      'unsigned_int' => 88847392,
      'blob' => '!@#$%^&*()_+{}-=[]\;\':"./,<>?)',
      'datetime' => 'NOW()'
    );

    $wine = new \lib\database('wine');
    $wine->query('TRUNCATE database_unit_test');
    $sql = 'INSERT INTO database_unit_test (`id`, `varchar`, `int`, `unsigned_int`, `blob`, `datetime`) VALUES (%d, %s, %d, %d, %s, %S)';

    \lib\database::enable_log();
    ob_start();
    $wine->query($sql, $data);
    $output = ob_get_contents();
    ob_end_clean();

    $expected = "INSERT INTO database_unit_test (`id`, `varchar`, `int`, `unsigned_int`, `blob`, `datetime`) VALUES (5, 'osi4uei%($(!}{N: }s0', -345, 88847392, '!@#$%^&*()_+{}-=[]\\\;\\':\\\"./,<>?)', NOW())";
    $this->assertEquals($expected, $output);

    $db_data = mysql_fetch_assoc($wine->query('SELECT `id`, `varchar`, `int`, `unsigned_int`, `blob`, `datetime` FROM database_unit_test WHERE id = ' . $data['id']));

    unset($data['datetime']);
    $db_time = strtotime($db_data['datetime']);
    unset($db_data['datetime']);

    $this->assertEquals(true, time() < $db_time + 5);
    $this->assertEquals($data, $db_data);
  }


  public function testBadQuery() {
    $wine = new \lib\database('wine');

    $this->assertEquals(false, $wine->query('SELECT * FROM'));

  }



}
