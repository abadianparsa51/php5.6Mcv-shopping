<?php
require_once 'init.php';
if(!$main->userIsLogin())
    $main->redirect('login.php');
$id = $main->toInt($main->get('id'));
$row  = $main->getOrder($id);
if(!isset($row['id']))
    $main->redirect('index.php');

?>
<!doctype html>
<html lang="en">
<head>
  <!--  <base href="<?php print $main->getBaseUrl(); ?>"> -->
    <meta charset="UTF-8">
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
       جزئیات سفارش
    </title>
    <meta name="keywords" content="<?php print $config['meta_keywords']; ?>">
    <meta name="description" content="<?php print $config['meta_description']; ?>">
    <link rel="shortcut icon" href="<?php echo str_replace('../','',$config['favicon']); ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
</head>
<body>

<div class="container-fluid" style="margin-top: 25px;">
    <?php require_once 'template/header.php';?>
</div>


<?php require_once 'template/nav.php'; ?>
<div class="container-fluid">
    <div class="col-sm-2"></div>
    <div class="col-lg-8" id="content">


        <table class="table table-bordered">
            <tr>
                <td>کد سفارش :  </td>
                <td>
                    <b>
                        <?php print $row['code']; ?>
                    </b>
                </td>
            </tr>
            <tr>
                <td>
                    مبلغ سفارش
                </td>
                <td>
                    <b>
                        <?php
                        print number_format($main->getTotalOrderPrice($row['id']));
                        ?>
                        ریال
                    </b>

                </td>
            </tr>
            <tr>
                <td>وضیعت سفارش : </td>
                <td>
                    <?php $main->getStatusOrder($row['status']); ?>
                </td>
            </tr>
            <tr>
                <td> وضیعت پرداخت : </td>
                <td>
                    <?php
                    if($row['is_pay'] == 1)
                    {
                        print "<b>پرداخت شده</b>";
                    }
                    else
                        print '-';
                    ?>

                </td>
            </tr>
            <tr>
                <td>تاریخ سفارش : </td>
                <td>
                    <b dir="ltr">
                        <?php
                        $order_date_array = explode(' ',$row['order_date']);
                        print $main->g2j($order_date_array[0]).' '.$order_date_array[1];
                        ?>

                    </b>
                </td>
            </tr>

        </table>
        <h4>
            لیست محصولات سفارش :
        </h4>
        <table class="table table-bordered">
            <tr class="text-center">
                <td>ردیف</td>
                <td>محصول</td>
                <td>تعداد</td>
                <td>قیمت کل</td>
            </tr>
            <?php
            $i = 1;
            $result = $main->getListOrderItems($id);
            while($rows = $main->getRow($result))
            {
                $pro  = $main->getProduct($rows['pro_id']);
                $urlProduct = $main->getBaseUrl() . 'product/' . "$pro[id]/" . $main->createSeoUrl($pro['title_en']);
                ?>
                <tr class="text-center">
                    <td><?php print $i++; ?></td>
                    <td>
                        <a href="<?php print $urlProduct; ?>" target="_blank">
                            <?php print $pro['title_fa']; ?>
                        </a>
                    </td>
                    <td>
                        <?php print $rows['num']; ?>
                    </td>
                    <td>
                        <span dir="ltr">
                            <?php print number_format($rows['price']); ?>
                        </span>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="3" class="text-left">
                    جمع کل :
                </td>
                <td colspan="2">
                    <?php
                    print number_format($main->getTotalOrderPrice($row['id']));
                    ?>
                    ریال
                </td>
            </tr>
        </table>


    </div>
    <div class="col-sm-2"></div>
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
    });
</script>

</body>
</html>