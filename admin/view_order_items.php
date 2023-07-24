<?php
    require_once '../init.php';
    $id = $main->toInt($main->get('id'));
    $row  = $main->getOrder($id);
    $user = $main->getUser($row['user_id']);
    if($main->post('btn_change_status'))
    {
        $main->OrderChangeStatus($id,$main->post('status'));
        $main->redirect("?id=$id&msg=ok");
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        جزئیات سفارش
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">

</head>
<body>


    <div class="container" id="main">

        <?php
            $main->setSuccess('ok','با موفقیت تغییر یافت.');
        ?>

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
                <td>نام کاربر : </td>
                <td>
                    <a href="edit_user.php?id=<?php print $row['user_id'] ?>" target="_blank">
                        <b> <?php print $user['email']; ?></b>
                    </a>


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
                    <form action="" method="post">
                    <select name="status" id="status">
                        <option value="1" <?php if($row['status'] == 1) print 'selected';?>>در حال برسی</option>
                        <option value="2" <?php if($row['status'] == 2) print 'selected';?>>در انتظار پرداخت</option>
                        <option value="3" <?php if($row['status'] == 3) print 'selected';?>>پرداخت شده</option>
                        <option value="4" <?php if($row['status'] == 4) print 'selected';?>>کنسل شده</option>
                        <option value="5" <?php if($row['status'] == 5) print 'selected';?>>ارسال شده</option>
                    </select>
                        <input type="submit" name="btn_change_status" value="تغییر وضیعت سفارش" class="btn btn-success">
                    </form>
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


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/lib.js"></script>
    <script>
        $(document).ready(function () {

        });
    </script>
</body>
</html>