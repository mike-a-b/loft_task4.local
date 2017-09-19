<?php
session_start();
$data = [];
if (isset($_SESSION['id'])) {
    $data['id'] = $_SESSION['id'];
    $data['login'] = $_SESSION['login'];
} else {
    header('HTTP/1.1 401 Unauthorized');
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php');
}
$params = require(__DIR__. '/backend/config.php');
require_once(__DIR__. '/backend/db_functions.php');
require_once __DIR__. '/backend/sec_functions.php';

$dbh = getConnection($params);
$users = getAllRegisterUsers($dbh);

//удаление аватарки
if (isset($_GET['delete'])) {
    $photo = getImage($dbh, $data['id']);
    if (file_exists(__DIR__.'/'.$photo)) {
        $photo ? @unlink($photo) : incorrect_value($data, "Ошибка удаления аватарки", 500);
    }
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/filelist.php');
} else {
    incorrect_value($data, "Поддельный запрос", 401);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
          <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                      aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">task4#loftschool</a>
          </div>
          <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                  <li><a href="index.php">Авторизация</a></li>
                  <li><a href="reg.php">Регистрация</a></li>
                  <li><a href="list.php">Список пользователей</a></li>
                  <li><a href="filelist.php">Список файлов</a></li>
              </ul>
          </div><!--/.nav-collapse -->
      </div>
  </nav>

  <div class="container">
<!--    <h1>Запретная зона, доступ только авторизированному пользователю</h1>-->
      <h2>Информация выводится из списка файлов</h2>
      <table class="table table-bordered">
        <tr>
          <th>Название файла</th>
          <th>Фотография</th>
          <th>Действия</th>
        </tr>
        <?php foreach ($users as $user) : ?>
        <tr>
          <td><?php echo explode('/', $user['photo'])[1]; ?></td>
          <td>
            <?php echo "<img style='width=100px; max-width: 120px;' src=\"/{$user['photo']}\" alt='photo'/>"; ?>
          </td>
          <td>
            <td data-id="<?php print $user['id']?>">
                <a href="<?php echo "?id=" . urlencode($user['id']); ?>">Удалить аватарку пользователя</a>
            </td>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>

    </div><!-- /.container -->
  
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>
</html>
