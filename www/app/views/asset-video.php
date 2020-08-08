<?php
    generate_video($asset_path);
?>
<a href="<?php echo video_src($asset_path); ?>" class="view-album__asset-link js-lightbox-trigger">
    <div class="view-album__asset view-album__asset--video">
        <video class="view-album__video" autoplay loop muted playsinline>
            <source src="<?php echo video_src($asset_path); ?>" />
        </video>
    </div>
</a>
