<?php
    generate_video($asset_path, $albums_path_processed);
?>
<a href="<?php echo video_src($asset_path, $albums_path_processed); ?>" class="view-album__asset-link js-lightbox-trigger">
    <div class="view-album__asset view-album__asset--video">
        <video class="view-album__video" autoplay loop muted playsinline>
            <source src="<?php echo video_src($asset_path, $albums_path_processed); ?>" />
        </video>
    </div>
</a>
