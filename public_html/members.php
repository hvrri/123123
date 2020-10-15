<?php
$page_title = "User Authentication - Members";
include_once 'partials/headers.php';
include_once 'partials/parseMembers.php';
?>

<div class="container">
    <div >
        <h1>Oppipuodin rekisteröityneet jäsenet</h1>
            <section class="col col-lg-12">
                <?php if(count($members) > 0): ?>
                    <?php foreach ($members as $member): ?>
                        <div class="row col-lg-4" style="margin-bottom: 10px;">
                            <div class="media">
                                <div class="media-left">
                                    <a href="public_profile.php?u=<?= $member['username'] ?>">
                                        <img src="<?= $member['avatar'] ?>" class="media-object" style="width:60px">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">Käyttäjä:
                                        <a href="public_profile.php?u=<?=$member['username']?>">
                                            <?= $member['username'] ?>
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