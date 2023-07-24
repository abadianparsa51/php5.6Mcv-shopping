<?php
    require_once 'init.php';
    $search = $main->safeString($main->get('search'));
    $cat = $main->toInt($main->get('cat'));
    $sub = $main->toInt($main->get('sub'));
    $params = "&search=$search&cat=$cat&sub=$sub";
?>
<!doctype html>
<html lang="en">
<head>
    <base href="<?php print $main->getBaseUrl(); ?>">
    <meta charset="UTF-8">
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>جستجو</title>
    <meta name="keywords" content="<?php print $config['meta_keywords']; ?>">
    <meta name="description" content="<?php print $config['meta_description']; ?>">
    <link rel="shortcut icon" href="<?php echo str_replace('../','',$config['favicon']); ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
</head>
<body>
<div id="product-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header product-modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="product-modal-title">
                    <h4>
            </div>
            <div class="modal-body">
                <div id="product-modal-loading" class="text-center"></div>
                <div class="row">
                    <div class="col-lg-4" id="product-modal-img">

                    </div>
                    <div class="col-lg-8" id="product-modal-desc">
                    </div>
                </div>
            </div>
            <div class="modal-footer product-modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    بستن
                </button>
            </div>
        </div>

    </div>
</div>


    <div class="container-fluid" STYLE="margin-top:25px;">
        <?php require_once 'template/header.php';?>
    </div>

<!--    <div class="container-fluid" id="search-bar">-->
<!--        --><?php //require_once 'template/search-bar.php';?>
<!--    </div>-->
    <?php require_once 'template/nav.php'; ?>
    <div class="container-fluid">

        <div class="col-sm-9" id="content-list-pro">
            <div class="content-header col-lg-12">
                <span>

                    نتیجه جستجو
                    :
                    <b>
                    <?php
                        print $search;
                    ?>
                    </b>
                </span>
            </div>
            <div class="clearfix"></div>
            <div class="content-box">
                <?php
                $i = 1;
                $resultProducts = $main->getSearchProducts($search,$cat,$sub);
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
                        <div class="col-lg-4  text-center">
                            <a href="<?php print $urlProduct; ?>" target="_blank"><img class="img-responsive"
                                src="<?php echo str_replace('../', '', $proRows['thumb_image']); ?>"
                                style="width: 100%"
                                  alt="<?php echo $proRows['title_fa'] ?>"
                                     title="<?php echo $proRows['title_fa'] ?>"></a>
                            <a href="<?php print $urlProduct; ?>" target="_blank">
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
                    $main->pagination2($resultProducts['totalPage'],$params);
                }
                ?>
            </div>



        </div>
        <div class="col-xs-3" id="sidebar">
            <div class="block-header">
                فیلتر گروه ها
            </div>
            <div class="block-body" id="search-filter">
                <ul class="list-group node-cat">
                    <?php
                    $resultCat = $main->getCategories();
                    while($catRows = $main->getRow($resultCat))
                    {
                        $url2 = "search.php?search=$search&cat=".$catRows['id'];
                        $is_active = ($cat == $catRows['id']) ? 'active' : '';
                        $class_node_sub = ($cat == $catRows['id']) ? 'node-subcat2' : '';
                        $class_node_sub_st = ($cat == $catRows['id']) ? 'node-close' : 'node-open';
                        $class_node_sub_span = ($cat == $catRows['id']) ? 'fa-minus' : 'fa-plus';
                        ?>
                        <li class="list-group-item <?php print $is_active; ?>">
                            <span class="fa <?php print $class_node_sub_span.' '.$class_node_sub_st; ?>"></span>
                            &nbsp;
                            <a href="<?php print $url2 ?>">
                                <?php print $catRows['title']; ?>
                            </a>
                            <ul class="list-group node-subcat <?php print $class_node_sub; ?>">
                                <?php
                                $resultSubCat = $main->getCategories($catRows['id']);
                                while($subCatRows = $main->getRow($resultSubCat))
                                {
                                    $url3 = "search.php?search=$search&cat=".$catRows['id']."&sub=".$subCatRows['id'];
                                    $is_active = ($sub == $subCatRows['id']) ? 'active' : '';
                                    ?>
                                    <li class="list-group-item <?php print $is_active; ?>">
                                        <a href="<?php print $url3 ?>">
                                            <?php print $subCatRows['title']; ?>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="footer">
        <?php require_once 'template/footer.php';?>
    </div>

    


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/superfish.min.js"></script>
    <script src="js/lib.js"></script>
    <script>
            $(document).ready(function () {
                $('.node-open,.node-close').click(function () {
                    if($(this).hasClass('node-open'))
                    {
                        $(this).removeClass('fa-plus').addClass('fa-minus');
                        $(this).removeClass('node-open').addClass('node-close');
                        $(this).parent().find('.node-subcat').show();
                    }
                    else
                    {
                        $(this).removeClass('fa-minus').addClass('fa-plus');
                        $(this).removeClass('node-close').addClass('node-open');
                        $(this).parent().find('.node-subcat').hide();
                    }
                });
            });
    </script>
</body>
</html>