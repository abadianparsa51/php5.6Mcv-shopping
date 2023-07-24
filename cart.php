<?php
    require_once 'init.php';
    $del_id = $main->toInt($main->get('del_id'));
    if($del_id > 0)
    {
        if(isset($_SESSION['cart_items'][$del_id]))
        {
            unset($_SESSION['cart_items'][$del_id]);
            unset($_SESSION['all_price_total'][$del_id]);
            $main->redirect("cart.php?msg=ok-del");
        }
    }

    if($main->post('btn_update_cart'))
    {
        if(isset($_POST['id']) && count($_POST['id']) > 0)
        {
            $i = 0;
            foreach($_POST['id'] as $id)
            {
                $id = $main->toInt($id);
                $num = $main->toInt($_POST['num'][$i]);
                if(isset( $_SESSION['cart_items'][$id]))
                {
                    $_SESSION['cart_items'][$id]['num'] = $num;
                    $price = $num * $_SESSION['cart_items'][$id]['price'];
                    $_SESSION['cart_items'][$id]['total_price'] = $price;
                    $_SESSION['all_price_total'][$id] = $price;
                }
                $i++;
            }

            $main->redirect("cart.php?msg=ok-up");
        }

    }
?>
<!doctype html>
<html lang="en">
<head>
    <base href="<?php print $main->getBaseUrl(); ?>">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>سبد خرید شما</title>
    <meta name="keywords" content="<?php print $config['meta_keywords']; ?>">
    <meta name="description" content="<?php print $config['meta_description']; ?>">
    <link rel="shortcut icon" href="<?php echo str_replace('../','',$config['favicon']); ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
    <style>
        .cart-num{
            width: 80px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    حذف رکورد
                </h4>
            </div>
            <div class="modal-body">
                آیا میخواهید رکورد
                <b id="modal-delete-title" class="text-danger"></b>
                حذف شود ؟
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">خیر</button>
                <button type="button" id="modal-delete-btn" class="btn btn-danger">بلی</button>
            </div>
        </div>
    </div>
</div>

    <div class="container-fluid" style="margin-top: 25px;">
        <?php require_once 'template/header.php';?>
    </div>

    <?php require_once 'template/nav.php'; ?>
    <div class="container-fluid">
<div class="col-sm-2" ></div>
        <div class="col-sm-8" id="content">
            <?php
                if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0)
                {
                    ?>
                    <form action="" method="post">
                    <table class="table table-bordered">
                        <tr class="text-center">
                            <td>ردیف</td>
                            <td>محصول</td>
                            <td>تعداد</td>
                            <td>قیمت کل</td>
                            <td>حذف</td>
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
                                    <input type="hidden" value="<?php print $k; ?>" name="id[]">
                                    <input class="form-control cart-num" type="number" min="1" value="<?php print $val['num']; ?>" name="num[]">
                                </td>
                                <td>
                                    <span dir="ltr">
                                        <?php print number_format($val['total_price']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button data-toggle="modal" data-target="#modalDelete" data-id="<?php print $k; ?>" data-title="<?php print $val['title']; ?>" type="button" class="btn btn-danger">
                                        <span class="fa fa-trash"></span>
                                    </button>
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
                        <input type="submit" name="btn_update_cart" class="btn btn-success" value="ذخیره تغییرات">
                        <a class="btn btn-info" href="checkout.php">تسویه حساب</a>
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
            ?>
        </div>
        <div class="col-sm-2" ></div>
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