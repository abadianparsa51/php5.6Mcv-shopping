<?php
    require_once '../init.php';

    $step = $main->toInt($main->get('step'));
    $id = $main->toInt($main->get('id'));

    if($main->post('btn_add_step1'))
    {
        $resultStep1 = $main->addProductStep1();
        if($resultStep1 > 0)
            $main->redirect("?step=2&id=$resultStep1");
        else
            $main->redirect("?step=1&msg=error");

    }

    if($main->post('btn_add_step2'))
    {
        $main->saveProductStep2($id);
        $main->redirect("?step=3&id=$id");
    }

    if($main->post('btn_add_step3'))
    {
        $main->saveProductStep3($id);
        $main->redirect("?step=4&id=$id");
    }

    if($main->post('btn_add_step4'))
    {
        $main->saveProductStep4($id);
        $main->redirect("?step=1&msg=ok");
    }




    if($step == 2)
    {
        $classTab1 = "disabled";
        $dataTab1 = '';
        $classTab2 = "active";
        $dataTab2 = 'data-toggle="tab"';
        $classTab3 = "disabled";
        $dataTab3 = '';
        $classTab4 = "disabled";
        $dataTab4 = '';
    }
    elseif($step == 3)
    {
        $classTab1 = "disabled";
        $dataTab1 = '';
        $classTab2 = "disabled";
        $dataTab2 = '';
        $classTab3 = "active";
        $dataTab3 = 'data-toggle="tab"';
        $classTab4 = "disabled";
        $dataTab4 = '';
    }
    elseif($step == 4)
    {
        $classTab1 = "disabled";
        $dataTab1 = '';
        $classTab2 = "disabled";
        $dataTab2 = '';
        $classTab3 = "disabled";
        $dataTab3 = '';
        $classTab4 = "active";
        $dataTab4 = 'data-toggle="tab"';
    }else{

        $classTab1 = "active";
        $dataTab1 = 'data-toggle="tab"';
        $classTab2 = "disabled";
        $dataTab2 = '';
        $classTab3 = "disabled";
        $dataTab3 = '';
        $classTab4 = "disabled";
        $dataTab4 = '';
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
      اضافه کردن محصول
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/template.css">

</head>
<body>


    <div class="container" id="main">

        <div>

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="<?php print $classTab1; ?>">
                    <a href="#step1"  role="tab" <?php print $dataTab1; ?>>مشخصات کلی</a>
                </li>
                <li role="presentation" class="<?php print $classTab2; ?>">
                    <a href="#step2"  role="tab" <?php print $dataTab2; ?>>مشخصات محصول</a>
                </li>
                <li role="presentation" class="<?php print $classTab3; ?>">
                    <a href="#step3"  role="tab" <?php print $dataTab3; ?>>تصاویر محصول</a>
                </li>
                <li role="presentation" class="<?php print $classTab4; ?>">
                    <a href="#step4"  role="tab" <?php print $dataTab4; ?>>سایر</a>
                </li>
            </ul>

            <div id="tab-product" class="tab-content">
                <div role="tabpanel" class="tab-pane <?php print $classTab1; ?>" id="step1">
                    <?php
                        $main->setDanger('error','عنوان محصول تکراری میباشد.');
                        $main->setSuccess('ok','محصول با موفقیت ثبت شد.');
                    ?>
                    <form id="frm-step1" class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label for="category_id" class="col-sm-2 control-label">
                                گروه محصول :
                            </label>
                            <div class="col-sm-10">
                                <select name="category_id" dir="rtl" class="form-control" id="category_id">
                                    <option value="">-------</option>
                                    <?php
                                    $resultParentCategoryList = $main->getParentCategoryList();
                                    while($rows = $main->getRow($resultParentCategoryList))
                                    {
                                        ?>
                                        <option value="<?php print $rows['id']; ?>">
                                            -<?php print $rows['title']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sub_category_id" class="col-sm-2 control-label">
                                زیرگروه محصول :
                            </label>
                            <div class="col-sm-10">
                                <select name="sub_category_id" dir="rtl" class="form-control" id="sub_category_id">
                                    <option value="">-------</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title_fa" class="col-sm-2 control-label">
                                عنوان (فارسی) :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title_fa" name="title_fa">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title_en" class="col-sm-2 control-label">
                                عنوان (انگلیسی) :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" dir="ltr" class="form-control" id="title_en" name="title_en">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="short_content" class="col-sm-2 control-label">
                               توضیحات مختصر :
                            <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <textarea style="height: 150px;" class="form-control" id="short_content" name="short_content"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="long_content" class="col-sm-2 control-label">
                            توضیحات کامل :
                            <span class="star">*</span>
                            </label>
                        <div class="col-sm-10">
                                <textarea style="height: 150px;" class="form-control" id="long_content" name="long_content"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">
                                وضیعت نمایش :
                            </label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="status" name="status">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_special" class="col-sm-2 control-label">
                                محصول ویژه :
                            </label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="is_special" name="is_special">
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-success" value="مرحله بعد" name="btn_add_step1">
                                <input onclick="redirect('index.php');" type="button" class="btn btn-danger" value="بازگشت">
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane <?php print $classTab2; ?>" id="step2">
                    <form id="frm-step2" class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label for="model" class="col-sm-2 control-label">
                               مدل محصول :

                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="model" name="model">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">
                              کد محصول :

                            </label>
                            <div class="col-sm-10">
                                <input type="text" dir="ltr" class="form-control" id="code" name="code">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">
                                قیمت محصول :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" dir="ltr" class="form-control" id="price" name="price">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price_discount" class="col-sm-2 control-label">
                                قیمت تخفیف محصول :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" dir="ltr" class="form-control" id="price_discount" name="price_discount">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity" class="col-sm-2 control-label">
                                موجودی انبار :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" dir="ltr" class="form-control" id="quantity" name="quantity">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-success" value="مرحله بعد" name="btn_add_step2">
                                <input onclick="redirect('index.php');" type="button" class="btn btn-danger" value="بازگشت">
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane <?php print $classTab3; ?>" id="step3">
                    <form id="frm-step3" class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label for="thumb_image" class="col-sm-2 control-label">
                                تصویر اصلی محصول :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="برای ارسال تصویر لطفا کلیک نمایید" dir="ltr" class="form-control imageUploader" id="thumb_image" name="thumb_image">
                            </div>
                        </div>

                        <table class="table table-bordered" id="tbl-list">
                            <tr class="text-center">
                                <th class="text-center">تصویر</th>
                                <th class="text-center"> توضیحات</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            <tr class="text-center">
                                <td><input type="text" name="img[]" placeholder="برای ارسال تصویر لطفا کلیک نمایید" dir="ltr" class="form-control imageUploader"></td>
                                <td><input type="text" name="alt[]" class="form-control"></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-add-row">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                    <button style="display:none;" type="button" class="btn btn-danger btn-del-row">
                                        <span class="fa fa-minus"></span>
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-success" value="مرحله بعد" name="btn_add_step3">
                                <input onclick="redirect('index.php');" type="button" class="btn btn-danger" value="بازگشت">
                            </div>
                        </div>


                    </form>
                </div>
                <div role="tabpanel" class="tab-pane <?php print $classTab4; ?>" id="step4">
                    <form id="frm-step4" class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label for="meta_keywords" class="col-sm-2 control-label">
                                  کلید های جستجو سئو :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <textarea style="height: 150px;" class="form-control" id="meta_keywords" name="meta_keywords"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_description" class="col-sm-2 control-label">
                                توضیحات سئو :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <textarea style="height: 150px;" class="form-control" id="meta_description" name="meta_description"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-success" value="پایان" name="btn_add_step4">
                                <input onclick="redirect('index.php');" type="button" class="btn btn-danger" value="بازگشت">
                            </div>
                        </div>


                    </form>
                </div>
            </div>

        </div>



    </div>


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="tinymce/tinymce.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/numeral.min.js"></script>
    <script src="js/lib.js"></script>
    <script>
        $(document).ready(function () {

            initEditor('#long_content',600);

            $('#category_id').select2();
            $('#sub_category_id').select2();
            $('#category_id').change(function () {
               var id=parseInt($(this).val());
                if(id > 0)
                {
                    $('#sub_category_id option:gt(0)').remove();
                    $.post('ajax.php', {'do': 'getSubCat', 'id': id}, function (result) {
                        $('#sub_category_id').append(result);
                    });
                }
                else
                {
                    $('#sub_category_id option:gt(0)').remove();
                }
            });
            $('.btn-add-row').click(function(){
                var tr = $('#tbl-list tr').eq(1).clone(true);
                tr.find('.btn-del-row').css('display','inline-block');
                tr.find('input[type="text"]').val('');
                $('#tbl-list').append(tr);
            });
            $('.btn-del-row').click(function(){
               $(this).parent().parent().remove();
            });


            $('#price,#price_discount').keyup(function(){
                var t = numeral($(this).val()).format('0,0');
                $(this).val(t);
            });

        });
    </script>
</body>
</html>