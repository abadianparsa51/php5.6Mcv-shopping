<?php
    require_once '../init.php';
    $profile = $main->getProfile();


    if($main->post('btn_save'))
    {
        $resultSave = $main->saveProfile();
        $main->redirect("?msg=$resultSave");
    }

    if($main->get('del'))
    {
        $main->deleteProfileAvatar();
        $main->redirect("?msg=ok-del");
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
        ویرایش پروفایل
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
    <style>
        #avatar{
            display: none;
        }

        #avatar-img{
            width: 80px;
            height: 80px;
        }
    </style>
</head>
<body>



<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    حذف تصویر پروفایل
                </h4>
            </div>
            <div class="modal-body">
                آیا مایل هستید تصویر پروفایل شما حذف شود ؟
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">خیر</button>
                <button type="button" class="btn btn-info" onclick="redirect('profile.php?del=1')">بلی</button>
            </div>
        </div>
    </div>
</div>



    <div class="container" id="main">

        <?php
                $main->setSuccess('0','اطلاعات با موفقیت ویرایش شد.');
                $main->setSuccess('1','اطلاعات با موفقیت ویرایش شد.');
                $main->setSuccess('ok-del','تصویر با موفقیت حذف شد.');
                $main->setDanger('-1','ایمیل تکراری میباشد.');
                $main->setDanger('-2','پسورد جاری صحیح نمیباشد.');
                $main->setDanger('-3','تکرار پسورد جدید صحیح نمیباشد.');
                $main->setDanger('-4','فرمت فایل باید jpg - gif - png باشد.');
                $main->setDanger('-5','خطا در آپلود فایل لطفا دوباره تلاش کنید.');
        ?>

        <form enctype="multipart/form-data" id="frm-profile" class="form-horizontal" method="post" action="?">
            <div class="form-group">
                <label for="fn" class="col-sm-2 control-label">
                    نام :
                    <span class="star">*</span>
                </label>
                <div class="col-sm-10">
                    <input value="<?php print $profile['fn']; ?>" type="text" class="form-control" id="fn" name="fn">
                </div>
            </div>

            <div class="form-group">
                <label for="ln" class="col-sm-2 control-label">
                    نام خانوادگی :
                    <span class="star">*</span>
                </label>
                <div class="col-sm-10">
                    <input value="<?php print $profile['ln']; ?>" type="text" class="form-control" id="ln" name="ln">
                </div>
            </div>
            <div class="form-group">
                <label for="tel" class="col-sm-2 control-label">
                    تلفن :
                </label>
                <div class="col-sm-10">
                    <input value="<?php print $profile['tel']; ?>" dir="ltr" type="text" class="form-control" id="tel" name="tel">
                </div>
            </div>

            <div class="form-group">
                <label for="mobile" class="col-sm-2 control-label">
                    موبایل :
                    <span class="star">*</span>
                </label>
                <div class="col-sm-10">
                    <input value="<?php print $profile['mobile']; ?>" dir="ltr" type="text" class="form-control" id="mobile" name="mobile">
                </div>
            </div>

            <div class="form-group">
                <label for="address" class="col-sm-2 control-label">
                    آدرس :
                </label>
                <div class="col-sm-10">
                    <textarea style="height: 120px;" class="form-control" id="address" name="address"><?php print $profile['address']; ?></textarea>
                </div>
            </div>



            <div class="form-group">
                <label for="avatar" class="col-sm-2 control-label">
                    تصویر پروفایل :
                </label>
                <div class="col-sm-10">
                    <?php
                    $path = '../'.$profile['avatar'];
                    if($profile['avatar'] != '' && file_exists($path))
                    {
                        ?>
                        <a href="<?php print $path ?>" target="_blank">
                            <img id="avatar-img" src="<?php print $path; ?>" alt="avatar">
                        </a>
                        <input data-toggle="modal" data-target="#deleteModal" type="button" value="حذف تصویر" class="btn btn-danger">
                        <?php
                    }
                    else
                    {
                        ?>
                        <input id="btn-file" type="button" class="btn btn-info" value="انتخاب تصویر">
                        <input dir="ltr" type="file" class="form-control" id="avatar" name="avatar">
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">
                    ایمیل :
                    <span class="star">*</span>
                </label>
                <div class="col-sm-10">
                    <input value="<?php print $profile['email']; ?>" dir="ltr" type="text" class="form-control" id="email" name="email">
                </div>
            </div>
            <?php
                $main->setWarning('',' اگر میخواهید کلمه عبور را تغییر بدهید فیلد های زیر را پر کنید. ');
            ?>
            <div class="form-group">
                <label for="pass1" class="col-sm-2 control-label">
                    کلمه عبور جاری :
                </label>
                <div class="col-sm-10">
                    <input dir="ltr" type="password" class="form-control" id="pass1" name="pass1">
                </div>
            </div>
            <div class="form-group">
                <label for="pass2" class="col-sm-2 control-label">
                    کلمه عبور جدید :
                </label>
                <div class="col-sm-10">
                    <input dir="ltr" type="password" class="form-control" id="pass2" name="pass2">
                </div>
            </div>
            <div class="form-group">
                <label for="pass3" class="col-sm-2 control-label">
                    تکرار کلمه عبور جدید :
                </label>
                <div class="col-sm-10">
                    <input dir="ltr" type="password" class="form-control" id="pass3" name="pass3">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-success" value="ذخیره" name="btn_save">
                    <input onclick="redirect('index.php');" type="button" class="btn btn-danger" value="بازگشت">
                </div>
            </div>
        </form>


    </div>


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/lib.js"></script>
    <script>
        $(document).ready(function () {

            $('#btn-file').click(function(){
                $('#avatar').click();
            });

            $('#frm-profile').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    fn: 'required',
                    ln: 'required',
                    mobile: 'required'
                },
                messages: {
                    email: {
                        required: 'لطفا ایمیل را وارد نمایید.',
                        email: 'ایمیل باید معتبر باشد.'
                    },
                    fn: 'لطفا نام را وارد نمایید',
                    ln: 'لطفا نام خانوادگی را وارد نمایید',
                    mobile: 'لطفا موبایل را وارد نمایید'
                }
            });
        });
    </script>
</body>
</html>