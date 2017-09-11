<?php
session_start();
$data = [];
$user_reg = null;
if (isset($_SESSION['id'])) {
    $data['id'] = $_SESSION['id'];
} else {
    header('HTTP/1.1 401 Unauthorized');
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php');
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
      <form class="form-horizontal" method="post" id="form__description"
            name = "description_form" enctype="multipart/form-data">
          <p class="alert alert-info invisible">
              <span class="result"></span>
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
                  <input type="submit" class="btn btn-info" value="Отправить" />
              </div>
          </div>
      </form>
  </div>

    <div class="container">
<!--    <h1>Запретная зона, доступ только авторизированному пользователю</h1>-->
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
        <tr>
          <td>vasya99</td>
          <td>Вася</td>
          <td>14</td>
          <td>Эксперт в спорах в интернете</td>
          <td><img src="http://lorempixel.com/people/200/200/" alt=""></td>
          <td>
            <a href="">Удалить пользователя</a>
          </td>
        </tr>
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