<?php
    require_once '../init.php';

    if($main->isLogin())
        $main->redirect('index.php');

    if($main->post('btn_login'))
    {
        $resultLogin = $main->login($main->post('email'),$main->post('password'));
        if($resultLogin)
            $main->redirect('index.php');
        else
            $main->redirect('?msg=error-login');
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ورود به پنل مدیریت</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
</head>
<body>

    <div class="container" id="main">

        <?php

            $main->setWarning('no-login','برای دسترسی به بخش مدیریت باید وارد سیستم شوید.');
            $main->setDanger('error-login','ایمیل یا کلمه عبور صحیح نمی باشد.');
            $main->setSuccess('ok-logout','شما با موفقیت از سیستم خارج شدید.');
        ?>

        <form id="frm-login" class="form-horizontal" method="post" action="?">
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">
                    ایمیل :
                    <span class="star">*</span>
                </label>
                <div class="col-sm-10">
                    <input data-toggle="tooltip" title="لطفا ایمیل را وارد نمایید" type="text" class="form-control" id="email" name="email" placeholder="لطفا ایمیل را وارد نمایید">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">
                    کلمه عبور :
                    <span class="star">*</span>
                </label>
                <div class="col-sm-10">
                    <input data-toggle="tooltip" title="لطفا کلمه عبور را وارد نمایید"  type="password" class="form-control" id="password" name="password" placeholder="لطفا کلمه عبور را وارد نمایید">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button value="1" type="submit" name="btn_login" class="btn btn-success">
                        ورود
                    </button>
                </div>
            </div>
        </form>

    </div>


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/lib.js"></script>
    <script>
        $(document).ready(function(){
            $('#frm-login').validate({
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
                /*,errorElement: "em",
                errorPlacement: function ( error, element ) {
                    // Add the `help-block` class to the error element
                    error.addClass( "help-block" );

                    // Add `has-feedback` class to the parent div.form-group
                    // in order to add icons to inputs
                    element.parents( ".col-sm-10" ).addClass( "has-feedback" );

                    if ( element.prop( "type" ) === "checkbox" ) {
                        error.insertAfter( element.parent( "label" ) );
                    } else {
                        error.insertAfter( element );
                    }

                    // Add the span element, if doesn't exists, and apply the icon classes to it.
                    if ( !element.next( "span" )[ 0 ] ) {
                        $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
                    }
                },
                success: function ( label, element ) {
                    // Add the span element, if doesn't exists, and apply the icon classes to it.
                    if ( !$( element ).next( "span" )[ 0 ] ) {
                        $( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
                    }
                },
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).parents( ".col-sm-10" ).addClass( "has-error" ).removeClass( "has-success" );
                    $( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
                },
                unhighlight: function ( element, errorClass, validClass ) {
                    $( element ).parents( ".col-sm-10" ).addClass( "has-success" ).removeClass( "has-error" );
                    $( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
                }*/
            });
        });
    </script>
</body>
</html>