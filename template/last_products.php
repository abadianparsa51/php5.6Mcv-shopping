<div class="content-header col-lg-12">
    <span class="text-center" style="font-size: 15px;">
<b>
        آخرین خبر ها
</b>
    </span>
</div>
<div class="clearfix"></div>
<div class="content-box">
    <?php
    $resultSpecial = $main->getLastProducts(8);
        while($specialRows = $main->getRow($resultSpecial))
        {
            $urlProduct = $main->getBaseUrl().'product/'."$specialRows[id]/".$main->createSeoUrl($specialRows['title_en']);
            ?>
            <div class="col-sm-4 colmd4 text-center">
                <a href="<?php print $urlProduct; ?>" target="_blank">
                    <img class="img-responsive" src="<?php echo str_replace('../','',$specialRows['thumb_image']); ?>"
                         alt="<?php echo $specialRows['title_fa'] ?>" title="<?php echo $specialRows['title_fa'] ?>" style="width: 100%; margin-top: 15px; margin-bottom: 10px; "></a>

                <a href="<?php print $urlProduct; ?>" target="_blank"  >
                    <?php echo $specialRows['title_fa'] ?>
                </a>
                <p class="product-description">
                    <?php echo $specialRows['short_content'] ?>
                </p>
            </div>
            <?php
        }
    ?>
</div>