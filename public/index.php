<?php
require_once __DIR__ . '/../vendor/autoload.php';

$user = 'vlad';
$pass = 'qwer5';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../src/templates');
$view = new Environment($loader);

echo $view->render('index.twig');

if (isset($_GET["id"]) && isset($_GET["surname"]) && isset($_GET["name"])) {
  $id = $_GET["id"];
  $surname = $_GET["surname"];
  $name = $_GET["name"];
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=mb', $user, $pass);
    $query = $dbh->prepare("insert into names (id, surname, name) values (\"$id\",\"$surname\",\"$name\")");
    $query->execute();
    $rows = $dbh->query('SELECT * from names');
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }

  foreach($rows as $row) {
    echo nl2br($row['id'] . ' ' . $row['surname'] . ' ' . $row['name'] . "\r\n");
  }
} else {
  echo 'Введите значения';
}
