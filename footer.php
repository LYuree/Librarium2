<footer>
            <ul>
                <li><h3>Личный кабинет</h3></li>
                <li><a href="<?php echo(isset($_COOKIE['logIn']) && isset($_COOKIE['passWord']))? 'account.php' : 'sign_in.php'?>">Личный кабинет</li>
                <li><a href="<?php echo(isset($_COOKIE['logIn']) && isset($_COOKIE['passWord']))? 'wish_list.php' : 'sign_in.php'?>">Список избранного</a></li>
                <li><a href="<?php echo(isset($_COOKIE['logIn']) && isset($_COOKIE['passWord']))? 'shopping_cart.php' : 'sign_in.php'?>">Корзина</a></li>

            </ul>
            <p>Авторское право © 2024 Lohvinov Yuriy</p>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script src="owlcarousel/owl.carousel.min.js"></script>
            <script integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            <script src="script.js"></script>
</footer>