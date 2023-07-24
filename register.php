<?php
require_once 'init.php';
if($main->userIsLogin())
    $main->redirect('index.php');

if($main->post('btn_register'))
{
    $fn=$main->post('fn');
    $ln=$main->post('ln');
    $email=$main->post('email');
    $password=$main->post('password');
    $password2=$main->post('password2');
    $resultRegister=$main->userRegister($fn,$ln,$email,$password,$password2);
    if($resultRegister > 0)
    {
        $main->redirect("?msg=ok-register");
    }
    else
    {
        $main->redirect("?msg=$resultRegister");
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ثبت نام</title>
    <meta name="keywords" content="<?php print $config['meta_keywords']; ?>">
    <meta name="description" content="<?php print $config['meta_description']; ?>">
    <link rel="shortcut icon" href="<?php echo str_replace('../','',$config['favicon']); ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
    <style>
        .glyphicon-ok{
            color:green;
        }
        .glyphicon-remove{
            color:red;
        }
    </style>
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
             $main->setInfo('','برای ثبت نام در سیستم فرم زیر را تکمیل کنید.');
             $main->setSuccess('ok-register','شما با موفقیت در سیستم ثبت نام شدید.');
             $main->setWarning('-1','تکرار کلمه عبور اشتباه است.');
             $main->setWarning('-2','ایمیل وارد شده قبلاً در سیستم ثبت شده است.');
             $main->setWarning('register','این آدرس ایمیل قبلاً در سیستم ثبت نشده است،لطفاً ثبت نام کنید.');

            ?>
            <form id="frm_register" class="form-horizontal" method="post" action="?">
                <div class="form-group">
                    <label for="fn" class="col-sm-2 control-label">
                       نام:
                        <span class="star">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" id="fn" class="form-control" name="fn"  placeholder="نام ">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ln"  class="col-sm-2 control-label">
                        نام خانوادگی:
                        <span class="star">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" id="ln" class="form-control" name="ln"  placeholder=" نام خانوادگی">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email"  class="col-sm-2 control-label">
                        ایمیل:
                    <span class="star">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" dir="ltr" class="form-control" name="email" id="email" placeholder="ایمیل" title="ایمیل همان نام کاربری شما میباشد" data-toggle="tooltip">
                    </div>
                    <div class="col-sm-1">
                        <span id="confirm"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password"  class="col-sm-2 control-label">
                        کلمه عبور:
                        <span class="star">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="password" id="password" dir="ltr" class="form-control" name="password" placeholder="کلمه عبور">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password2"  class="col-sm-2 control-label">
                        تکرار کلمه عبور:
                        <span class="star">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="password" id="password2" dir="ltr" class="form-control" name="password2" placeholder=" تکرار کلمه عبور">
                    </div>
                </div>

                <div class="col-md-offset-2">
                    <input type="submit" value="ثبت نام" class="btn btn-success" name="btn_register">
                    <input type="button" value="ورود" onclick="redirect('login.php');" class="btn btn-info">
                    <input type="button" value="بازیابی حساب کاربری" onclick="redirect('account_recovery.php');" class="btn btn-warning">
                </div>
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
    <script src="js/lib.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#frm_register').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        uniqueEmail : true
                    },
                    password: 'required',
                    password2: {
                        required: true,
                        equalTo:'#password'
                    },
                    fn: 'required',
                    ln: 'required'

                },
                messages: {
                    email: {
                        required: 'لطفا ایمیل را وارد نمایید.',
                        email: 'ایمیل باید معتبر باشد.',
                        uniqueEmail : 'ایمیل تکراری میباشد.'
                    },
                    password: 'لطفا کلمه عبور را وارد نمایید',
                    password2: {
                        required: 'لطفا تکرار کلمه عبور را وارد نمایید.',
                        equalTo:'تکرار کلمه عبور صحیح نمیباشد'
                    },
                    fn:'لطفا نام را وارد نمایید',
                    ln:'لطفا نام خانوادگی را وارد نمایید'
                }
            });


            jQuery.validator.addMethod("uniqueEmail", function(value, element) {
                var response;
                if(value != '' && validateEmail(value))
                {
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: {'do': 'checkEmail', 'email': value},
                        async: false,
                        success: function (data) {
                            response = data;
                        }
                    });
                }
                else
                    response = 0;
                if (response == 1)
                    return true;
                else
                    return false;
            }, "Email is Already");


            $('#email').blur(function() {
                var email=$(this).val();
                if(email != '' && validateEmail(email))
                {
                    $.post('ajax.php',
                        {'do': 'checkEmail', 'email': email}, function (result) {
                            if (result == 1) {
                                $('#confirm').html(' <span class="glyphicon glyphicon-ok" ></span>');
                            }
                            else {
                                $('#confirm').html(' <span class="glyphicon glyphicon-remove" ></span>');
                            }
                        });
                }

            });

        });

    </script>




</body>
</html>