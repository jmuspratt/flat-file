<?php
// generate the thumbs for this image
    generate_thumbs($asset_path, $thumb_sizes);
?>
<a href="<?php echo $asset_path; ?>" class="view-album__asset-link js-lightbox-trigger">
    <figure class="view-album__asset album__asset--figure">
        <?php echo responsive_img_markup($asset_path, $thumb_sizes) ?>
    </figure>
</a>
