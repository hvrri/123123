<?php
$page_title = "Nollaa salasana";
include_once 'partials/headers.php';
include_once 'partials/parsePasswordReset.php';
?>

<div class="container">
    <section class="col col-lg-7">
        <h2>Password Recovery</h2><hr>
        
        <div>
            <?php if(isset($result)) echo $result; ?>
            <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>
        <div class="clearfix"></div>

        Lähetä uusi salasana sähköpostitse <br /><br />
        <form action="" method="post">
            <div class="form-group">
                <label for="emailField">Sähköposti</label>
                <input type="text" class="form-control" name="email" id="emailField" placeholder="email">
            </div>
            <input type="hidden" name="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
            <button type="submit" name="passwordRecoveryBtn" class="btn btn-primary pull-right">
                Lähetä
            </button>
        </form>
    </section>
</div>

<?php include_once 'partials/footers.php'; ?>
</body>
</html>