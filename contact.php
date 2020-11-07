<?php
require('inc/functions.php');
require('inc/pdo.php');

$errors = [];
$sent = false;
if (!empty($_POST['submit'])) {
    $mail = checkXss($_POST['mail']);
    $message = checkXss($_POST['message']);

    $errors = checkEmail($errors, $mail, 'mail');
    $errors = checkField($errors, $mail, 'mail', 6, 150);
    $errors = checkField($errors, $message, 'message', 5, 2000);

    if (count($errors) == 0) {
        insert($pdo, 'sfr_contact', ['email', 'message', 'created_at'], [$mail, $message, now()]);
        $sent = true;
    }
}


$title = 'Contact | SFR - Espace Buisness';
include('inc/header.php');
?>
<section id="banner">
    <div class="wrap">
        <div class="square">
            <h1>Les offres<br>par région</h1>
        </div>
    </div>
</section>
<section id="contact">
    <div class="wrap-solid">
        <form action="" method="post">
            <?php if ($sent == false) : ?>
                <input type="email" name="mail" placeholder="Votre mail">
                <div class="error"><?= (!empty($errors['mail'])) ? $errors['mail'] : '' ?></div>
                <textarea name="message" id="" placeholder="Votre message"></textarea>
                <div class="error"><?= (!empty($errors['message'])) ? $errors['message'] : '' ?></div>
                <input type="submit" name="submit" value="Envoyer">
            <?php else : ?>
                <div class="sent">Le message à été envoyé avec succès.</div>
            <?php endif; ?>
        </form>
    </div>
</section>
<?php
include('inc/footer.php');
