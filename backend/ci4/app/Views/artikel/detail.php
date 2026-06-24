<?= $this->include('template/header'); ?> 

<article class="entry">
    <h2><?= esc($artikel['judul']); ?></h2>

    <p>
        <b>Kategori:</b> <?= esc($artikel['nama_kategori'] ?? 'Tidak ada'); ?>
    </p>

    <img 
        src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" 
        alt="<?= esc($artikel['judul']); ?>"
    >

    <p><?= esc($artikel['isi']); ?></p>
</article>

<?= $this->include('template/footer'); ?>