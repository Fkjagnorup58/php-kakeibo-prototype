<?php
//login.php

include("function.php");

if(isset($_COOKIE["type"]))
{
 header("location:../index.php");
}

$message = '';

if(isset($_POST["create"]))
{
  $post = [
    'mail' => $_POST["user_email"],
    'password' => $_POST["user_password"]
  ];
  $errors = validation($post);
  var_dump($errors);

  if(!empty($errors))
 {
  $message = "<div class='alert alert-danger'>二つとも入力が必要です。</div>";
 }
 else
 {
   $connect = dbconnect();
  $query = 'INSERT INTO users (mail, password, type) VALUES ( :mail, :password, :type)';
  $statement = $connect->prepare($query);
  $result = $statement->execute(
   array(
    'mail' => $_POST["user_email"],
    'password' => password_hash($_POST["user_password"],PASSWORD_DEFAULT),
    'type' => 'type'
   )
  );
  if($result){
    setcookie("type","type", time()+3600);
     header("location:../index.php");
  }
}
}


?>

<!DOCTYPE html>
<html>
 <head>
  <title>家計簿アプリ</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
  <div class ="header">
    <ul class="navbar-nav ml-md-auto">
            <li class="nav-item active">
              <a class="nav-link" href="./create.php">新規登録</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="./login.php">ログイン</a>
            </li>
          </ul>
    </div>
   <h2 align="center">家計簿アプリ</h2>
   <br />
   <div class="panel panel-default">

    <div class="panel-heading">新規登録</div>
    <div class="panel-body">
     <span><?php echo $message; ?></span>
     <form method="post">
      <div class="form-group">
       <label>メールアドレス</label>
       <input type="text" name="user_email" id="user_email" class="form-control" />
      </div>
      <div class="form-group">
       <label>パスワード</label>
       <input type="password" name="user_password" id="user_password" class="form-control" />
      </div>
      <div class="form-group">
       <input type="submit" name="create" id="create" class="btn btn-info" value="新規登録" />
      </div>
     </form>
    </div>
   </div>
   <br />
  </div>
 </body>
</html>
