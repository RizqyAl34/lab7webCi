<?= $this->include('template/admin_header'); ?>

<h2><?= esc($title); ?></h2>

<!-- ======================
     SEARCH + FILTER + SORT
====================== -->

<form id="search-form" class="admin-search">

```
<input 
    type="text" 
    id="search-box"
    placeholder="Cari artikel..."
    class="search-input"
>

<select id="category-filter" class="search-select">
    <option value="">Semua Kategori</option>
    <?php foreach ($kategori as $k): ?>
        <option value="<?= $k['id_kategori']; ?>">
            <?= esc($k['nama_kategori']); ?>
        </option>
    <?php endforeach; ?>
</select>

<select id="sort" class="search-select">
    <option value="id">Urut ID</option>
    <option value="judul">Urut Judul</option>
</select>

<button type="submit" class="btn search-btn">Cari</button>
```

</form>

<!-- ======================
     LOADING INDICATOR
====================== -->

<div id="loading" style="display:none; padding:10px; background:#eee; margin:10px 10px 10px 0;">
    Loading data...
</div>

<!-- ======================
     DATA TABLE
====================== -->

<div id="artikel-container"></div>

<!-- ======================
     PAGINATION
====================== -->

<div id="pagination-container"></div>

<!-- ======================
     JQUERY CDN
====================== -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function(){

    // ======================
    // FETCH DATA (AJAX)
    // ======================
    function fetchData(url = "<?= base_url('admin/artikel') ?>") {

        $('#loading').show();

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },

            success: function(res){

                console.log("DATA:", res.artikel);
                console.log("PAGER:", res.pager);

                renderTable(res.artikel);
                renderPagination(res.pager);

                $('#loading').hide();
            },

            error: function(xhr){
                console.log(xhr.responseText);
                $('#loading').hide();
                alert('Gagal mengambil data');
            }
        });
    }

    // ======================
    // RENDER TABLE
    // ======================
    function renderTable(data){

        let html = `
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
        `;

        if(data.length > 0){

            data.forEach(row => {

                html += `
                <tr id="row-${row.id}">
                    <td>${row.id}</td>

                    <td>
                        <img 
                            src="<?= base_url('gambar') ?>/${row.gambar}" 
                            width="80" 
                            height="60"
                            style="object-fit:cover; border-radius:5px;"
                        >
                    </td>

                    <td>
                        <b>${row.judul}</b>
                        <p><small>${row.isi.substring(0,50)}...</small></p>
                    </td>

                    <td>${row.nama_kategori}</td>
                    <td>${row.status}</td>

                    <td>
                        <a class="btn" href="<?= base_url('admin/artikel/edit') ?>/${row.id}">
                            Ubah
                        </a>

                        <button 
                            class="btn btn-danger btn-delete" 
                            data-id="${row.id}">
                            Hapus
                        </button>
                    </td>
                </tr>
                `;
            });

        } else {
            html += `<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>`;
        }

        html += `</tbody></table>`;

        $('#artikel-container').html(html);
    }

    // ======================
    // RENDER PAGINATION
    // ======================
    function renderPagination(pager){

        $('#pagination-container').html(pager);

      $(document).on('click', '#pagination-container a', function(e){

        e.preventDefault();

        let url = $(this).attr('href');

        console.log("URL PAGINATION:", url); // 🔥 WAJIB

        if (!url) {
            alert('URL kosong bro!');
            return;
        }

        fetchData(url);
    });
    }

    // ======================
    // SEARCH + FILTER + SORT
    // ======================
    $('#search-form').submit(function(e){

        e.preventDefault();

        let q = $('#search-box').val();
        let kategori = $('#category-filter').val();
        let sort = $('#sort').val();

        let url = "<?= base_url('admin/artikel') ?>?q=" + q +
                  "&kategori_id=" + kategori +
                  "&sort=" + sort;

        fetchData(url);
    });

    // AUTO FILTER
    $('#category-filter').change(function(){
        $('#search-form').submit();
    });

    // ======================
    // DELETE AJAX
    // ======================
    $(document).on('click', '.btn-delete', function(){

        let id = $(this).data('id');

        if (!confirm('Yakin menghapus data?')) return;

        $.ajax({
            url: "<?= base_url('ajax/delete/') ?>" + id,
            type: "POST",
            data: { _method: "DELETE" },

            success: function(){
                $('#row-' + id).fadeOut(300, function(){
                    $(this).remove();
                });
            },

            error: function(){
                alert('Gagal menghapus data');
            }
        });
    });


    // ======================
    // PAGINATION CLICK
    // ======================
    $(document).on('click', '#pagination-container a', function(e){

        e.preventDefault();

        let url = $(this).attr('href');

        console.log("URL PAGINATION:", url);

        if (!url) {
            alert('URL kosong bro!');
            return;
        }

        fetchData(url);
    });
    
    fetchData();

});
</script>

<?= $this->include('template/admin_footer'); ?>
