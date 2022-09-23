<?php
    include('settings.php');
    include('gen.php');

    session_start();

    if(isset($_SESSION['auth'])){
        header('Location: index.php');
      }
    
    $check = 1;
    if (isset($_POST['register'])) {
        $login = $_POST['login'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $query = $connection->prepare("SELECT `login` FROM `users` WHERE `login` = :login");
        $query->bindParam("login", $login, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $check = 0;
        }
        if ($query->rowCount() == 0) {
            $salt = generateSalt();
            $saltedPassword = md5(md5(md5(md5($password).$salt)).$salt);
            
            $query = $connection->prepare("INSERT INTO users(name,login,salt,password) VALUES (:name,:login,:salt,:saltedPassword)");
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->bindParam("login", $login, PDO::PARAM_STR);
            $query->bindParam("salt", $salt, PDO::PARAM_STR);
            $query->bindParam("saltedPassword", $saltedPassword, PDO::PARAM_STR);
            $result = $query->execute();
            if ($result) {
                $check = 1;
                //echo '<p class="success">Регистрация прошла успешно!</p>';
                //$new_url = 'http://localhost/login.php';
                //header('Location: '.$new_url);
                header('Location: login.php');
            } else {
                echo '<p class="error">Неверные данные!</p>';
            }
        }
    }
?>

<h1>Форма регистрации на сайт</h1>


<form method="post" action="" name="signup-form">
    <div class="form-element">
        <label>Login</label>
        <input type="text" name="login" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Name</label>
        <input type="text" name="name" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" name="password" required />
    </div>
    <button type="register" name="register" value="register">Register</button>
    <button type="submit" name="sumbit" value="sumbit">Log In</button>
    </div>
    <div class="error">
        <?php
        if ($check == 0){
            echo '<p class="error">Этот логин уже зарегистрирован!</p>';
        }
        ?>
    </div>
</form>

<?php
if (isset($_POST['sumbit'])) {
    header('Location: login.php');
}
?>