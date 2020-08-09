<?php
    $title = extract_title(pathinfo($asset_path)['filename'], FILE_DATE_FORMAT);
    $contents = get_file_contents($asset_path);
?>

<div class="title-card">
    <?php if ($title) : ?>
        <div class="title-card__head">
            <?php echo $title; ?>
        </div>
    <?php endif; ?>

        <?php if ($contents) : ?>
        <div class="title-card__contents">
            <?php echo $contents; ?>
        </div>
        <?php endif; ?>
    </div>
