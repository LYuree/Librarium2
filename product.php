<?php

require("db_connection.php");

if(!empty($_POST)){
    if(!isset($_COOKIE['logIn'])){
        header("Location: sign_in.php");
    }
    else if(isset($_POST['product_id'])){
        try{
        $username = $_COOKIE['logIn'];
        $idToAdd = $_POST['product_id'];
        $inCart = $pdo->query("SELECT * FROM cart WHERE user_login = '$username' AND item_id = $idToAdd");
        $inCartRow = $inCart->fetch(PDO::FETCH_NUM);
        // print_r($inCart);
        // print_r($inCartRow);
        if(!empty($inCartRow)) {
            $amount = $inCartRow[2] + 1; 
            $pdo->query("UPDATE cart SET amount = $amount WHERE item_id=$idToAdd");
        }
        else $pdo->query("INSERT INTO cart (user_login, item_id) VALUES ('$username', $idToAdd)");
        // echo 'Selected item was added to your cart!';
        }
        catch (PDOException $e) {
            $pdo = null;
            echo '' . $e->getMessage(); 
            exit;
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
    <link rel="stylesheet" href="style.css">
        <!-- OWL-CAROUSEL --> 
    <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
    <script src="https://kit.fontawesome.com/e202a65f05.js" crossorigin="anonymous"></script>
    <script defer="defer">
        console.log(document.cookie);
    </script>
    <title>Страница товара | Librarium</title>
</head>
<body>


<?php
include('header.php');

$item_id = $_GET['item_id']??1;

        $dsn = "mysql:host=localhost;port=3306;dbname=librarium;charset=utf8"; //dsn stands for data source name
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        try {
            // З'єднання з базою даних
            $results = $pdo->query("SELECT * FROM products");
            $resultArray = array();
            while($item = $results->fetch(PDO::FETCH_ASSOC)){
                $resultArray[] = $item;
            }
            //===============================
        }
        catch(PDOEexception $e){
            echo "Ошибка выполнения операции: ". $e->getMessage();
        }

        foreach($resultArray as $item) if($item_id == $item['item_id']){?>


   <div class="product-categories">
       <h3>Вы можете найти эту книгу в категории(-ях):</h3>
       <p><a href="product_grid.php?category=<?= $item['item_category']?>"><?= ucfirst($item['item_category'])?></a>
   </div>

   <main class="content-preview">
        <section class="random">

            <div class="wrapper1">
                <div class="image">
                    <img src="<?=$item['item_image']?>" alt="">
                </div>
            </div>

            <div class="description">
                    <h2><?= $item['item_name']?></h2>
                    <h3>автор <?=$item['item_author']?></h3>

                    
                <div class="buy-container">
                    <div class="row row1">
                            <span class="back-type">
                                <?=$item['item_backtype']?> обложка
                            </span>
                            <span class="price"><?php echo $item['item_price']?> UAH</span>

                            <?php if(isset($item['item_oldprice'])) {?>
                                <span class="old-price"><s><?=$item['item_oldprice']?></s></span>
                                <br>
                                <span class="saving">Вы можете сэкономить: <?= $item['item_oldprice'] - $item['item_price']?> UAH</span>
                            <?php }?>
                            <br>
                            <i class="fas fa-check"></i>&nbsp<span class="availability"><?= $item['item_instock'] > 0 ? 'В наличии' : 'Нет в наличии'?> </span>
                    </div>
                    

                    <div class="action-list">
                        <div class="product-form">
                            <div class="row row4 action-container">
                                <div>
                                    <p>Товар будет добавлен в вашу корзину</p>
                                </div>
                                <div>
                                    <form action="" method="post">
                                        <input type="hidden" name="product_id" value="<?=$item['item_id']?>">
                                        <button type="submit" id="btn-add-to-cart">Добавить в корзину</button>
                                    </form>
                                    
                                </div>
                            </div>
                            <div class="row row5 action-container">
                                <div>
                                    <p>Товар будет добавлен в ваш список избранного</p>
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?=$item['item_id']?>">
                                    <button type="submit" id="btn-add-to-wish-list">Добавить в избранное</button>
                            </form>
                            </div>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <div class="synopsis">
            <h2>Вкратце о книге</h2>
            <p><?=$item['item_description']?></p>
        </div>
        <?php }?>
        <br>
        <h2 style="font-size: 1.7rem;"><i>Вам также может быть интересно</i></h2>
    </main>
    <?php
        $results = $pdo->query("SELECT * FROM products WHERE item_sold > 100");
        $resultArray = array();
        while($item = $results->fetch(PDO::FETCH_ASSOC)){
            $resultArray[] = $item;
            echo "\n";
        }
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
                                        <button type="submit" class="buy-btn">ДОБАВИТЬ В КОРЗИНУКУ</button>
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



    <section class="slider" id="product-best-fantasy">
            <div class="books-container">
                <h2>Лучшие книги в категории фэнтези</h2>
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
                                        <button type="submit" class="buy-btn">ДОБАВИТЬ В КОРЗИНУКУ</button>
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
<script src="script.js">

</script>

</body>
</html>