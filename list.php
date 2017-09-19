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
require_once(__DIR__. '/backend/sec_functions.php');

$dbh = getConnection($params);
$users = getAllRegisterUsers($dbh);

//удаление пользователя
if (isset($_GET['id'])) {
    $photo = getImage($dbh, $data['id']);
    if (file_exists($photo)) {
        if (!@unlink($photo)) {
            incorrect_value2($data, "Ошибка удаления пользователя", 500);
        }
        if (deleteUser($dbh, $data)) {
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/list.php');
        } else {
            incorrect_value2($data, "Ошибка удаления пользователя", 500);
        }
    }
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
<!--форма добавления пользователя-->
  <div class="contaiqner">
      <form class="form-horizontal" method="post" action=""
            name = "description_form" enctype="multipart/form-data" id="form__description">
          <p class="alert alert-info invisible">
              <span class="result">Авторизуйтесь или зарегистрируйтесь</span><br>
          </p>
          <div class="form-group">
              <label for="name" class="control-label col-sm-2">Имя</label>
              <div class="col-sm-10">
                  <input name="name" type="text" id="name1" class="form-control" placeholder="Имя" required/>
              </div>
          </div>
          <div class="form-group">
              <label for="age" class="control-label col-sm-2" >Возраст</label>
              <div class="col-sm-10">
                  <input name="age" type="number" class="form-control" placeholder="Возраст" required/>
              </div>
          </div>
          <div class="form-group">
              <label for="description" class="control-label col-sm-2" >Описание</label>
              <div class="col-sm-10">
                  <input name="description" type="text" class="form-control" placeholder="Описание" required/>
              </div>
          </div>
          <div class="form-group">
              <label for="file1" class="control-label col-sm-2" >Описание</label>
              <div class="col-sm-10">
                  <input name="upload" id="file1" type="file" class="form-control" placeholder="Фото" required/>
              </div>
          </div>
          <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" name="desc_submit" class="btn btn-info" value="Отправить" />
                <?php if (isset($_SESSION['id'])) : ?>
                  <button class="btn btn-info"><a href="user_logout.php">Выйти из сессии</a></button>
                <?php endif; ?>
              </div>
          </div>
      </form>
  </div>
  
    <div class="container">
        <?php if (isset($_GET['id'])) : ?>
      <h2 class="click_response"> <?php print "Пользователь {$_SESSION['login']} удален!" ?></h2>
        <?php endif; ?>
      <h2>Информация выводится из базы данных</h2>
      <table class="table table-bordered">
        <tr>
          <th>Пользователь(логин)</th>
          <th>Имя</th>
          <th>возраст</th>
          <th>описание</th>
          <th>Фотография</th>
          <th>Действия</th>
        </tr>
        <?php
        foreach ($users as $user) : ?>
        <tr data-id="<?php print $user['id']?>">
            <td><?php print $user['login']; ?></td>
            <td><?php print $user['name']; ?><?php print $user['name']; ?></td>
            <td><?php print $user['age']; ?></td>
            <td><?php print $user['description']; ?></td>
            <td>
            <?php echo "<img style='width=100px; max-width:120px;' src=\"/{$user['photo']}\" alt='photo'/>"; ?></td>
            <td data-id="<?php print $user['id']?>">
                <a href="<?php echo "?id=" . urlencode($user['id']); ?>">Удалить  пользователя</a>

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
