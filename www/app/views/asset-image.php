<?php
// generate the thumbs for this image
    generate_thumbs($asset_info["path"]);
?>
<a href="<?php echo $asset_info["url"]; ?>" class="view-album__asset-link js-lightbox-trigger">
    <figure class="view-album__asset album__asset--figure">
        <?php echo responsive_img_markup($asset_info["path"]) ?>
    </figure>
</a>
