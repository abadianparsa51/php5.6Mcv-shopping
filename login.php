<?php
require_once 'init.php';
    if($main->userIsLogin())
       $main->redirect('index.php');

    if($main->post('btn_login'))
    {
        $email=$main->post('email');
        $password=$main->post('password');
        $resultUserLogin=$main->userLogin($email,$password);
        if($resultUserLogin > 0)
        {
            $main->redirect("user_profile.php");
        }
        else
            $main->redirect("?msg=error-login");
    }


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ورود کاربر</title>
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
        <?php
            $main->setInfo('','جهت ورود به سیستم مشخصات خود را وارد نمایید.');
            $main->setDanger('error-login','ایمیل یا کلمه عبور اشتباه می باشد.');
            $main->setInfo('ok-logout','شما با موفقیت از سیستم خارج شدید.');
        ?>
        <form id="frm-user-login" method="post" action="?">
            <div class="form-group">
                <label for="email">
                    ایمیل:
                    <span class="star">*</span></label>
                <input type="text" dir="ltr" id="email" class="form-control" name="email" placeholder="ایمیل" title="ایمیل همان نام کاربری شما میباشد" data-toggle="tooltip">
            </div>
            <div class="form-group">
                <label for="password">
                    کلمه عبور:
                    <span class="star">*</span></label>
                <input type="password" id="password" dir="ltr" class="form-control" name="password" placeholder="کلمه عبور">
            </div>

            <input type="submit" name="btn_login" class="btn btn-success" value="ورود">
            <input type="button" name="btn_recover" onclick="redirect('account_recovery.php');" class="btn btn-danger" value="کلمه عبور را فراموش کرده اید؟" >
        </form>

    </div>
    <div class="col-sm-2"></div>
</div>

<div class="container-fluid" id="footer">
    <?php require_once 'template/footer.php';?>
</div>

<script src="js/jquery-3.2.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/superfish.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/lib.js"></script>
<script>
    $(document).ready(function(){
        $('#frm-user-login').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: 'required'
            },
            messages: {
                email: {
                    required: 'لطفا ایمیل را وارد نمایید.',
                    email: 'ایمیل باید معتبر باشد.'
                },
                password: 'لطفا کلمه عبور را وارد نمایید'
            }
        });
    });
</script>
</body>
</html>