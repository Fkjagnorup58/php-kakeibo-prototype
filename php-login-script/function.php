<?php
// //database_connection.php
// $connect = new PDO("mysql:host=localhost;dbname=php-kakeibo", "root", "root");


function dbconnect() {
return new PDO("mysql:host=localhost;dbname=php-kakeibo", "root", "root");
}

function validation($data) {
  $errors = [];
  if (!empty($data['mail'])) {
    // メールアドレスのバリデーションチェック
    // $errors['mail'] = '入力が間違っています。';
  }else{
    $errors['mail'] = 'メールアドレスの入力が空です';
  }
  if (!empty($data['password'])) {
    // パスワードのバリデーションチェック
    // $errors['password'] = 'パスワードが間違っています。';
  }else{
    $errors['password'] = 'パスワードの入力が空です';
  }
  return $errors;
}

?>