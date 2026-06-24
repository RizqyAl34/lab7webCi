<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('styles.css');?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Layout Sederhana</h1>
        </header>
        <nav class="navbar">
            <a href="<?= base_url('/admin/artikel'); ?>" class="active">Dashboard</a>
            <a href="<?= base_url('/admin/artikel'); ?>">Artikel</a>
            <a href="<?= base_url('/admin/artikel/add'); ?>">Tambah Artikel</a>
        </nav>
<section id="wrapper">
<section id="main">