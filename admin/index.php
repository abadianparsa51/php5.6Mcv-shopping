<?php
    require_once '../init.php';
    if($main->get('logout'))
    {
        $main->beforeLogout();
        session_unset();
        session_destroy();
        $main->redirect('login.php?msg=ok-logout');
    }

    $profile = $main->getProfile();


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        پنل مدیریت
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
</head>
<body>

<div class="modal fade" tabindex="-1" role="dialog" id="logoutModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    خروج از سیستم
                </h4>
            </div>
            <div class="modal-body">
                آیا مایل هستید از سیستم خارج شوید ؟
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">خیر</button>
                <button type="button" class="btn btn-info" onclick="redirect('index.php?logout=1')">بلی</button>
            </div>
        </div>
    </div>
</div>







    <div class="container text-center" id="main">


        <ol class="breadcrumb">
            <li class="active"><a href="index.php">خانه</a></li>
            <li>
                خوش آمدید :
<b>
    <?php print $profile['fn'].' '.$profile['ln'];  ?>
</b>
            </li>
            <li>
                            تاریخ آخرین ورود به سیستم :
                <b dir="ltr">
                    <?php
                           $dateArray = explode(' ',$profile['last_login']);
                            print $main->g2j($dateArray[0]).' '.$dateArray[1];
                    ?>
                </b>
            </li>
        </ol>


        <input data-toggle="modal" data-target="#logoutModal" type="button" value="خروج از سیستم" class="btn btn-danger">
        <div class="clearfix"></div>
        <br>

        <div class="list-group">
            <a href="profile.php" class="list-group-item">
                ویرایش پروفایل
            </a>
            <a href="add_category.php" class="list-group-item">
                اضافه کردن گروه و زیر گروه
            </a>
            <a href="list_category.php" class="list-group-item">
                ویرایش گروه ها و زیر گروه ها
             </a>
            <a href="add_product.php" class="list-group-item">
                اضافه کردن محصول
            </a>
            <a href="list_product.php" class="list-group-item">
                مدیریت محصولات
            </a>
            <a href="list_users.php" class="list-group-item">
                مدیریت کاربران
            </a>
<!--            <a href="list_slider.php" class="list-group-item">-->
<!--مدیریت اسلاید ها-->
<!--            </a>-->
            <a href="edit_site.php" class="list-group-item">
                تنظیمات سایت
            </a>
<!--            <a href="list_order.php" class="list-group-item">-->
<!--                لیست سفارشات-->
<!--            </a>-->


        </div>



    </div>


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/lib.js"></script>
</body>
</html>