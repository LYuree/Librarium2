<?php

require("db_connection.php");
$dsn = "mysql:host=localhost;port=3306;dbname=librarium;charset=utf8";
//dsn stands for data source name
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
$username = $_COOKIE['logIn'];
if(!empty($_POST)){
    if(isset($_POST['checkout'])){
        $_POST['amount'] = null;
    }
   
    if (isset($_POST['amount'])){
        $amountID = $_POST['changeNum'];
        $amount = $_POST['amount'];
        $pdo->query("UPDATE cart SET amount = $amount WHERE item_id=$amountID");
    }
    else if(isset($_POST['checkout'])){
        try {
            $pdo->query("INSERT INTO orders (user_login) VALUES ('$username')");
            $IDs = $pdo->query("SELECT id FROM orders ORDER BY id DESC LIMIT 1");
            $IDrow = $IDs->fetch(PDO::FETCH_ASSOC);
            $orderID = $IDrow['id'];
            $results = $pdo->query("SELECT item_id, amount FROM cart WHERE user_login = '$username'");
            $cartArray = array();

            while($row = $results -> fetch(PDO::FETCH_NUM)) {
                $id = $row[0];
                $amount = $row[1];
                $pdo->query("INSERT INTO ordered_items (order_id, item_id, amount) VALUES ($orderID, $id, $amount)");
            }
            $pdo->query("DELETE FROM cart WHERE user_login = '$username'");
            // echo "The order has been processed. Happy upcoming New Year!";
        }
        catch (PDOException $e) {
            $pdo = null;
            echo 'Не виконаний метод fetch(): ' . $e->getMessage(); 
            exit;
        }

    }
    else if(isset($_POST['remove'])){
        $removalID = $_POST['remove'];
        $pdo->query("DELETE FROM cart WHERE user_login = '$username' AND item_id = '$removalID' ");
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
    <title> Корзина | Librarium </title>
</head>
<body>


<?php
include('header.php');
?>

<div id="cart-container">
        <h1>Ваша корзина (<?php echo (isset($_COOKIE['logIn']) ? $_COOKIE['logIn']: 'Unknown user')?>)</h1>
        
        <?php

        try {
            $results = $pdo->query("SELECT item_id, amount FROM cart WHERE user_login = '$username'");
            $cartArray = array();

            while($item = $results->fetch(PDO::FETCH_ASSOC)){
                $cartArray[] = $item;
            }
            $itemsArray = array();
            foreach($cartArray as $id){
                $itemID = $id['item_id'];
                $results = $pdo->query("SELECT * FROM products WHERE item_id = $itemID");
                echo "\n";
                $itemsArray[] = $results->fetch(PDO::FETCH_ASSOC);
                $grandTotal = 0; //sum to be payed for the order
            }


        }
        catch(PDOEexception $e){
            echo "Ошибка выполнения операции: ". $e->getMessage();
        }
        ?>

        <form class="check-out form" action="shopping_cart.php" method="post">
            <div class="books-container">
                <?php $i = 0; foreach($itemsArray as $item){ ?>
                    <div class="cart-row">
                        <div class="items-section">
                            <div class="img-container">
                            <a class="wish-cart-link" href="product.php?item_id=<?=$item['item_id']?>"><img src="<?php echo $item['item_image']?>" alt=""></a>
                            </div>
                            <div class="product-info">
                                <a class="wish-cart-link" href="product.php?item_id=<?=$item['item_id']?>"><h3 class="book-title"><?php echo $item['item_name']?? 'Unknown'?></h3></a>
                                <h4><?php echo $item['item_author']?? 'Unknown'?></h4>
                                <h3 class="item-price"><s><?php if(isset($item['item_oldprice'])) echo $item['item_oldprice']." UAH"?></s>&nbsp&nbsp<?php echo $item['item_price']?> UAH</h3>
                                <h4 class="back-type"><?php echo $item['item_backtype'] ?> обложка</h3>
                                
                                <form action="" id="bait"></form>
                

                                <form class="cart-amount-form" id="amountForm" action="shopping_cart.php" method="post">
                                    <input type="hidden" name="changeNum" value="<?=$item['item_id']?>">
                                    <input class="cart-item-amount" name="amount" type="number" value="<?= $cartArray[$i]['amount']?>" max="999">
                                    <br>
                                    <button>Обновить количество</button>
                                </form>

                                <form class="cart-removal-form" id="removalForm" action="shopping_cart.php" method="post">
                                    <input type="hidden" name="remove" value="<?=$item['item_id']?>">
                                    <button>Удалить из корзины</button>
                                </form>
                            </div>
                        </div>
                </div>
                <?php $grandTotal += $item['item_price']*$cartArray[$i]['amount']; $i++;} ?>

                <div class="subtotal-section">
                    <h2>
                        <span><?php if(isset($grandTotal)) echo "К ОПЛАТЕ:"?></span> <span style="color: rgb(219, 179, 0); !important"><?php if(isset($grandTotal)) echo $grandTotal." UAH"; else echo "Корзина пуста. <a href='index.php'>Вернуться на главную?</a>";?></span>
                    </h2>
                </div>

                <input type="hidden" name="checkout" value="checkout">
                <div class="center container">
                    <button id="proceed-to-buy-btn">ОФОРМИТЬ ЗАКАЗ</button>
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