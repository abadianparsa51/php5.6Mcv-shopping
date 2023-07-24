
<div class="content-header col-sm-12 col-md-12 col-xs-12">
    <b>
    <span  style="font-size: 15px;">
        سر خط خبرها
    </span>
    </b>
</div>
<div class="clearfix"></div>
<div class="content-box">
    <?php
    $resultSpecial = $main->getSpecialProducts(2);
        while($specialRows = $main->getRow($resultSpecial))
        {
            $urlProduct = $main->getBaseUrl().'product/'."$specialRows[id]/".$main->createSeoUrl($specialRows['title_en']);
            ?>
            <div class="col-sm-6   text-center">
                <a href="<?php print $urlProduct; ?>" target="_blank">
				<img class="img-responsive" src="<?php echo str_replace('../','',$specialRows['thumb_image']); ?>"
                     alt="<?php echo $specialRows['title_fa'] ?>" title="<?php echo $specialRows['title_fa'] ?>" style="width: 100%; margin-bottom: 10px;margin-top: 20px; "></a>
                <a href="<?php print $urlProduct; ?>" target="_blank" >
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