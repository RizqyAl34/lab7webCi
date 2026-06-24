<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('styles.css'); ?>">
</head>
<body>

<?= $this->include('template/header.php'); ?>

<h1><?= esc($title); ?></h1>
<hr>
<p><?= esc($content); ?></p>

<?= $this->include('template/footer.php'); ?>

</body>
</html>