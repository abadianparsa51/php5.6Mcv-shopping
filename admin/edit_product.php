<?php
    require_once '../init.php';

    $title_fa = $main->safeString($main->get('title_fa'));
    $title_en = $main->safeString($main->get('title_en'));
    $category_id = $main->toInt($main->get('category_id'));
    $sub_category_id = $main->toInt($main->get('sub_category_id'));
    $price = $main->safeString($main->get('price'));
    $price_discount = $main->safeString($main->get('price_discount'));
    $model = $main->safeString($main->get('model'));
    $code = $main->safeString($main->get('code'));
    if($main->get('status') == '')
        $status = -1;
    else
        $status = $main->toInt($main->get('status'));

    if($main->get('is_special') == '')
        $is_special = -1;
    else
        $is_special = $main->toInt($main->get('is_special'));

    $params = "title_fa=$title_fa&title_en=$title_en&category_id=$category_id&sub_category_id=$sub_category_id";
    $params .= "&price=$price&price_discount=$price_discount&model=$model&code=$code&status=$status&is_special=$is_special";


    $step = $main->toInt($main->get('step'));
    $id = $main->toInt($main->get('id'));

    $row = $main->getProduct($id);

    if($main->post('btn_save_step1'))
    {
        $resultStep1 = $main->saveProductStep1($id);
        if($resultStep1 > 0)
            $main->redirect("?step=2&id=$id&$params");
        else
            $main->redirect("?step=1&msg=error&$params&id=$id");

    }

    if($main->post('btn_save_step2'))
    {
        $main->saveProductStep2($id);
        $main->redirect("?step=3&id=$id&$params");
    }

    if($main->post('btn_save_step3'))
    {
        $main->saveProductStep3Edit($id);
        $main->redirect("?step=4&id=$id&$params");
    }

    if($main->post('btn_save_step4'))
    {
        $main->saveProductStep4($id);
        $main->redirect("?step=1&msg=ok&$params&id=$id");
    }


    if($main->get('del_img_id'))
    {
        $main->deleteImageProduct($id,$main->get('del_img_id'));
        $main->redirect("?step=3&msg=ok-del&$params&id=$id");
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
      ویرایش محصول
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
                        $main->setSuccess('ok','محصول با موفقیت ویرایش شد.');
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
                                        $sel1 = ($rows['id'] == $row['category_id']) ? 'selected' : '';
                                        ?>
                                        <option <?php print $sel1; ?> value="<?php print $rows['id']; ?>">
                                            <?php print $rows['title']; ?>
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
                                    <?php
                                    $resultSubCategoryList = $main->getParentCategoryList($row['category_id']);
                                    while($rows = $main->getRow($resultSubCategoryList))
                                    {
                                        $sel2 = ($rows['id'] == $row['sub_category_id']) ? 'selected' : '';
                                        ?>
                                        <option <?php print $sel2; ?> value="<?php print $rows['id']; ?>">
                                            <?php print $rows['title']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title_fa" class="col-sm-2 control-label">
                                عنوان (فارسی) :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input value="<?php print $row['title_fa']; ?>" type="text" class="form-control" id="title_fa" name="title_fa">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title_en" class="col-sm-2 control-label">
                                عنوان (انگلیسی) :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input value="<?php print $row['title_en']; ?>" type="text" dir="ltr" class="form-control" id="title_en" name="title_en">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="short_content" class="col-sm-2 control-label">
                               توضیحات مختصر :
                            <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <textarea style="height: 150px;" class="form-control" id="short_content" name="short_content"><?php print $row['short_content']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="long_content" class="col-sm-2 control-label">
                            توضیحات کامل :
                            <span class="star">*</span>
                            </label>
                        <div class="col-sm-10">
                                <textarea style="height: 150px;" class="form-control" id="long_content" name="long_content"><?php print $row['long_content']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">
                                وضیعت نمایش :
                            </label>
                            <div class="col-sm-10">
                                <input type="checkbox" <?php if($row['status'] == '1') print 'checked' ?> id="status" name="status">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_special" class="col-sm-2 control-label">
                                محصول ویژه :
                            </label>
                            <div class="col-sm-10">
                                <input type="checkbox" <?php if($row['is_special'] == '1') print 'checked' ?> id="is_special" name="is_special">
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-success" value="مرحله بعد" name="btn_save_step1">
                                <input onclick="redirect('list_product.php?<?php print $params; ?>');" type="button" class="btn btn-danger" value="بازگشت">
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
                                <input value="<?php print $row['model']; ?>" type="text" class="form-control" id="model" name="model">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">
                              کد محصول :
                            </label>
                            <div class="col-sm-10">
                                <input value="<?php print $row['code']; ?>" type="text" dir="ltr" class="form-control" id="code" name="code">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">
                                قیمت محصول :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input value="<?php print $row['price']; ?>" type="text" dir="ltr" class="form-control" id="price" name="price">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price_discount" class="col-sm-2 control-label">
                                قیمت تخفیف محصول :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input   value="<?php print $row['price_discount']; ?>" type="text" dir="ltr" class="form-control" id="price_discount" name="price_discount">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity" class="col-sm-2 control-label">
                                موجودی انبار :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input value="<?php print $row['quantity']; ?>" type="text" dir="ltr" class="form-control" id="quantity" name="quantity">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input onclick="redirect('?<?php print $params; ?>&step=1&id=<?php print $id; ?>');" type="button" class="btn btn-info" value="مرحله قبل">
                                <input type="submit" class="btn btn-success" value="مرحله بعد" name="btn_save_step2">
                                <input onclick="redirect('list_product.php?<?php print $params; ?>');" type="button" class="btn btn-danger" value="بازگشت">
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane <?php print $classTab3; ?>" id="step3">
                    <?php
                        $main->setSuccess('ok-del','تصویر با موفقیت حذف شد.');
                    ?>
                    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">
                                        حذف تصویر
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    آیا میخواهید تصویر
                                    <b id="modal-delete-title" class="text-danger"></b>
                                    حذف شود ؟
                                    </b>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">خیر</button>
                                    <button type="button" id="modal-delete-btn" class="btn btn-danger">بلی</button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <form id="frm-step3" class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label for="thumb_image" class="col-sm-2 control-label">
                                تصویر اصلی محصول :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10 text-center">
                                <input type="text" value="<?php print $row['thumb_image']; ?>" placeholder="برای ارسال تصویر لطفا کلیک نمایید" dir="ltr" class="form-control imageUploader" id="thumb_image" name="thumb_image">
                                <a href="<?php print $row['thumb_image'] ?>" target="<?php print $row['thumb_image'] ?>">
                                    <img style="width: 80px;height: 80px;" src="<?php print $row['thumb_image'] ?>" alt="<?php print $row['title_fa'] ?>">
                                </a>
                            </div>
                        </div>



                        <table class="table table-bordered" id="tbl-list">
                            <tr class="text-center">
                                <th class="text-center">تصویر</th>
                                <th class="text-center"> توضیحات</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            <?php
                                $resultImage = $main->getImageProductList($id);
                                if($resultImage->num_rows == 0)
                                {
                                    ?>
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
                                            <input type="hidden" name="img_id[]" value="0">
                                        </td>
                                    </tr>

                                    <?php
                                }
                                else {


                                    while ($img = $main->getRow($resultImage)) {
                                        ?>
                                        <tr class="text-center">
                                            <td><input type="text" name="img[]"
                                                       value="<?php print $img['img'] ?>"
                                                       placeholder="برای ارسال تصویر لطفا کلیک نمایید" dir="ltr"
                                                       class="form-control imageUploader">
                                                <br>
                                                <a href="<?php print $img['img'] ?>"
                                                   target="<?php print $img['img'] ?>">
                                                    <img style="width: 80px;height: 80px;"
                                                         src="<?php print $img['img'] ?>"
                                                         alt="<?php print $img['alt'] ?>">
                                                </a>
                                            </td>
                                            <td><input type="text" name="alt[]" value="<?php print $img['alt'] ?>"
                                                       class="form-control"></td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-add-row">
                                                    <span class="fa fa-plus"></span>
                                                </button>
                                                <button data-title="<?php print $img['alt'] ?>"
                                                        data-id="<?php print $img['id'] ?>" style="display:inline;"
                                                        type="button"
                                                        class="btn btn-danger btn-del-row">
                                                    <span class="fa fa-minus"></span>
                                                </button>
                                                <input type="hidden" name="img_id[]" value="<?php print $img['id'] ?>">
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                        </table>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input onclick="redirect('?<?php print $params; ?>&step=2&id=<?php print $id; ?>');" type="button" class="btn btn-info" value="مرحله قبل">
                                <input type="submit" class="btn btn-success" value="مرحله بعد" name="btn_save_step3">
                                <input onclick="redirect('list_product.php?<?php print $params; ?>');" type="button" class="btn btn-danger" value="بازگشت">
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
                                <textarea style="height: 150px;" class="form-control" id="meta_keywords" name="meta_keywords"><?php print $row['meta_keywords'];  ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_description" class="col-sm-2 control-label">
                                توضیحات سئو :
                                <span class="star">*</span>
                            </label>
                            <div class="col-sm-10">
                                <textarea style="height: 150px;" class="form-control" id="meta_description" name="meta_description"><?php print $row['meta_description'];  ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input onclick="redirect('?<?php print $params; ?>&step=3&id=<?php print $id; ?>');" type="button" class="btn btn-info" value="مرحله قبل">
                                <input type="submit" class="btn btn-success" value="پایان" name="btn_save_step4">
                                <input onclick="redirect('list_product.php?<?php print $params; ?>');" type="button" class="btn btn-danger" value="بازگشت">
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
                tr.find('input[name="img_id[]"]').val('0');
                tr.find('img').remove();
                tr.find('.btn-del-row').attr('data-title','');
                tr.find('.btn-del-row').attr('data-id','0');
                $('#tbl-list').append(tr);
            });
            $('.btn-del-row').click(function(){
                if($(this).attr('data-id') == '0')
                    $(this).parent().parent().remove();
                else
                {
                    var data = $(this);
                    $('#modalDelete').modal('show',data);
                }


            });


            $('#modalDelete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var title = button.data('title');
                var id = button.data('id');
                $(this).find('#modal-delete-title').html(title);
                $(this).find('#modal-delete-btn').attr('data-delete-id',id);
            });

            $('#modal-delete-btn').click(function () {
                var id = $(this).attr('data-delete-id');
                redirect('?<?php print $params."&page=$main->page&id=$id&step=3" ?>'+'&del_img_id='+id);
            });


            initPrice($('#price'));
            initPrice($('#price_discount'));

            $('#price,#price_discount').keyup(function(){
                initPrice($(this));
            });


        });

        function initPrice(t) {
            var v = numeral($(t).val()).format('0,0');
            $(t).val(v);
        }

    </script>
</body>
</html>