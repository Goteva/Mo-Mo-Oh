<?php $app = App::getInstance(); ?>

<div class="py-3">
    <div class="container">

        <?php if ($errors) : ?>
            <div class="alert alert-danger">
                Identifiants invalide
            </div>
        <?php endif; ?>

        <form method="post">
            <?= $form->input('users_login', 'Login'); ?>
            <?= $form->input('users_password', 'Password', ['type' => 'password']); ?>
            <button class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</div>