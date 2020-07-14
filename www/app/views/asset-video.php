<?php
?>
<a href="<?php echo $asset_path; ?>" class="view-album__asset-link js-lightbox-trigger">
    <div class="view-album__asset view-album__asset--video">
        <video class="view-album__video" autoplay loop muted playsinline>
            <source  src="<?php echo $asset_path; ?>" />
        </video>
    </div>
</a>
