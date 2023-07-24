<?php
    require_once '../init.php';
    $id = $main->toInt($main->get('id'));
    $row  = $main->getSlide($id);


    if($main->post('btn_save'))
    {
        $main->saveSlide($id);
        $main->redirect("?msg=ok&id=$id");
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
        ویرایش اسلاید شو
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">

</head>
<body>


    <div class="container" id="main">

        <?php
            $main->setSuccess('ok','با موفقیت ویرایش شد.');
        ?>

        <form id="frm-add" class="form-horizontal" method="post" action="">

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">
                    عنوان :
                </label>
                <div class="col-sm-10">
                    <input value="<?php print $row['title']; ?>" type="text" class="form-control" id="title" name="title">
                </div>
            </div>

            <div class="form-group">
                <label for="img" class="col-sm-2 control-label">
                    تصویر اصلی محصول :
                    <span class="star">*</span>
                </label>
                <div class="col-sm-10 text-center">
                    <input type="text" value="<?php print $row['img']; ?>" placeholder="برای ارسال تصویر لطفا کلیک نمایید"
                           dir="ltr" class="form-control imageUploader" id="img" name="img">
                    <a href="<?php print $row['img'] ?>" target="<?php print $row['img'] ?>">
                        <img style="width: 80px;height: 80px;" src="<?php print $row['img'] ?>" alt="<?php print $row['title'] ?>">
                    </a>
                </div>
            </div>

            <div class="form-group">
                <label for="link" class="col-sm-2 control-label">
                    لینک :
                    <span class="star">*</span>
                </label>
                <div class="col-sm-10">
                    <textarea dir="ltr" style="height: 150px;" class="form-control" id="link" name="link"><?php print $row['link']; ?></textarea>
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-success" value="ذخیره" name="btn_save">
                    <input onclick="redirect('list_slider.php');" type="button" class="btn btn-danger" value="بازگشت">
                </div>
            </div>
        </form>


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