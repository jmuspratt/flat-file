<div class="view-album">
<?php
// output album assets
    $album_title = extract_album_title($album, $file_date_format, $date_output_format);
    $album_date = extract_album_date($album, $file_date_format, $date_output_format);

    $album_assets = get_album_assets($albums_path . '/' . $album);

    ?>

    <h1 class="view-album__title"><?php echo $album_title; ?></h1>
    <h2 class="view-album__date"><?php echo $album_date; ?></h2>


    <ul class="album__list">
    <?php
    foreach ( $album_assets as $asset )  :
        $asset_path =  $asset;
        $asset_ext = strtolower(pathinfo($asset_path, PATHINFO_EXTENSION));

        ?>
    <li class="album__item">
        <a href="<?php echo $asset_path; ?>" class="album__asset-link js-lightbox-trigger">
        <?php if (in_array($asset_ext, ['mp4', 'mov', 'ogv'])) : ?>
            <div class="album__asset album__asset--video">
                <video class="album__video" autoplay loop muted playsinline>
                    <source  src="<?php echo $asset_path; ?>" />
                </video>
            </div>
            <?php
                else :
                    // generate the thumbs for this image
                    generate_thumbs($asset_path, $thumb_sizes);
            ?>
                <figure class="album__asset album__asset--figure">
                    <?php echo responsive_img_markup($asset_path, $thumb_sizes) ?>
                </figure>
        <?php endif; ?>
        </a>
    </li>

<?php endforeach; ?>

</div>
