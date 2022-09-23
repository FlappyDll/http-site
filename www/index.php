<?php
session_start();

if(!isset($_SESSION['auth'])){
    header('Location: login.php');
    exit;
} else {
    echo '<p class="success">Приветствую тебя, ', $_SESSION['name'], '!</p>';
}

?>


<form method="post" action="" name="hello-form">
  </div>
  <button type="exit" name="exit" value="exit">Exit</button>
</form>

<?php
if (isset($_POST['exit'])) {
    session_destroy();
    header('Location: login.php');
}
?>