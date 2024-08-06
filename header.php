<header class="header">

            <div class="header-1">

                <div class="logotype flex-item"><a href="index.php" class="logo"><i class="fas fa-book"></i> librarium</a></div>

                <form action="" class="search-form">
                    <div class="flex-item">
                        <input type="search" name="" id="search-box" placeholder="Название, автор, ключевое слово...">
                        <label for="search-box" class="fas fa-search" id="search-icon"></label>
                    </div>
                </form>             


                    <div class="header-1-buttons-wrapper">
                        <a href="<?php echo(isset($_COOKIE['logIn']) && isset($_COOKIE['passWord']))? 'wish_list.php' : 'sign_in.php'?>" class="fas fa-heart"></a>
                        <a href="<?php echo(isset($_COOKIE['logIn']) && isset($_COOKIE['passWord']))? 'shopping_cart.php' : 'sign_in.php'?>" class="fas fa-shopping-cart"></a>
                        <a href="<?php echo(isset($_COOKIE['logIn']) && isset($_COOKIE['passWord']))? 'account.php' : 'sign_in.php'?>" id="login-button" class="fas fa-user"></a>
                    </div>
                </div>
            </div>
            <div class="header-2">
                <nav class="navbar">
                    <ul id="navbar">
                        <li class="navbar-item"><a href="index.php">Главная</a></li>
                        <li class="navbar-item"><a href="#categories" id="nav_categories" style="cursor:default;">Разделы</a> <!-- DROP-DOWN MENU -->
                            <div class="drop-down categories" id="drop-down categories">
                                <ul>
                                    <li><a href="grid_page.php">Классика</a></li>
                                    <li><a href="grid_page.php">Детектив</a></li>
                                    <li><a href="grid_page.php">Фэнтези</a></li>
                                    <li><a href="grid_page.php">Фантастика</a></li>
                                    <li><a href="grid_page.php">Экономика</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="navbar-item"><a href="contacts.php">Контакты</a></li>
                    </ul>
                </nav>
            </div>
</header>