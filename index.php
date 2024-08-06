<?php

require("db_connection.php");

if(!empty($_POST)){
    if(!isset($_COOKIE['logIn'])){
        header("Location: sign_in.php");
    }
    else if(isset($_POST['product_id'])){
        if($_POST['addition_list'] == "cart"){
            try{
            $username = $_COOKIE['logIn'];
            $idToAdd = $_POST['product_id'];
            $inCart = $pdo->query("SELECT * FROM cart WHERE user_login = '$username' AND item_id = $idToAdd");
            $inCartRow = $inCart->fetch(PDO::FETCH_NUM);
            if(!empty($inCartRow)) {
                $amount = $inCartRow[2] + 1; 
                $pdo->query("UPDATE cart SET amount = $amount WHERE item_id=$idToAdd");
            }
            else $pdo->query("INSERT INTO cart (user_login, item_id) VALUES ('$username', $idToAdd)");
            }
            catch (PDOException $e) {
                $pdo = null;
                echo '' . $e->getMessage(); 
                exit;
            }
        }
        else if ($_POST['addition_list'] == "wishlist"){
            try{
                $username = $_COOKIE['logIn'];
                $idToAdd = $_POST['product_id'];
                $inCart = $pdo->query("SELECT * FROM wishlist WHERE user_login = '$username' AND item_id = $idToAdd");
                $inCartRow = $inCart->fetch(PDO::FETCH_NUM);
                if(!empty($inCartRow)) {
                    // $amount = $inCartRow[2] + 1; 
                    // $pdo->query("UPDATE cart SET amount = $amount WHERE item_id=$idToAdd");
                }
                else $pdo->query("INSERT INTO wishlist (user_login, item_id) VALUES ('$username', $idToAdd)");
                }
            catch (PDOException $e) {
                $pdo = null;
                echo '' . $e->getMessage(); 
                exit;
            }
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
    <!-- FONTS -->    
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap" rel="stylesheet">
    <!-- OWL-CAROUSEL --> 
    <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
    <!-- <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css"> -->
    <!-- CUSTOM CSS FILE -->
    <link rel="stylesheet" href="style.css" type="text/css">    
    <!-- FA-ICONS -->
    <script src="https://kit.fontawesome.com/e202a65f05.js" crossorigin="anonymous"></script>
    
    <title>Librarium | Buy Books Online</title>
</head>

<body>
   
    <?php
    include('header.php');
    ?>



        <!-- home section begins -->
        

        <section class="home" id="home">

            <!-- featured slider -->
            <div class="row-slider" id="featured">

            
            
                <div class="preview">
                    <a href="product.php">
                        <img src="images/foundryside_cover.jpg" alt="">
                    </a>
                </div>
                <div class="preview-descript">
                    <h2>FOUNDRYSIDE</h2>
                    <h3>АВТОР - </h3>
                    <h2>ROBERT JACKSON BENNET</h2>
                    <br>
                    <p>
                    Захватывающее начало новой перспективной серии фэнтезийных романов. Приготовьтесь погрузиться в древние тайны, оригинальную магическую систему и ограбления, от которых захватывает дух.
                        <br>
                        <br>
                        &#8212 Брендон Сандерсон, перевод цитаты
                    </p>
                </div>

            </div>
            

        </section>


        <!-- home section ends -->        
        
        <?php
        $dsn = "mysql:host=localhost;port=3306;dbname=librarium;charset=utf8"; //dsn stands for data source name
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        try {
            // З'єднання з базою даних
            // $pdo = new PDO($dsn, "$db_server_username", "$db_server_password", $options);
            $results = $pdo->query("SELECT * FROM products WHERE item_sold > 100");
            //print_r($results); //prints the query itself
            $resultArray = array();

            while($item = $results->fetch(PDO::FETCH_ASSOC)){
                //print_r($item);
                $resultArray[] = $item;
                echo "\n";
            }
        }
        catch(PDOEexception $e){
            echo "Ошибка выполнения операции: ". $e->getMessage();
        }
        //echo $user_id; //check if the variable is accessible from this file
        ?>

        <section id="top-sale">
            <div class="books-container">
                <h2>Популярные</h2>
                    <div class="owl-carousel owl-theme">
                        <?php foreach($resultArray as $item){ ?>
                            <div class="item">
                                <div class="img-container">
                                    <div class="product">
                                        <a href="product.php?item_id=<?php echo $item['item_id']?>">
                                            <img src="<?php echo $item['item_image']?>" alt="">
                                        </a>
                                    </div>
                                </div>
                                    <a class="item-name" href="product.php?item_id=<?php echo $item['item_id']?>">
                                        <h3 class="book-title"><?php echo $item['item_name']?? 'Unknown'?></h3>
                                    </a>
                                    <h4><?php echo $item['item_author']?? 'Unknown'?></h4>
                                    <h3 class="item-price"><s><?php if(isset($item['item_oldprice'])) echo $item['item_oldprice']." UAH"?></s>&nbsp&nbsp<?php echo $item['item_price']?> UAH</h3>
                                    <h4 class="back-type"><?php echo $item['item_backtype'] ?> обложка</h3>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="addition_list" value="cart">
                                        <input type="hidden" name="product_id" value="<?=$item['item_id']?>">
                                        <button type="submit" class="buy-btn">ДОБАВИТЬ В КОРЗИНУ</button>
                                    </form>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="addition_list" value="wishlist">
                                        <input type="hidden" name="product_id" value="<?=$item['item_id']?>">
                                        <button type="submit" class="wish-btn">ДОБАВИТЬ В ИЗБРАННОЕ</button>
                                    </form>
                            </div>
                        <?php }?>
                    </div>

            </div>
            
        </section>

        <?php
        $results = $pdo->query("SELECT * FROM products WHERE item_register > '20211205'");
        $resultArray = array();
        while($item = $results->fetch(PDO::FETCH_ASSOC)){
            //print_r($item);
            $resultArray[] = $item;
            echo "\n";
        }
        ?>




        <section id="new">
            <div class="books-container">
                <h2>Новые</h2>
                    <div class="owl-carousel owl-theme">
                        <?php foreach($resultArray as $item){ ?>
                            <div class="item">
                                <div class="img-container">
                                    <div class="product">
                                        <a href="product.php?item_id=<?php echo $item['item_id']?>"><img src="<?php echo $item['item_image']?>" alt=""></a>
                                    </div>
                                </div>
                                    <a class="item-name" href="product.php?item_id=<?php echo $item['item_id']?>">
                                        <h3 class="book-title"><?php echo $item['item_name']?? 'Unknown'?></h3>
                                    </a>
                                    <h4><?php echo $item['item_author']?? 'Unknown'?></h4>
                                    <h3 class="item-price"><s><?php if(isset($item['item_oldprice'])) echo $item['item_oldprice']." UAH"?></s>&nbsp&nbsp<?php echo $item['item_price']?> UAH</h3>
                                    <h4 class="back-type"><?php echo $item['item_backtype'] ?> обложка</h3>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="addition_list" value="cart">
                                        <input type="hidden" name="product_id" value="<?=$item['item_id']?>">
                                        <button type="submit" class="buy-btn">ДОБАВИТЬ В КОРЗИНУ</button>
                                    </form>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="addition_list" value="wishlist">
                                        <input type="hidden" name="product_id" value="<?=$item['item_id']?>">
                                        <button type="submit" class="wish-btn">ДОБАВИТЬ В ИЗБРАННОЕ</button>
                                    </form>
                            </div>
                        <?php }?>
                    </div>

            </div>
            
        </section>


        <?php
        $results = $pdo->query("SELECT * FROM products WHERE item_sold > 100 AND item_category = 'фэнтези'");
        $resultArray = array();
        while($item = $results->fetch(PDO::FETCH_ASSOC)){
            //print_r($item);
            $resultArray[] = $item;
            echo "\n";
        }
        ?>



        <section id="best-fantasy">
            <div class="books-container">
                <h2>Лучшие книги в разделе фэнтези</h2>
                    <div class="owl-carousel owl-theme">
                        <?php foreach($resultArray as $item){ ?>
                            <div class="item">
                                <div class="img-container">
                                    <div class="product">
                                        <a href="product.php?item_id=<?php echo $item['item_id']?>"><img src="<?php echo $item['item_image']?>" alt=""></a>
                                    </div>
                                </div>
                                    <a class="item-name" href="product.php?item_id=<?php echo $item['item_id']?>">
                                        <h3 class="book-title"><?php echo $item['item_name']?? 'Unknown'?></h3>
                                    </a>
                                        <h4><?php echo $item['item_author']?? 'Unknown'?></h4>
                                    <h3 class="item-price"><s><?php if(isset($item['item_oldprice'])) echo $item['item_oldprice']." UAH"?></s>&nbsp&nbsp<?php echo $item['item_price']?> UAH</h3>
                                    <h4 class="back-type"><?php echo $item['item_backtype'] ?> обложка</h3>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="addition_list" value="cart">
                                        <input type="hidden" name="product_id" value="<?=$item['item_id']?>">
                                        <button type="submit" class="buy-btn">ДОБАВИТЬ В КОРЗИНУ</button>
                                    </form>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="addition_list" value="wishlist">
                                        <input type="hidden" name="product_id" value="<?=$item['item_id']?>">
                                        <button type="submit" class="wish-btn">ДОБАВИТЬ В ИЗБРАННОЕ</button>
                                    </form>
                            </div>
                        <?php }?>
                    </div>

            </div>
            
        </section>



        <?php
        include('footer.php');
        ?>



</body>
</html>