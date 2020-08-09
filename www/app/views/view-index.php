<?php
?>
<div class="view-index view">
    <h1 class="view-index__title">Albums<h1>
    <ul class="view-index__list">
    <?php
    $albums = get_albums(ALBUMS_PATH);


    foreach ($albums as $album) :
        $album_path = str_replace('/', '', str_replace('.', '', $album));
        $album_title = extract_title($album_path, ALBUM_DATE_FORMAT, OUTPUT_DATE_FORMAT);
        $album_date = extract_date($album_path, ALBUM_DATE_FORMAT, OUTPUT_DATE_FORMAT);
        ?>

        <li class="view-index__item">
            <a class="view-index__item-link" href="?a=<?php echo $album_path;?>">
                <span class="view-index__album-title"><?php echo $album_title; ?></span>
                <span class="view-index__album-date"><?php echo $album_date; ?></span>
            </a>
        </li>

    <?php endforeach; ?>
    </ul>
</div>
