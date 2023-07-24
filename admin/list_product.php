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

    $url = "?".$params;


    $where = '';
    if($title_fa != '')
        $where.= " AND title_fa LIKE '%$title_fa%' ";
    if($title_en != '')
        $where.= " AND title_en LIKE '%$title_en%' ";
    if($price != '')
        $where.= " AND price LIKE '%$price%' ";
    if($price_discount != '')
        $where.= " AND price_discount LIKE '%$price_discount%' ";
    if($model != '')
        $where.= " AND model LIKE '%$model%' ";
    if($code != '')
        $where.= " AND code LIKE '%$code%' ";

    if($category_id > 0)
        $where.= " AND category_id = '$category_id' ";
    if($sub_category_id > 0)
        $where.= " AND sub_category_id = '$sub_category_id' ";
    if($status != -1)
        $where.= " AND status = '$status' ";
    if($is_special != -1)
        $where.= " AND is_special = '$is_special' ";


    $main->setSortColumn(array('id','title_fa','title_en','category_id','sub_category_id'
        ,'price','price_discount','model','code','status','is_special'));
    $resultPagination  = $main->pagination('products',$where);


    if($main->get('del_id') != '')
    {
        $main->deleteProduct($main->get('del_id'));
        $main->redirect("$url&page=$main->page&msg=del");
    }


    if($main->post('btn_delete_group') && isset($_POST['del_rows']))
    {

        foreach($_POST['del_rows'] as $del_id)
        {
            $main->deleteProduct($del_id);
        }
        $main->redirect("$url&page=$main->page&msg=del");
    }

    if($main->get('st_id') != '' && $main->get('val') != '' )
    {
        $main->changeStatusProduct($main->get('st_id'),$main->get('val'));
        $main->redirect("$url&page=$main->page&msg=st");
    }

    if($main->get('special_id') != '' && $main->get('val') != '' )
    {
        $main->changeSpecialProduct($main->get('special_id'),$main->get('val'));
        $main->redirect("$url&page=$main->page&msg=special");
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
      مدیریت محصولات
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/template.css">

</head>
<body>


<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    حذف رکورد
                </h4>
            </div>
            <div class="modal-body">
               آیا میخواهید رکورد
    <b id="modal-delete-title" class="text-danger"></b>
                حذف شود ؟
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">خیر</button>
                <button type="button" id="modal-delete-btn" class="btn btn-danger">بلی</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteAll" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    حذف رکورد
                </h4>
            </div>
            <div class="modal-body">
                آیا میخواهید
                <b class="text-danger">
                    تمامی رکورد های انتخاب شده
                </b>
                حذف شود ؟
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">خیر</button>
                <button  type="button" onclick="$('#from-delete-group').submit();" class="btn btn-danger">بلی</button>
            </div>
        </div>
    </div>
</div>

    <div class="container-fluid" id="main">

        <?php
        if($resultPagination['totalRows'] == 0 && $where == '')
        {
            $main->setInfo('','رکوردی برای نمایش یافت نشد.');
            ?>
            <div class="text-center">
                <input value="بازگشت" type="button" onclick="redirect('index.php')" class="btn btn-info">
            </div>
            <?php
        }
        else if($main->page > $resultPagination['totalPage']  && $where == '')
        {
            $main->setWarning('','صفحه وجود ندارد !.');
            ?>
            <div class="text-center">
                <input value="بازگشت" type="button" onclick="redirect('?')" class="btn btn-warning">
            </div>
            <?php
        }
        else
        {
            $main->setSuccess('del','با موفقیت حذف شد.');
            $main->setSuccess('st','با موفقیت وضیعت نمایش تغییر یافت.');
            $main->setSuccess('special','با موفقیت محصول ویژه تغییر یافت.');
            ?>
            <form class="form-inline" id="form-search" method="get" action="">
                <div class="form-group">
                    <label for="title_fa">عنوان فارسی:</label>
                    <input type="text" value="<?php print $title_fa; ?>" class="form-control" id="title_fa" name="title_fa">
                </div>
                <div class="form-group">
                    <label for="title_en">عنوان انگلیسی:</label>
                    <input type="text" value="<?php print $title_en; ?>" class="form-control" id="title_en" name="title_en">
                </div>

                <div class="form-group">
                    <label for="category_id">گروه  :</label>
                    <select style="width: 150px;" name="category_id" dir="rtl" class="form-control" id="category_id">
                        <option value="0" <?php if($category_id==0) print 'selected'; ?>>--------</option>
                        <?php
                        $resultParentCategoryList = $main->getParentCategoryList();
                        while($rows = $main->getRow($resultParentCategoryList))
                        {
                            $sel1 = ($category_id == $rows['id']) ? 'selected' : '';
                            ?>
                            <option  <?php print $sel1; ?> value="<?php print $rows['id']; ?>">
                                <?php print $rows['title']; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sub_category_id">زیر گروه:</label>
                    <select style="width: 150px;" name="sub_category_id" dir="rtl" class="form-control" id="sub_category_id">
                        <option value="0" <?php if($sub_category_id==0) print 'selected'; ?>>------</option>
                        <?php
                        if($category_id > 0)
                        {
                            $resultParentCategoryList = $main->getParentCategoryList($category_id);
                            while ($rows = $main->getRow($resultParentCategoryList)) {
                                $sel2 = ($sub_category_id == $rows['id']) ? 'selected' : '';
                                ?>
                                <option <?php print $sel2; ?> value="<?php print $rows['id']; ?>">
                                    <?php print $rows['title']; ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="clearfix" style="margin-bottom: 10px;"></div>
<!---->
<!--                <div class="form-group">-->
<!--                    <label for="price">قیمت:</label>-->
<!--                    <input type="text" value="--><?php //print $price; ?><!--" class="form-control" id="price" name="price">-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label for="price_discount">قیمت تخفیف : </label>-->
<!--                    <input type="text" value="--><?php //print $price_discount; ?><!--" class="form-control" id="price_discount" name="price_discount">-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label for="model">مدل: </label>-->
<!--                    <input type="text" value="--><?php //print $model; ?><!--" class="form-control" id="model" name="model">-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label for="code">کد:</label>-->
<!--                    <input type="text" value="--><?php //print $code; ?><!--" class="form-control" id="code" name="code">-->
<!--                </div>-->
                <div class="form-group">
                    <lable for="status">وضعیت:</lable>
                    <select name="status" id="status">
                        <option value="-1" <?php if($status == -1) print 'selected';?>>-----</option>
                        <option value="1" <?php if($status == 1) print 'selected';?>>فعال</option>
                        <option value="0" <?php if($status == 0) print 'selected';?>>غیر فعال</option>
                    </select>
                </div>
                <div class="clearfix" style="margin-bottom: 10px;"></div>

                <div class="form-group">
                    <lable for="is_special">محصول ویژه:</lable>
                    <select name="is_special" id="is_special">
                        <option value="-1" <?php if($is_special == -1) print 'selected';?>>-----</option>
                        <option value="1" <?php if($is_special == 1) print 'selected';?>>بله</option>
                        <option value="0" <?php if($is_special == 0) print 'selected';?>>خیر</option>
                    </select>
                </div>

                <div class="clearfix" style="margin-bottom: 10px;"></div>
                <button data-toggle="tooltip" title="جستجو" type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                <button data-toggle="tooltip" title="ریست" onclick="redirect('?');" type="button" class="btn btn-info"><span class="glyphicon glyphicon-refresh"></span></button>
            </form>
            <?php
            if($resultPagination['totalRows'] == 0 && $where != '')
            {
                $main->setInfo('','رکوردی برای نمایش یافت نشد.');
            }

            $main->setSuccess('del-1','رکورد با موفقیت حذف شد.');
            $main->setDanger('del-0','چون این رکورد دارای فرزند میباشد امکان حذف نمیباشد .');
            ?>
            <input type="button" id="btn-delete-group" value="حذف گروهی" class="btn btn-danger">
            <div class="clearfix"></div>
            <br>
            <form method="post" action="" id="from-delete-group">
                <input type="hidden" name="btn_delete_group" value="1">
            <table class="table table-bordered">
                <tr class="text-center">
                    <td><?php $main->sortPaginationField($url,'ردیف ','id','<br><input type="checkbox" id="checkbox-all-delete">'); ?></td>
                    <td><?php $main->sortPaginationField($url,'عنوان ','title_fa') ?></td>
                    <td><?php $main->sortPaginationField($url,'عنوان انگلیسی','title_en') ?></td>
                    <td><?php $main->sortPaginationField($url,'گروه ','category_id') ?></td>
                    <td><?php $main->sortPaginationField($url,'زیرگروه ','sub_category_id') ?></td>
<!--                    <td>--><?php //$main->sortPaginationField($url,'قیمت ','price') ?><!--</td>-->
<!--                    <td>--><?php //$main->sortPaginationField($url,'قیمت تخفیف ','price_discount') ?><!--</td>-->
<!--                    <td>--><?php //$main->sortPaginationField($url,'مدل','model') ?><!--</td>-->
                    <td><?php $main->sortPaginationField($url,'کد ','code') ?></td>
                    <td><?php $main->sortPaginationField($url,' تاریخ ثبت ','date_created') ?></td>
                    <td><?php $main->sortPaginationField($url,' تاریخ ویرایش ','date_edit') ?></td>
                    <td><?php $main->sortPaginationField($url,' وضعیت نمایش ','status') ?></td>
                    <td><?php $main->sortPaginationField($url,' محصول ویژه ','is_special') ?></td>
                    <td>عملیات</td>
                </tr>
                <?php
                    $retID = $main->renderID($resultPagination['totalRows']);
                    while($rows = $main->getRow($resultPagination['result']))
                    {
                        $n = ($retID['opt'] == '+') ? $retID['n']++ : $retID['n']--;
                        $edit_url = "edit_product.php?id=$rows[id]&page=$main->page&$params";
                        ?>
                            <tr class="text-center">
                                <td>
                                    <input type="checkbox" value="<?php print $rows['id']; ?>" name="del_rows[]" class="checkbox-delete-group">
                                    <?php print $n;  ?>
                                </td>
                                <td>
                                    <?php print $rows['title_fa']; ?>
                                </td>
                                <td>
                                    <?php print $rows['title_en']; ?>
                                </td>
                                <td>
                                    <?php
                                        $cat = $main->getCategory($rows['category_id']);
                                        print $cat['title'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $subCat = $main->getCategory($rows['sub_category_id']);
                                    print $subCat['title'];
                                    ?>
                                </td>
<!--                                <td>-->
<!--                                    --><?php //print number_format($main->toFloat($rows['price'])); ?>
<!--                                </td>-->
<!--                                <td>-->
<!--                                    --><?php //print number_format($main->toFloat($rows['price_discount'])); ?>
<!--                                </td>-->
<!--                                <td>-->
<!--                                    --><?php //print $rows['model']; ?>
<!--                                </td>-->

                                <td><?php print $rows['code']; ?></td>
                                <td>
                                    <?php
                                        if($rows['date_created'] != '0000-00-00 00:00:00')
                                        {
                                            $date_create_array = explode(' ',$rows['date_created']);
                                            print $main->g2j($date_create_array[0]).' '.$date_create_array[1];
                                        }else
                                        {
                                            print '-';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($rows['date_edit'] != '0000-00-00 00:00:00')
                                    {
                                        $date_edit_array = explode(' ',$rows['date_edit']);
                                        print $main->g2j($date_edit_array[0]).' '.$date_edit_array[1];
                                    }else
                                    {
                                        print '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if($rows['status'] == 1)
                                        {
                                            ?>
                                            <button onclick="change_status(<?php print $rows['id'] ?>,0);" title="غیر فعال کردن محصول" data-toggle="tooltip" type="button" class="btn btn-success">
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </button>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <button onclick="change_status(<?php print $rows['id'] ?>,1);" title="فعال کردن محصول" data-toggle="tooltip" type="button" class="btn btn-danger">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($rows['is_special'] == 1)
                                    {
                                        ?>
                                        <button onclick="change_special(<?php print $rows['id'] ?>,0);" title="غیر ویژه کردن محصول" data-toggle="tooltip" type="button" class="btn btn-success">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </button>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <button onclick="change_special(<?php print $rows['id'] ?>,1);" title="ویژه کردن محصول" data-toggle="tooltip" type="button" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                        <?php
                                    }
                                    ?>

                                </td>
                                <td>
                                    <a href="<?php print $edit_url; ?>" data-toggle="tooltip" title="ویرایش" class="btn btn-success" >
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <button data-id="<?php print $rows['id']; ?>"  data-title="<?php print $rows['title_fa']; ?>" data-toggle="tooltip" title="حذف" type="button" class="btn btn-danger delete-row">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </td>
                            </tr>
                        <?php
                    }
                ?>
            </table>
            </form>

            <?php
                $main->renderPagination($url,$resultPagination['totalPage']);
            ?>


            <div class="text-center">
                <input value="بازگشت" type="button" onclick="redirect('index.php')" class="btn btn-info">
            </div>
            <?php
        }
        ?>

    </div>


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/lib.js"></script>
    <script>
        $(document).ready(function () {
            $('#category_id').select2();
            $('#sub_category_id').select2();



            $('.delete-row').click(function(){
                var data = $(this);
                $('#modalDelete').modal('show',data);
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
                redirect('<?php print $url."&page=$main->page" ?>'+'&del_id='+id);
            });

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


            $('#checkbox-all-delete').click(function(){
                var st = $(this).is(':checked');
                $('.checkbox-delete-group').each(function () {
                    $(this).prop('checked',st);
                });
            });


            $('#btn-delete-group').click(function() {
                if ($('.checkbox-delete-group:checked').length > 0)
                {
                    $('#modalDeleteAll').modal('show');
                }
            });


        });




        function change_status(id,val) {
            var url = '<?php print $url; ?>&st_id='+id+'&val='+val;
            redirect(url);
        }

        function change_special(id,val) {
            var url = '<?php print $url; ?>&special_id='+id+'&val='+val;
            redirect(url);
        }




    </script>
</body>
</html>