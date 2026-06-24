<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('login.css'); ?>">
</head>
<body>

<div id="container">
    <div id="login-wrapper">
        <h1>Sign In</h1>

        <?php if(session()->getFlashdata('flash_msg')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('flash_msg') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">

            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control"
                   id="email" value="<?= set_value('email') ?>">

            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control"
                   id="password">

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</div>

</body>
</html>         