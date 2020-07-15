<?php
    $contents = get_file_contents($asset_path);
    if ($contents) : ?>
    <div class="view-album__asset view-album__asset--text">
        <div class="title-card">
            <div class="title-card__head">
                <?php echo $contents; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
