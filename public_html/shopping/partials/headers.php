<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';
include_once 'resource/utilities.php';
?>

<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php if (isset($page_title)) echo $page_title; ?></title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <script src="js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
</head>

<body>
<!-- navbar --> 
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Oppipuoti</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav"><i class="hide"><?php echo guard(); ?></i>
                    <li><a href="index.php">Koti</a></li>
                    <!-- jos username on set niin näyttää sivuja joita haluan vain kirjautuneiden näkevän --> 
                    <?php if ((isset($_SESSION['username']) || isCookieValid($db))) : ?>
                        <li><a href="profile.php">Profiili</a></li>
                        <li><a href="members.php">Käyttäjät</a></li>
                        <li><a href="cart.php">Ostoskori
                                <?php
                                if (isset($_SESSION['cart'])) {
                                    $count = count($_SESSION['cart']);
                                    echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$count</span>";
                                } else {
                                    echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
                                }
                                ?>
                            </a>
                        <li>
                        <li><a><?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?></a></li>
                        <li><a href="logout.php">Kirjaudu ulos</a></li>
                    <?php else : ?>
                    <!-- Sivut jotka näkee jos ei ole kirjautunut --> 
                        <li><a href="members.php">Käyttäjät</a></li>
                        <li><a href="signup.php">Rekisteröidy</a></li>
                        <li><a href="login.php">Kirjaudu sisään</a></li>
                    <?php endif ?>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>