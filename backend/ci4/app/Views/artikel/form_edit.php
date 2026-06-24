<?= $this->include('template/admin_header'); ?>

<h2><?= esc($title); ?></h2>

<form 
    id="formEdit"
    method="post" 
    enctype="multipart/form-data"
>

    <input 
        type="hidden" 
        name="id" 
        value="<?= $artikel['id']; ?>"
    >

    <p>
        <label for="judul">Judul</label><br>

        <input 
            type="text"
            name="judul"
            id="judul"
            value="<?= esc($artikel['judul']); ?>"
            required
        >
    </p>

    <p>
        <label for="isi">Isi</label><br>

        <textarea
            name="isi"
            id="isi"
            cols="50"
            rows="10"><?= esc($artikel['isi']); ?></textarea>
    </p>

    <p>
        <label for="id_kategori">Kategori</label><br>

        <select 
            name="id_kategori" 
            id="id_kategori" 
            required
        >

            <?php foreach ($kategori as $k): ?>

                <option 
                    value="<?= $k['id_kategori']; ?>"
                    <?= ($artikel['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>
                >

                    <?= esc($k['nama_kategori']); ?>

                </option>

            <?php endforeach; ?>

        </select>
    </p>

    <p>
        <label>Gambar Lama</label><br>

        <?php if (!empty($artikel['gambar'])): ?>

            <img 
                src="<?= base_url('gambar/' . $artikel['gambar']); ?>" 
                width="150"
            >

        <?php else: ?>

            Tidak ada gambar

        <?php endif; ?>

    </p>

    <p>
        <label>Ganti Gambar</label><br>

        <input 
            type="file" 
            name="gambar"
        >
    </p>

    <p>
        <input 
            type="submit" 
            value="Update" 
            class="btn btn-large"
        >
    </p>

</form>

<script src="<?= base_url('assets/js/jquery-4.0.0.min.js') ?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#formEdit').submit(function(e){

    e.preventDefault();

    let id = $('input[name="id"]').val();
    let formData = new FormData(this);

    $.ajax({
        url: "<?= base_url('ajax/update/') ?>" + id,
        type: "POST",
        data: formData,

        processData: false,
        contentType: false,

        success: function(res){
            alert('Artikel berhasil diupdate');
            window.location.href = "<?= base_url('admin/artikel') ?>";
        },

        error: function(xhr){
            console.log(xhr.responseText);
            alert('Gagal update artikel');
        }
    });

});
</script>

<?= $this->include('template/admin_footer'); ?>