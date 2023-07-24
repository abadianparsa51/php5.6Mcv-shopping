<?php
    require_once 'init.php';
    $product = $main->getProduct($main->get('id'));
    if(!isset($product['id']))
        $main->redirect($main->getBaseUrl());
    $shareUrl = $main->getBaseUrl() . 'product/' . "$product[id]/" . $main->createSeoUrl($product['title_en']);
?>
<!doctype html>
<html lang="en">
<head>
    <base href="<?php print $main->getBaseUrl(); ?>">
    <meta charset="UTF-8">
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php print $product['title_fa']; ?></title>
    <meta name="keywords" content="<?php print $product['meta_keywords']; ?>">
    <meta name="description" content="<?php print $product['meta_description']; ?>">
    <link rel="shortcut icon" href="<?php echo str_replace('../','',$config['favicon']); ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
    <link rel="stylesheet" href="css/lightbox.min.css">
</head>
<body>


    <div class="container-fluid" style="margin-top: 25px;">
        <?php require_once 'template/header.php';?>
    </div>
    <?php require_once 'template/nav.php'; ?>
    <div class="container-fluid">
        <div class="col-sm-2"></div>
        <div class="col-md-8" id="content">
            <div class="row">
            <h1><?php echo $product['title_fa'] ?></h1>
            <h4><?php echo $product['title_en'] ?></h4>
            <div id="share-link">
                <a href="http://www.facebook.com/sharer.php?u=<?php print $shareUrl; ?>" target="_blank">
                    <span class="fa fa-facebook"></span>
                </a>
                &nbsp;
                <a href="http://plus.google.com/share?url=<?php print $shareUrl; ?>" target="_blank">
                    <span class="fa fa-google-plus"></span>
                </a>
                &nbsp;
                <a href="http://www.twitter.com/share?url=<?php print $shareUrl; ?>" target="_blank">
                    <span class="fa fa-twitter"></span>
                </a>
                &nbsp;
                <a href="http://telegram.me/share/?url=<?php print $shareUrl; ?>" target="_blank">
                    <span class="fa fa-telegram"></span>
                </a>
                &nbsp;
                <a href="https://www.linkedin.com/shareArticle?url=<?php print $shareUrl; ?>" target="_blank">
                    <span class="fa fa-linkedin"></span>
                </a>
            </div>

            <br><br>
            <div class="row">
            <div class="col-sm-7">
                <img src="<?php echo str_replace('../','',$product['thumb_image']); ?>"
                     alt="<?php echo $product['title_fa'] ?>" title="<?php echo $product['title_fa'] ?>" style="width: 100%;">
            </div>
            <div class="col-sm-5"></div>
            </div>
                </div>
            <div class="col-sm-2"></div>

            <div class="col-sm-12" style="margin-top:20px;">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#pro-tab1">توضیحات </a></li>
                    <li><a data-toggle="tab" href="#pro-tab2">تصاویر </a></li>
<!--                    <li><a data-toggle="tab" href="#pro-tab3">نظرات کاربران</a></li>-->
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="pro-tab1">
                        <?php
                            $long_content = str_replace('../','',$product['long_content']);
                            print html_entity_decode($long_content,ENT_QUOTES,'UTF-8');
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pro-tab2">

                        <?php
                            $resultImageGallery = $main->getProductImages($product['id']);
                            while ($img = $main->getRow($resultImageGallery))
                            {
                                $img_src = str_replace('../','',$img['img']);
                                ?>
                                <div class="col-sm-3">
                                    <a data-lightbox="roadtrip" data-title="<?php print $img['alt']; ?>"
                                       href="<?php print $img_src; ?>">
                                            <img style="width:70%; margin-top: 20px "
                                                 src="<?php print $img_src; ?>" alt="<?php print $product['alt']; ?>">
                                    </a>
                                </div>
                                <?php
                            }
                        ?>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="pro-tab3">...</div>
                </div>

            </div>
    </div>
        <div class="col-sm-2"></div>
        </div>
    <div class="container-fluid" id="footer">
        <?php require_once 'template/footer.php';?>
    </div>


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/superfish.min.js"></script>
    <script src="js/lightbox.min.js"></script>
    <script src="js/lib.js"></script>

</body>
</html>