<?php

if(isset($_POST['logOut'])){
    if(isset($_COOKIE['logIn'])){
        setcookie('logIn', null, -1);
    }

    if(isset($_COOKIE['passWord'])){
        setcookie('passWord', null, -1);
    }

    header("Location: sign_in.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FONTS -->    
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
    <!-- OWL-CAROUSEL --> 
    <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
    <!-- CUSTOM CSS FILE -->
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="fun_style.css">    
    <!-- FA-ICONS -->
    <script src="https://kit.fontawesome.com/e202a65f05.js" crossorigin="anonymous"></script>

    
    <title>Аккаунт | Librarium</title>
</head>
<body>
<?php
include ('header.php');
?>

<?php
echo "<br><br>";
echo "<h1 style='text-align: center;'>";
echo "Добро пожаловать! Вы вошли как ";
echo $_COOKIE['logIn'];
echo ".</h1>";
?>

<form class="form" action="account.php" method="POST">
    
    <input type="hidden" name="logOut" value="">
    <div class="sign-in form-control">
        <button style="width: 400px">Выйти</button>
    </div>
</form>

<div class="float-bottom" style="position: absolute; bottom: 0; width: 100%;">
    <?php
    include ('footer.php');
    ?>
</div>

</body>
</html>