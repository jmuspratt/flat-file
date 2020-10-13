<?php
    generate_video($asset_info["path"]);
?>
<a href="<?php echo video_src($asset_info["path"]); ?>" class="view-album__asset-link js-lightbox-trigger">
    <div class="view-album__asset view-album__asset--video">
        <video class="view-album__video" autoplay loop muted playsinline>
            <source src="<?php echo video_src($asset_info["path"]); ?>" />
        </video>
    </div>
</a>
