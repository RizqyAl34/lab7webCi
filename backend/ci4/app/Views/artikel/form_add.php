<?= $this->include('template/admin_header'); ?>

<h2>Tambah Artikel</h2>

<?php if(isset($validation) && $validation !== null): ?>
    <div style="color:red; margin-bottom:10px;">
        <?= $validation->listErrors(); ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/artikel/add'); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <p>
        <label>Judul</label><br>
        <input type="text" name="judul" value="<?= old('judul'); ?>">
    </p>

    <p>
        <label>Isi</label><br>
        <textarea name="isi" rows="10" cols="50"><?= old('isi'); ?></textarea>
    </p>

    <p>
        <label>Kategori</label><br>
        <select name="id_kategori">
            <option value="">-- Pilih Kategori --</option>
            <?php foreach($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>">
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label>Gambar</label><br>
        <input type="file" name="gambar" accept="image/*">
    </p>

    <p>
        <button type="submit" class="btn btn-primary">Kirim</button>
    </p>

</form>

<?= $this->include('template/admin_footer'); ?>