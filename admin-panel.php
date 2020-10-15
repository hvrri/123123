<?php
$page_title = "Admin";
include_once 'partials/headers.php';
require_once('php/CreateDb.php');
require_once('./php/component.php');
include_once 'partials/parseMembers.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <!-- Bootstrap CDN 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    -->
    <link rel="stylesheet" href="style.css">
</head>

<div class="container">
    <div class="flag">
        <h1>Admin</h1>
        <p class="lead">Hallitse oppipuotia<br>
    </div>
    <div class="container">
    <div >
        <h1>Oppipuodin rekisteröityneet jäsenet</h1>
            <section class="col col-lg-12">

                    <?php foreach ($members as $member): ?>
                                    <table>
                                    <tr>
                                        <th><a href="public_profile.php?u=<?= $member['username'] ?>"> </a></th><br>
                                        <th><a href="public_profile.php?u=<?=$member['username']?>"><?= $member['username'] ?> </a></th><br>
                                        <th>

                                        <th>
                                            <form name='delete' action='' method='POST'>
                                                <button name='"deleteBtn" . $member["id"]'>Poista</button>
                                            </form>
                                        </th>
                                            <th>
                                            <input name="<?=$member['username']?>" type="hidden" value="<?=$id = $member['id']?>"> ID On <?= $member['id'] ?></input>
                                            </th>
                                        <br>
                                    </tr>
                                </table>
                    <?php endforeach; ?>
                    <?php
                                        
                                        if (isset($_POST['deleteBtn'])) {
                                            $username = $_POST['username'];
                                            $db->exec("DELETE FROM users WHERE username = $username");
                                        }
                    ?>
            </section>
           </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>