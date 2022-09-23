<?php
    include('settings.php');
    include('gen.php');
    session_start();

    if(isset($_SESSION['auth'])){
      header('Location: index.php');
    }

    $check = 1;
    if (isset($_POST['sumbit'])) {
      $login = $_POST['login'];
      $password = $_POST['password'];
      $query = $connection->prepare("SELECT * FROM `users` WHERE `login` = :login");
      $query->bindParam("login",  $login, PDO::PARAM_STR);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      if (!$result) {
        $check = 0;
        //echo '<p class="error">Неверные пароль или имя пользователя!</p>';
      } else {
        $salt = $result['salt'];
        $saltedPassword = md5(md5(md5(md5($password).$salt)).$salt);
        if ($result['password'] == $saltedPassword) {

          session_start();

          $check = 1;

          $_SESSION['auth'] = true;
          $_SESSION['id'] = $result['id_user'];
          $_SESSION['login'] = $result['login'];
          $_SESSION['name'] = $result['name'];
          
          //$new_url = 'http://localhost/index.php';
          //header('Location: '.$new_url);
          header('Location: index.php');

          //echo '<p class="success">Поздравляем, вы прошли авторизацию!</p>';
        } else {
          $check = 0;
          //echo '<p class="error"> Неверные пароль или имя пользователя!</p>';
        }
      }
    }
?>

<h1>Форма фхода на сайт</h1>
<form method="post" action="" name="signin-form">
  <div class="form-element">
    <label>Login</label>
    <input type="text" name="login" pattern="[a-zA-Z0-9]+" />
  </div>
  <div class="form-element">
    <label>Password</label>
    <input type="password" name="password" />
  </div>
  <button type="submit" name="sumbit" value="sumbit">Log In</button>
  <button type="register" name="register" value="register">Register</button>
  </div>
  <div class="error">
        <?php
        if ($check == 0){
            echo '<p class="error">Неверные пароль или имя пользователя!</p>';
        }
        ?>
    </div>
</form>

<?php
if (isset($_POST['register'])) {
  header('Location: register.php');
}
?>