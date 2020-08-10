<?php
?>
<div class="view-index view">

    <header class="page-header">
        <h1 class="page-header___site-name">
            <a class="page-header___site-name-link" href="<?php echo ROOT_URL; ?>">
                <?php echo SITE_NAME; ?>
            </a>
        </h1>
    </header>

    <section class="page-content">
    <ul class="view-index__list">
    <?php
    $albums = get_albums(ALBUMS_PATH);
    foreach ($albums as $album) : ?>

        <li class="view-index__item">
            <a class="view-index__item-link" href="?a=<?php echo $album["id"];?>">
                <span class="view-index__album-title"><?php echo $album["display_title"]; ?></span>
                <span class="view-index__album-date"><?php echo $album["display_date"]; ?></span>
            </a>
        </li>

    <?php endforeach; ?>
    </ul>
    </section>
</div>
