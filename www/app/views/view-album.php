<div class="view-album view">
    <?php
        // Use album_id (set in index.php) to fetch album_info and assets
        $album_info = get_album_info_from_id($album_id);
        $album_assets = get_album_assets($album_info["path"]);

        // Get all albums' info for dropdown
        $all_albums = get_albums(ALBUMS_PATH);
        // Store position of the active album in all_albums;
        $current_index = array_search($album_info, $all_albums);

    ?>

    <header class="page-header">
        <h1 class="page-header___site-name">
            <a class="page-header___site-name-link" href="<?php echo ROOT_URL; ?>">
                <?php echo SITE_NAME; ?>
            </a>
        </h1>
        <div class="view-album__dropdown">
            <ul class="view-album__dropdown-list view-album__dropdown-list--current-<?php echo $current_index; ?>" data-current="<?php echo $current_index; ?>">
            <?php foreach ($all_albums as $album_item) :
                $is_current_album = $album_item["id"] == $album_info['id'];
                $item_class = "view-album__dropdown-item";

                if ($is_current_album) :
                    $item_class .= ' view-album__dropdown-item--current' ;
                endif;
                ?>
                <li class="<?php echo $item_class; ?>">
                    <a class="view-album__dropdown-link" href="<?php echo $album_item["url"]; ?>">
                        <?php echo $album_item["display_title"]; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
    </header>

    <section class="page-content">
        <?php
        $item_count = sizeof($album_assets);
        $i = 1;
        foreach ($album_assets as $asset_info) :
            $first = $i == 1;
            $last = $item_count - $i == 0;
            ?>
            <?php if ($asset_info["file_type"]) : ?>
                <?php if ($first && in_array($asset_info["file_type"], array('image', 'video'))) : ?>
                    <section class="view-album__grid">
                <?php endif; ?>

                <?php
                if ($asset_info["file_type"] === 'video') : ?>
                    <div class="view-album__item view-album__item--<?php echo $asset_info['file_type']; ?>">
                        <?php include 'asset-video.php'; ?>
                    </div>
                <?php elseif ($asset_info["file_type"] === 'image') : ?>
                    <div class="view-album__item view-album__item--<?php echo $asset_info['file_type']; ?>">
                        <?php include 'asset-image.php'; ?>
                    </div>
                <?php elseif ($asset_info["file_type"] === 'text') : ?>
                    <?php if (! $first) : ?>
                    </section> <!-- grid -->
                    <?php endif; ?>
                    <header class="view-album__section-heading">
                        <?php include 'asset-text.php'; ?>
                    </header>
                    <?php if (! $last) : ?>
                    <section class="view-album__grid">
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($last) : ?>
                    </section> <!-- grid -->
                <?php endif; ?>

            <?php else : ?>
            <!-- Error, unrecognized file: <?php echo $asset_info[$filename]; ?> -->
            <?php endif; ?>
            <?php $i = $i+1; ?>
        <?php endforeach; ?>
    </section>

</div>
