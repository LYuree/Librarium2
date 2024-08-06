<?php
    global $formErr;

    $formErr = "";

    $errlN = FALSE;
    $lN = "";
    $errfN = FALSE;
    $fN = "";

    $pN = "";
    $erreA = FALSE;
    $eA = "";
    $errma = FALSE;
    $ma = "";
    $errlI = FALSE;
    $lI = "";
    $errpW = FALSE;
    $pW = "";
    $errrpW = FALSE;
    $rpW = "";


    $pdo = null;
    $results = null; 
    $NoTable = true;

    if(!empty($_POST)){           //if there's a query (read: if the user has submitted his form data)
        $lN = $_POST["lName"];
        $fN = $_POST["fname"];
        $eA = $_POST["email"];
        $lI = $_POST["username"];
        $pW = $_POST["password"];
        $rpW = $_POST["password2"];
        
        global $ErrorStringUsername;
        global $ErrorStringFName;
        global $ErrorStringLName;
        global $ErrorStringEmail;
        global $ErrorStringPw;
        global $ErrorStringPw2;

        function checkCyrillic($src){
            for($i = 0; $i < strlen($src); $i++){
                if(!(($src[$i] >= 'а' && $src[$i] <= 'я') || ($src[$i] >= 'А' && $src[$i] <= 'Я') ||($src[$i] == "'"))) {
                    return false;
                    break;
                }
                return true;
            }
        }
        
        function NameVal(&$errorString, &$src, $nametype){
            global $ErrorString;
            $err = FALSE;
            $src=trim($src);
            if($src == ""){
                $errorString.= "<b> $nametype незаповнене поле. </b><br>";
                $err=true;
                $formErr= "error";
                
            }else{
                $src = ucfirst($src);
                if(!ctype_alpha($src) && !checkCyrillic($src)){
                    $errorString.= "<b> У полі $nametype є цифри. </b><br>";
                    $err=true;
                    $formErr= "error";
                }
            }
            return $err;
        } 
        
        function CheckEmail($email){
            $email = trim($email);
            if(strlen($email) == 0)
                return false;
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
            else return false;

         }

        $ErrorString="<b> Помилки заповнення:</b><br>";
        $errfN=NameVal($ErrorStringFName, $fN, "Ім'я ");
        $errlN=NameVal($ErrorStringLName, $lN, "Прізвище ");

        if(trim($eA) == ""){
            $ErrorStringEmail.= "<b> E-mail: незаполненное поле. </b><br>";
            $formErr= "error";
            $erreA=true;
        }elseif(!checkEmail($eA)){
            $ErrorStringEmail.= "<b> E-mail: несуществующий e-mail. </b><br>";
            $formErr= "error";
            $erreA=true;
        }

        if(trim($lI) == ""){
            $ErrorStringUsername.= "<b> Логин: незаполненное поле. </b><br>";
            $formErr= "error";
            $errlI=true;
            
        }elseif(strlen($lI)<4||strlen($lI)>14|| !ctype_alpha($lI)){
            $ErrorStringUsername = "<b>Логин должен содержать только бувы и иметь длину от 4 до 14 символов </b>";
            $formErr= "error";
            $errlI=true;

        }
        if($pW == ""){
            $ErrorStringPw.= "<b> Не указан пароль </b><br>";
            $formErr= "error";
            $errpW=true;
        }elseif(strlen($pW)<6 || strlen($pW)>15){
            $ErrorStringPw.= "<b> Длина пароля должна быть от 6 до 15 символов </b><br>";
            $formErr= "error";
            $errpW=true;
        }elseif($rpW == ""){
            $ErrorStringPw.= "<b> He подтверждён пароль </b><br>";
            $formErr= "error";
            $errrpW=true;
        }
        elseif($pW != $rpW){
            $ErrorStringPw2.= "<b> Пароли не совпадают </b><br>";
            $formErr= "error";
            $errrpW=true;
        }  

if($formErr == ""){

    require("db_connection.php");

    $IsLogIn=false;
    $IsEmail=false;
    $results = $pdo->query("SELECT * FROM user");
        
    try {            
        while($row = $results -> fetch(PDO::FETCH_NUM)) {
            $column2 = $row[3];
            $column1 = $row[4];
            if($column1==$lI){
                $IsLogIn=true;

                break;
            }elseif($column2 == $eA)
            {
                $IsEmail=true;
                break;
            }
        } 
    }catch (PDOException $e) {
        $pdo = null;
        echo 'Не выполнен метод fetch(): ' . $e->getMessage(); 
        exit;
    }


if($IsLogIn){
    $ErrorStringUsername = "<b>Введённый логин уже используется.</b>";
    $formErr= "error";
    $errlI=true;
    $results = null;
    $pdo = null;
}
elseif($IsEmail){
    $ErrorStringEmail = "<b>Введённый e-mail уже используется.</b>";
    $formErr= "error";
    $erreA=true;
    $results = null;
    $pdo = null;
}
else{
    $sql = "INSERT  INTO user (first_name, last_name, email, _login, _password) VALUES('$lN', '$fN', '$eA', '$lI', '$pW')"; 
    $results = $pdo->query($sql);
    $results = null;
    $pdo = null;
    $signed_in = TRUE;
    $user_id = $lI;
    header("Location: index.php");

}


        
}

}



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

    <title>Регистрация | Librarium</title>
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
                        <h2>Создать аккаунт</h2>
                    </div>  
                </div>
                
                <form class="form" id="form1" action="registration_form.php" method="post" style="margin-top: 20px;">
                    <div class="form-wrapper1">
                        <div class="form-control">
                            <div <?php if(!empty($_POST)){echo ($errlI==true)? 'class = "input-wrapper error"' : 'class= "input-wrapper success"';} else echo 'class="input-wrapper"'?>>
                                <label for="username">Имя пользователя (4-8 символов): &nbsp</label>
                                <input type="text" placeholder="sherlockHolmes" name="username" value="<?=$lI?>">
                                <small><?=$ErrorStringUsername?></small>
                            </div>

                            <div <?php if(!empty($_POST)){echo ($erreA==true)? 'class = "input-wrapper error"' : 'class= "input-wrapper success"';} else echo 'class="input-wrapper"'?>>
                                <label for="email">E-mail: &nbsp</label>
                                <input type="text" placeholder="holmes1987@whatever.com" name="email" value="<?=$eA?>">
                                <small><?=$ErrorStringEmail?></small>
                            </div>                            

                        </div>

                        <div class="form-control">
                            <div <?php if(!empty($_POST)){echo ($errfN)? 'class = "input-wrapper error"' : 'class= "input-wrapper success"';} else echo 'class="input-wrapper"'?>>
                                <label for="fname">Ваше настоящее имя: &nbsp</label>
                                <input type="text" placeholder="Sherlock" name="fname" value="<?php echo $fN; ?>">
                                <small><?=$ErrorStringFName?></small>
                            </div>

                            <div <?php if(!empty($_POST)){echo ($errlN)? 'class = "input-wrapper error"' : 'class= "input-wrapper success"';}else echo 'class="input-wrapper"'?>>
                                <label for="lName">Ваша настоящая фамилия: &nbsp</label>
                                <input type="text" placeholder="Holmes" name="lName" value="<?php echo $lN; ?>">
                                <small><?=$ErrorStringLName?></small>
                            </div>

                        </div>
                        
                        <div class="form-control">
                            <div <?php if(!empty($_POST)){echo ($errpW==true)? 'class = "input-wrapper error"' : 'class= "input-wrapper success"';}else echo 'class="input-wrapper"'?>>
                                <label for="password">Пароль: &nbsp</label>
                                <input type="password" placeholder="Пароль" name="password" id="password" value="<?php echo $pW; ?>">
                                <div class="toggle_visibility"></div>
                                <small><?=$ErrorStringPw?></small>
                            </div>

                            <div <?php if(!empty($_POST)){echo ($errrpW)? 'class = "input-wrapper error"' : 'class= "input-wrapper success"';}else echo 'class="input-wrapper"'?>>
                                    <label for="password2">Подтвердите пароль: </label>
                                    <input type="password" placeholder="Повторите пароль" name="password2" id="password2" value="<?php echo $rpW; ?>">
                                    <div class="toggle_visibility"></div>
                                    <small><?=$ErrorStringPw2?></small>
                            </div>

                        </div>
                        <button type="submit">Регистрация</button>
                    </div>
                </form>
            </div>     

        </div>
    </div>   

    <?php
    include('footer.php');
    ?>
    
    <script src="reg_script.js"></script>
    
</body>
</html>