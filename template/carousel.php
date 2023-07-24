<?php
    $rSlider1 = $main->getSliderList();
    $rSlider2 = $main->getSliderList();
?>
<div id="home-slider" class="carousel slide" data-ride="carousel" id="myCarousel">
    <ol class="carousel-indicators">
        <?php
            $iSlider = 0;
            while($slider1 = $main->getRow($rSlider1))
            {
                $active = ($iSlider == 0) ? 'active' : '';
                ?>
                <li data-target="#home-slider" class="<?php print $active; ?>" data-slide-to="<?php print $slider1['id']; ?>"></li>
                <?php
                $iSlider++;
            }
        ?>
    </ol>

    <div class="carousel-inner" role="listbox">
        <?php
        $iSlider = 0;
        while($slider2 = $main->getRow($rSlider2))
        {
            $active = ($iSlider == 0) ? 'active' : '';
        ?>
        <div class="item <?php print $active; ?>">
            <a href="<?php print $slider2['link']; ?>" target="_blank">
                <img src="<?php echo str_replace('../','',$slider2['img']); ?>" alt="<?php print $slider2['title']; ?>">
            </a>
            <div class="carousel-caption">
                <?php print $slider2['title']; ?>
            </div>
        </div>
            <?php
            $iSlider++;
        }
        ?>
    </div>

    <a class="left carousel-control" href="#home-slider" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#home-slider" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
