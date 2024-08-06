<?php
    require("db_connection.php");
    $username = $_COOKIE['logIn'];

    if(!empty($_POST)){
        if(isset($_POST['remove']) && !empty($_POST['remove'])){
            $removalID = $_POST['remove'];
            $pdo->query("DELETE FROM wishlist WHERE user_login = '$username' AND item_id = '$removalID' ");
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
    <!-- CUSTOM CSS FILE -->
    <link rel="stylesheet" href="style.css" type="text/css">    
    <!-- FA-ICONS -->
    <script src="https://kit.fontawesome.com/e202a65f05.js" crossorigin="anonymous"></script>
    <title>Избранное | Librarium</title>
</head>
<body>


<?php
include('header.php');
?>

<div id="wish-container">
        <h1>Ваш список избранного (<?php echo (isset($_COOKIE['logIn']) ? $_COOKIE['logIn']: 'Unknown user')?>)</h1>
        
        <?php

        try {
            // reating a db connection
            $results = $pdo->query("SELECT item_id FROM wishlist WHERE user_login = '$username'");
            $wishArray = array();

            while($item = $results->fetch(PDO::FETCH_ASSOC)){
                $wishArray[] = $item;
            }
            $itemsArray = array();
            foreach($wishArray as $id){
                $itemID = $id['item_id'];
                $results = $pdo->query("SELECT * FROM products WHERE item_id = $itemID");
                $itemsArray[] = $results->fetch(PDO::FETCH_ASSOC);
            }


        }
        catch(PDOEexception $e){
            echo "Ошибка выполнения операции: ". $e->getMessage();
        }
        ?>

        <form class="check-out form" action="wish_list.php" method="post">
            <div class="books-container">
                <?php $i = 0; foreach($itemsArray as $item){ ?>
                    <div class="cart-row">
                        <div class="items-section">
                            <div class="img-container">
                                <a href="product.php?item_id=<?=$item['item_id']?>"><img src="<?php echo $item['item_image']?>" alt=""></a>
                            </div>
                            <div class="product-info">
                            <a class="wish-cart-link" href="product.php?item_id=<?=$item['item_id']?>"><h3 class="book-title"><?php echo $item['item_name']?? 'Unknown'?></h3></a>
                                <h4><?php echo $item['item_author']?? 'Unknown'?></h4>
                                <h3 class="item-price"><s><?php if(isset($item['item_oldprice'])) echo $item['item_oldprice']." UAH"?></s>&nbsp&nbsp<?php echo $item['item_price']?> РУБ</h3>
                                <h4 class="back-type"><?php echo $item['item_backtype'] ?> обложка</h4>

                                <form class="cart-removal-form" id="removalForm" action="wish_list.php" method="post">
                                    <input type="hidden" name="remove" value="<?=$item['item_id']?>">
                                    <button style="width: 130px;">Удалить</button>
                                </form>
                            </div>
                        </div>
                </div>
                <?php $i++;}?>
            
                <div class="subtotal-section">
                    <h2>
                        <span><?php if($i==0)echo "Список пуст. <a href='index.php'>Вернуться на главную?</a>";?></span>
                    </h2>
                </div>
                
            </div>
        </form>         

</div>

<?php
include('footer.php');
?>

<script src="script.js"></script>
    
</body>
</html>