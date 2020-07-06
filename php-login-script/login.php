<?php
//login.php

include("function.php");

if(isset($_COOKIE["type"]))
{
 header("location:../index.php");
}

$message = '';

if(isset($_POST["login"]))
{
 if(empty($_POST["user_email"]) || empty($_POST["user_password"]))
 {
  $message = "<div class='alert alert-danger'>記入していません</div>";
 }
 else
 {
  $query = "
  SELECT * FROM users
  WHERE mail = :user_email
  ";
  $connect = dbconnect();
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    'user_email' => $_POST["user_email"]
   )
  );
  $count = $statement->rowCount();
  if($count > 0)
  {
   $result = $statement->fetchAll();
   foreach($result as $row)
   {
    if(password_verify($_POST["user_password"], $row["password"]))
    // if($_POST["user_password"] === $row["password"])
    {
     setcookie("type", $row["type"], time()+3600);
     header("location:../index.php");
    }
    else
    {
     $message = '<div class="alert alert-danger">パスワードが間違っています。</div>';
    }
   }
  }
  else
  {
   $message = "<div class='alert alert-danger'>メールアドレスが間違っています。</div>";
  }
 }
}


?>

<!DOCTYPE html>
<html>
 <head>
  <title>家計簿アプリ</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
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

    <div class="panel-heading">ログイン</div>
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
       <input type="submit" name="login" id="login" class="btn btn-info" value="ログイン" />
      </div>
     </form>
    </div>
   </div>
   <br />
  </div>
 </body>
</html>
