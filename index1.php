<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['name1']) || empty($_POST['e_mail']) || empty($_POST['year']) || empty($_POST['gender']) || empty($_POST['biography'])) {
  print('Не все поля формы заполнены.<br/>');
  $errors = TRUE;
}

// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
// *************

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.

$name1 = $_POST['name1'];
$e_mail = $_POST['e_mail'];
$year = $_POST['year'];
$gender = $_POST['gender'];
$limbs = $_POST['limbs'];
$biography = $_POST['biography'];
$ability_god = '0';
$ability_fly = '0';
$ability_fireball = '0';
$ability = $_POST['super_skill'];

$user = 'u41057';
$pass = '1243534';
$table1_name ="application";
$table2_name ="superpowers";
$db = new PDO('mysql:host=localhost;dbname=u41057', $user, $pass);

// Подготовленный запрос. Не именованные метки.
try {
  $db->exec("set names utf8");
  $data1 = array('name1' => $name1, 'e_mail'=> $e_mail, 'year'=>$year, 'gender'=>$gender, 'limbs'=>$limbs, 'biography'=>$biography);
  $data2 = array('ability'=>$ability);
  $q1 = $db->prepare("INSERT INTO $table1_name (name1, e_mail, year, gender, limbs, biography) VALUES(:name1, :e_mail, :year, :gender, :limbs, :biography)");
  $q1->execute($data1);
  $q2 = $db->prepare("INSERT INTO $table2_name (ability) VALUES(:ability)");
  $q2->execute($data2);
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

//  stmt - это "дескриптор состояния".
 
//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(array('label'=>'perfect', 'color'=>'green'));
 
//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
