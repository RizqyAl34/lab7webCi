<ul class="pagination-custom">
    <?php foreach ($pager->links() as $link) : ?>
        <li class="<?= $link['active'] ? 'active' : '' ?>">
            <a href="<?= $link['uri'] ?>">
                <?= $link['title'] ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>