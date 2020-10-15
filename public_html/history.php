<?php
$page_title = "Ostohistoria";
require_once('php/component.php');
include_once 'partials/headers.php';
include_once 'partials/parseHistory.php';
?>

<div class="container">
    <div >
        <h1>Ostohistoria</h1>
            <section class="col col-lg-12">
                <?php if(count($orders) > 0): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="row col-lg-4" style="margin-bottom: 10px;">
                            <div class="media">
                                <div class="media-left">
                                    <a href="public_profile.php?u=<?= $order['username'] ?>">
                                        <img src="<?= $member['avatar'] ?>" class="media-object" style="width:60px">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">Tuote:
                                        <a href="cart.php?u=<?=$order['$productname']?>">
                                            <?= $order['$productimage'] ?>
                                        </a>
                                    </h4>
                                    <p>Liittymispäivämäärä: <?=strftime("%b %d, %Y", strtotime($member['join_date'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <p>Käyttäjiä ei löytynyt</p>
                <?php endif; ?>
            </section>
           </div>
</div>
<?php include_once 'partials/footers.php'; ?>
</body>
</html>