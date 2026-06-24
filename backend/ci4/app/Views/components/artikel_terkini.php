<div class="widget-box">
    <h3 class="title">Artikel Terkini</h3>

    <?php foreach ($grouped as $kategori => $items): ?>
        
        <h4><?= esc($kategori); ?></h4>
        <ul>
            <?php foreach ($items as $row): ?>
                <li>
                    <a href="<?= base_url('/artikel/' . $row['slug']) ?>">
                        <?= esc($row['judul']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endforeach; ?>

</div>