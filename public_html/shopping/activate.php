
<?php
$page_title = "";
include_once 'partials/headers.php';
include_once 'partials/parseSignup.php';
?>

<div class="container">
    <div class="flag">
        <h1>Oppipuoti</h1>
        <?php if(isset($result)) echo $result; ?>
    </div>
</div>

<?php include_once 'partials/footers.php'; ?>
</body>
</html>