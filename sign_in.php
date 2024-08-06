<?php

require("db_connection.php");
$ErrorString = "";
$formErr = FALSE;
$errlI = FALSE;
$lI = "";
$errpW = FALSE;
$pW = "";

$ErrorStringPassword = '';
$ErrorStringLogin = '';

if(!empty($_POST)){
     $lI = $_POST["logIn"];
     $pW = $_POST["passWord"];
      
     global $ErrorString;
     global $formErr;
     if(strlen($lI)<4||strlen($lI)>14|| !ctype_alpha($lI)){
        $ErrorStringLogin = "<b>Логин должен состоять из букв и иметь длину от 4 до 14 символов</b><br>";
         $formErr= TRUE;
         $errlI=TRUE;
     }

     if($pW == ""){
         $ErrorStringPassword = "<b>Пароль не может быть пустым</b><br>";
         $formErr= TRUE;
         $errpW=TRUE;
     }
     if(!$formErr){

         $dsn = "mysql:host=localhost;port=3306;dbname=librarium;charset=utf8";
         $options = [
             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
         ];

         try{
              // З'єднання з базою даних database1
         }
         catch (PDOException $e) { //если установить соединение с БД не получилось, нас перебраксывает на Register.php
             $pdo = null;
             header("Location: registration_form.php");
             exit;
         }   
         

          try{
             $results = $pdo->query("SELECT _login, _password FROM user"); 
         }catch (PDOException $e) {
             $results = null;
             $pdo = null;
             header("Location: registration_form.php");
             exit;
         }  
         try{
             while($row = $results -> fetch(PDO::FETCH_NUM)) {
                 $column1 = $row[0];
                 $column2 = $row[1]; 
                 if($column1==$lI){
                     if($column2==$pW){
                         $results = null;
                         $pdo = null;
                         //устанавливаем кукичи?
                         setcookie('logIn', $lI);
                         setcookie('passWord', $pW);
                         header("Location: account.php");
                         exit;
                     }else{
                         $ErrorStringPassword = "<b>Неверный логин или пароль</b><br>";
                         $formErr= true;
                         $errpW=true;
                         break;
                     }
                 }else{
                     $errlI = TRUE;
                     $ErrorStringLogin = "<b>Неверный логин или пароль</b><br>";
                     $formErr= true;
                 }
             } 
         }catch (PDOException $e) {
             $results = null;
             $pdo = null;
             header("Location: registration_form.php");
             exit;
         }
         $results = null;
         $pdo = null;
     }
 }
        // echo "<br>$ErrorStringLogin";
        // echo "<br>$ErrorStringPassword";




        /*function getUserLogin(){
            $logFromCookie = $_COOKIE['login']??'';
            $logFromCookie = $_COOKIE['password']??'';            
        }*/
?>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/e202a65f05.js" crossorigin="anonymous"></script>
    <!--
    <link rel="stylesheet" href="fun_style.css">
    -->
    <link rel="stylesheet" href="fun_style.css">
    <link rel="stylesheet" href="style.css">

    <!-- <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet"> -->

    <title>Авторизация | Librarium</title>
</head>
<body>

<?php
    include('header.php');
?>
    <div class="reg-wrapper0">
        <div class="reg-wrapper">
            <div class="container1">

                <div class="container2">
                    <div class="reg-header">
                        <h2>Авторизация</h2>
                        
                    </div>
                    <br>
                    <h3 style="text-align: center;">Войдите в аккаунт, чтобы совершать покупки</h3>
                <div class="input-container">
                    <form class="sign-in form" action="sign_in.php" method="POST">
                        <div class="sign-in form-wrapper1">
                                <div class="sign-in form-control">
                                    <div <?php if(!empty($_POST)){echo ($errlI==true)? 'class = "input-wrapper error"' : 'class= "input-wrapper success"';} else echo 'class="input-wrapper"'?>>
                                        <label class="sign-in label" for="username">Логин: &nbsp</label>
                                        <input type="text" placeholder="sherlockHolmes" name="logIn" value="<?=$lI?>">
                                        <small><?=$ErrorStringLogin?></small>
                                    </div>
                                </div>

                                <div class="sign-in form-control">
                                    <div <?php if(!empty($_POST)){echo ($errpW==true)? 'class = "input-wrapper error"' : 'class= "input-wrapper success"';} else echo 'class="input-wrapper"'?>>
                                        <label class="sign-in label" for="username">Пароль: &nbsp</label>
                                        <input type="password" id="password" name="passWord" value="<?=$pW?>">
                                        <div class="toggle_visibility"></div>
                                        <small><?=$ErrorStringPassword?></small>
                                    </div>
                                </div>
                                <div class="sign-in form-control">
                                    <button type="submit">Вход</button>
                                </div>
                                <span id="register">
                                    <p><a href="registration_form.php">Нет аккаунта? Регистрация</a></p>
                                </span>
                                <span id="forgot-password">
                                    <p><a href="password_reset.php">Забыли пароль?</a></p>
                                </span>
                        </div>
                        



                    </form>
                </div>    





                </div>
            </div>
        </div>
    </div>


    <?php
        if($formErr)
         echo $ErrorString;
        ?>

<?php
    include('footer.php');
?>




    
<script src="sign_in.js"></script>
    
    </body>
    </html>