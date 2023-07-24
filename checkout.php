<?php
    require_once 'init.php';
    if($main->post('btn_reg_order'))
    {
        if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0)
        {
            $main->regOrder();
            $main->redirect("orders.php");
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <base href="<?php print $main->getBaseUrl(); ?>">
    <meta charset="UTF-8">
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تسویه حساب</title>
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
  <div class="col-md-2"></div>
        <div class="col-lg-8" id="content">
            <?php
                if($main->userIsLogin())
                {
                    ?>
                    <?php
                    if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0)
                    {
                        ?>
                        <h5>
                            سفارش شما :
                        </h5>

                        <form action="" method="post">
                            <table class="table table-bordered">
                                <tr class="text-center">
                                    <td>ردیف</td>
                                    <td>محصول</td>
                                    <td>تعداد</td>
                                    <td>قیمت کل</td>
                                </tr>
                                <?php
                                $i = 1;
                                foreach ($_SESSION['cart_items'] as $k => $val)
                                {
                                    $urlProduct = $main->getBaseUrl() . 'product/' . "$k/" . $main->createSeoUrl($val['title']);
                                    ?>
                                    <tr class="text-center">
                                        <td><?php print $i++; ?></td>
                                        <td>
                                            <a href="<?php print $urlProduct; ?>" target="_blank">
                                                <?php print $val['title']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php print $val['num']; ?>
                                        </td>
                                        <td>
                                    <span dir="ltr">
                                        <?php print number_format($val['total_price']); ?>
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
                                        $total_price = isset($_SESSION['all_price_total'])
                                            ? array_sum($_SESSION['all_price_total']) : '0';
                                        print number_format($total_price);

                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <div class="text-left">
                                <input type="submit" name="btn_reg_order" class="btn btn-success" value="تایید نهایی سفارش">
                            </div>
                        </form>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="alert alert-danger text-center">
                            سبد شما خالی میباشد .
                        </div>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <div class="alert alert-warning text-center">
                        برای تسویه حساب باید
                        وارد
                        <a href="login.php">
                            حساب کاربری
                        </a>
                        خود شوید
                        یا
                        <a href="register.php">
                            ثبت نام
                            </a>
                        نمایید
                        .
                    </div>
                    <?php
                }
            ?>
        </div>
        <div class="col-md-2"></div>
     </div>
    <div class="container-fluid" id="footer">
        <?php require_once 'template/footer.php';?>
    </div>
    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/superfish.min.js"></script>
    <script src="js/lib.js"></script>
    <script>
        $(document).ready(function(){
            $('#modalDelete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var title = button.data('title');
                var id = button.data('id');
                $(this).find('#modal-delete-title').html(title);
                $(this).find('#modal-delete-btn').attr('data-delete-id',id);
            });

            $('#modal-delete-btn').click(function () {
                var id = $(this).attr('data-delete-id');
                redirect('cart.php?del_id='+id);
            });


        });

    </script>
</body>
</html>