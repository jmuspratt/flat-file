<?php
?>
<div class="view-index view">
    <h1 class="view-index__title">Albums<h1>
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
</div>
