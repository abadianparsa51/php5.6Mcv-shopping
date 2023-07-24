<?php
require_once 'init.php';
if($main->userIsLogin())
    $main->redirect('index.php');

if($main->post('btn_recover'))
{
    $email=$main->post('email');
    $resultAccountRecovery=$main->accountRecovery($email);
    if($resultAccountRecovery == 0)
    {
        $main->redirect('?msg=not-found');
    }
    else
    {
        $subject="Account Recovery";
        $body="Hi <b>$resultAccountRecovery[fn] $resultAccountRecovery[ln]</b><br>";
		$body.= "Your Email : <b>$resultAccountRecovery[email]</b><br>";
		$body.= "Your Password : <b>$resultAccountRecovery[password]</b><br>";
        $resultSendEmail=$main->sendEmail($email,$subject,$body);
        $main->redirect('?msg=email-send');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>بازیابی حساب کاربری </title>
    <meta name="keywords" content="<?php print $config['meta_keywords']; ?>">
    <meta name="description" content="<?php print $config['meta_description']; ?>">
    <link rel="shortcut icon" href="<?php echo str_replace('../','',$config['favicon']); ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
</head>
<body>


<div class="container-fluid" style="margin-top: 25px;" >
    <?php require_once 'template/header.php';?>
</div>

<?php require_once 'template/nav.php'; ?>
<div class="container-fluid">
    <div class="col-sm-2"></div>

    <div class="col-lg-8" id="content">
        <?php
        $main->setInfo('','لطفاً آدرس ایمیل خود را وارد نمایید.');
        $main->setInfo('email-send','کلمه عبور شما به آدرس ایمیلتان ارسال شد.');
        $main->setDanger('not-found','کاربر یافت نشد.');
        ?>
        <form id="frm-user-recovery" method="post" action="?">
            <div class="form-group">
                <label for="email">
                    ایمیل:
                    <span class="star">*</span></label>
                <input type="text" id="email" dir="ltr" class="form-control" name="email" placeholder="ایمیل" title="ایمیل همان نام کاربری شما میباشد" data-toggle="tooltip">
            </div>

            <button type="submit" name="btn_recover" class="btn btn-danger" value="1">
                ارسال کلمه عبور
                <span class="glyphicon glyphicon-envelope"></span>
            </button>


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
        $('#frm-user-recovery').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },

            },
            messages: {
                email: {
                    required: 'لطفا ایمیل را وارد نمایید.',
                    email: 'ایمیل باید معتبر باشد.'
                },

            }
        });
    });
</script>
</body>
</html>