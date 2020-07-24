<div class="view-album view">
    <?php
        $album_title = extract_title($album_name, $album_date_format, $output_date_format);
        $album_date = extract_date($album_name, $album_date_format, $output_date_format);
        $album_assets = get_album_assets($albums_path . '/' . $album_name);
    ?>

    <header class="view-album__header">
        <p class="view-album__back"><a class="view-album__back-link" href="<?php echo $root_url; ?>">Back to albums</a></p>
        <h1 class="view-album__title"><?php echo $album_title; ?></h1>
        <h2 class="view-album__date"><?php echo $album_date; ?></h2>
    </header>

    <section class="view-album__content">
        <?php
        $item_count = sizeof($album_assets);
        $i = 1;
        foreach ($album_assets as $asset_path) :
            $first = $i == 1;
            $last = $item_count - $i == 0;
            $asset_ext = strtolower(pathinfo($asset_path, PATHINFO_EXTENSION));
            $file_type = get_file_type($asset_ext);
            ?>
            <?php if ($file_type) : ?>
                <?php if ($first && in_array($file_type, array('image', 'video'))) : ?>
                    <section class="view-album__grid">
                <?php endif; ?>

                <?php
                if ($file_type === 'video') : ?>
                    <div class="view-album__item view-album__item--<?php echo $file_type; ?>">
                        <?php include 'asset-video.php'; ?>
                    </div>
                <?php elseif ($file_type === 'image') : ?>
                    <div class="view-album__item view-album__item--<?php echo $file_type; ?>">
                        <?php include 'asset-image.php'; ?>
                    </div>
                <?php elseif ($file_type === 'text') : ?>
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
            <!-- Error, unrecognized file extension: <?php echo $asset_path; ?> -->
            <?php endif; ?>
            <?php $i = $i+1; ?>
        <?php endforeach; ?>
    </section>

</div>
