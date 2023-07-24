<?php
    require_once 'init.php';
    $cat = $main->toInt($main->get('cat'));
    $catInfo = $main->getCategory($cat);
    $sub = $main->toInt($main->get('sub'));
    $subCatInfo = $main->getCategory($sub);
?>
<!doctype html>
<html lang="en">
<head>
    <base href="<?php print $main->getBaseUrl(); ?>">
    <meta charset="UTF-8">
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>محصولات</title>
    <meta name="keywords" content="<?php print $config['meta_keywords']; ?>">
    <meta name="description" content="<?php print $config['meta_description']; ?>">
    <link rel="shortcut icon" href="<?php echo str_replace('../','',$config['favicon']); ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
</head>
<body>
    <div class="container-fluid" style="margin-top: 25px">
        <?php require_once 'template/header.php';?>
    </div>

    <?php require_once 'template/nav.php'; ?>
    <div class="container-fluid">
        <div class="col-sm-9" id="content-list-pro">
            <div class="content-header col-lg-12">
                <span>
                    محصولات
                    <b>
<!--                    --><?php
//                        if($cat > 0 && $sub > 0)
//                        {
//                            print $catInfo['title'] .' &gt; '.$subCatInfo['title'];
//                        }
//                        else
//                        {
//                            print $catInfo['title'];
//                        }
//                    ?>
                        </b>
                </span>
            </div>
            <div class="clearfix"></div>
            <div class="content-box">
                <?php
                $i = 1;
                $resultProducts = $main->getListProducts($cat,$sub);
                if($resultProducts['totalRows'] == 0)
                {
                    ?>
                    <div class="alert alert-warning text-center">
                        هیچ محصولی در این قسمت وجود ندارد .
                    </div>
                    <?php
                }
                elseif ($main->page > $resultProducts['totalPage'])
                {
                    ?>
                    <div class="alert alert-warning text-center">
                        هیچ محصولی در این قسمت وجود ندارد .
                    </div>
                    <?php
                }
                else
                {
                    while ($proRows = $main->getRow($resultProducts['result'])) {
                        $urlProduct = $main->getBaseUrl() . 'product/' . "$proRows[id]/" . $main->createSeoUrl($proRows['title_en']);
                        ?>
                        <div class="col-sm-4    text-center">
                            <a href="<?php print $urlProduct; ?>" target="_blank">
                                    <img class="img-responsive"
                                  src="<?php echo str_replace('../', '', $proRows['thumb_image']); ?>"
                                     alt="<?php echo $proRows['title_fa'] ?>"
                                        title="<?php echo $proRows['title_fa'] ?>" style="width: 100%;">
                            </a>
                            <a href="<?php print $urlProduct; ?>" target="_blank" class="product-title">
                                <?php echo $proRows['title_fa'] ?>
                            </a>
                            <p class="product-description">
                                <?php echo $proRows['short_content'] ?>
                            </p>


                        </div>
                        <?php
                        if ($i >= 4) {
                            print '<div class="clearfix"></div>';
                            $i = 0;
                        }
                        $i++;
                    }
                    ?>
                    <div class="clearfix"></div>
                    <?php
                    $main->pagination2($resultProducts['totalPage']);
                }
                ?>
            </div>



        </div>
<div class="col-xs-3 hidden-xs" id="sidebar">
    <?php
    if($cat > 0)
    {
        ?>
        <div class="block-header">
            زیر گروه های
            <?php print $catInfo['title'];?>

        </div>
        <div class="block-body">
            <ul class="list-group">
                <?php
                $resultSubCat = $main->getCategories($cat);
                while($subCatRows = $main->getRow($resultSubCat))
                {
                    $count_pro = $main->getCountProduct($cat,$subCatRows['id']);
                    $url2 = $main->getBaseUrl().'list/'.$cat.'/'.$subCatRows['id'].'/'.$main->createSeoUrl($catInfo['title'])
                        .'/'.$main->createSeoUrl($subCatRows['title']).'/';
                    $is_active = ($sub == $subCatRows['id']) ? 'active' : '';
                    ?>
                    <li>
                        <a href="<?php print $url2 ?>" class="list-group-item <?php print $is_active; ?>">
                            <?php print $subCatRows['title']; ?>
                            <span dir="ltr" class="badge"><?php print $count_pro; ?></span>
                        </a>

                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    <?php
    }
    ?>
</div>
        </div>

<?php require_once 'template/footer.php'; ?>











<script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/superfish.min.js"></script>
    <script src="js/lib.js"></script>
</body>
</html>