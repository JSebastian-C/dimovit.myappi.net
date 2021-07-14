<?php global $global_devide_item; ?>
<div class="ia-iphone-x ias-devide <?php echo @$global_devide_item['devide_color_iphonex']?$global_devide_item['devide_color_iphonex']:''; echo @$global_devide_item['orientation']?' landscape':''; ?>">
    <div class="device">
        <div class="notch">
            <div class="camera"></div>
            <div class="speaker"></div>
        </div>
        <div class="top-bar"></div>
        <div class="sleep"></div>
        <div class="bottom-bar"></div>
        <div class="volume"></div>
        <div class="overflow">
            <div class="shadow shadow--tr"></div>
            <div class="shadow shadow--tl"></div>
            <div class="shadow shadow--br"></div>
            <div class="shadow shadow--bl"></div>
        </div>
        <div class="inner-shadow"></div>
        <div class="screen">
            <?php echo iAppShowcase::ias_devide_content($global_devide_item); ?>
        </div>
    </div>
</div>