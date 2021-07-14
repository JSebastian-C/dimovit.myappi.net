<?php global $global_devide_item ?>
<div class="ia-note8 ias-devide <?php echo @$global_devide_item['devide_color_galaxynote8']?$global_devide_item['devide_color_galaxynote8']:'white'; echo @$global_devide_item['orientation']?' landscape':''; ?>">
    <div class="device">
        <div class="inner"></div>
        <div class="overflow">
            <div class="shadow"></div>
        </div>
        <div class="speaker"></div>
        <div class="sensors"></div>
        <div class="more-sensors"></div>
        <div class="sleep"></div>
        <div class="volume"></div>
        <div class="camera"></div>
        <div class="screen">
            <?php echo iAppShowcase::ias_devide_content($global_devide_item); ?>
        </div>
    </div>
</div>