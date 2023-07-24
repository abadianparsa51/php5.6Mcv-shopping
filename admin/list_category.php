<?php
    require_once '../init.php';
    $title = $main->safeString($main->get('title'));
    if($main->get('parent_id') == '')
        $parent_id = -1;
    else
        $parent_id = $main->toInt($main->get('parent_id'));
    $params = "title=$title&parent_id=$parent_id";
    $url = "?".$params;


    $where = '';
    if($title != '')
        $where.= " AND title LIKE '%$title%' ";
    if($parent_id >= 0)
        $where.= " AND parent_id = '$parent_id' ";
    $main->setSortColumn(array('id','title'));
    $resultPagination  = $main->pagination('categories',$where);


    if($main->get('del_id') != '')
    {
        $resultDel = $main->deleteCategory($main->get('del_id'),$main->get('cid'),$main->get('sid'));
        $main->redirect("$url&page=$main->page&msg=del-{$resultDel}");
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
        ویرایش گروه ها و زیر گروه ها
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
                <b id="modal-delete-notice" class="text-danger" style="display: none;">
                </b>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">خیر</button>
                <button type="button" id="modal-delete-btn" class="btn btn-danger">بلی</button>
            </div>
        </div>
    </div>
</div>


    <div class="container" id="main">

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
            ?>
            <form class="form-inline" id="form-search" method="get" action="">
                <div class="form-group">
                    <label for="title">عنوان:</label>
                    <input type="text" value="<?php print $title; ?>" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="parent_id">گروه یا زیرگروه :</label>
                    <select name="parent_id" dir="rtl" class="form-control" id="parent_id">
                        <option value="-1" <?php if($parent_id==-1) print 'selected'; ?>>-------</option>
                        <option value="0" <?php if($parent_id==0) print 'selected'; ?>>گروه اصلی</option>
                        <?php
                        $resultParentCategoryList = $main->getParentCategoryList();
                        while($rows = $main->getRow($resultParentCategoryList))
                        {
                            $sel1 = ($parent_id == $rows['id']) ? 'selected' : '';
                            ?>
                            <option  <?php print $sel1; ?> value="<?php print $rows['id']; ?>">
                                -<?php print $rows['title']; ?>
                            </option>
                            <?php
                            $resultParentCategoryList2 = $main->getParentCategoryList($rows['id']);
                            while($rows2 = $main->getRow($resultParentCategoryList2))
                            {
                                $sel2 = ($parent_id == $rows2['id']) ? 'selected' : '';
                                ?>
                                <option <?php print $sel2; ?> value="<?php print $rows2['id']; ?>">
                                    --<?php print $rows2['title']; ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
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
            $main->setDanger('del-2','چون این رکورد دارای فرزند میباشد امکان حذف نمیباشد .');
            $main->setDanger('del-3','چون دارای محصول میباشد نمیتوان این رکورد را حذف کرد .');
            ?>
            <table class="table table-bordered">
                <tr class="text-center">
                    <td><?php $main->sortPaginationField($url,'ردیف','id') ?></td>
                    <td>
                        گروه والد
                    </td>
                    <td><?php $main->sortPaginationField($url,'عنوان','title') ?></td>
                    <td>عملیات</td>
                </tr>
                <?php
                    $retID = $main->renderID($resultPagination['totalRows']);
                    while($rows = $main->getRow($resultPagination['result']))
                    {
                        $n = ($retID['opt'] == '+') ? $retID['n']++ : $retID['n']--;
                        $edit_url = "edit_category.php?id=$rows[id]&page=$main->page&$params";
                        ?>
                            <tr class="text-center">
                                <td>
                                    <?php print $n;  ?>
                                </td>
                                <td>
                                    <?php
                                        if($rows['parent_id'] == 0)
                                        {
                                            print 'گروه اصلی';
                                            $category_id = $rows['id'];
                                            $sub_category_id = 0;
                                        }
                                        else
                                        {
                                            $subCat  = $main->getCategory($rows['parent_id']);
                                            $category_id = $rows['parent_id'];
                                            $sub_category_id = $rows['id'];
                                            print $subCat['title'];
                                        }
                                    ?>
                                </td>
                                <td><?php print $rows['title']; ?></td>
                                <td>
                                    <a href="<?php print $edit_url; ?>" data-toggle="tooltip" title="ویرایش" class="btn btn-success" >
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <button data-category-id="<?php print $category_id; ?>" data-sub-category-id="<?php print $sub_category_id; ?>" data-id="<?php print $rows['id']; ?>" data-product-count="<?php print $main->getCountProduct($category_id,$sub_category_id); ?>" data-child="<?php print $main->getCountChildForCategory($rows['id']); ?>" data-title="<?php print $rows['title']; ?>" data-toggle="tooltip" title="حذف" type="button" class="btn btn-danger delete-row">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </td>
                            </tr>
                        <?php
                    }
                ?>
            </table>


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
            $('#parent_id').select2();



            $('.delete-row').click(function(){
                var data = $(this);
                $('#modalDelete').modal('show',data);
            });


            $('#modalDelete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var title = button.data('title');
                var child = button.data('child');
                var product_count = button.data('product-count');
                var id = button.data('id');
                var category_id = button.data('category-id');
                var sub_category_id = button.data('sub-category-id');
                $(this).find('#modal-delete-title').html(title);
                $(this).find('#modal-delete-btn').attr('data-delete-id',id);
                $(this).find('#modal-delete-btn').attr('data-category-id',category_id);
                $(this).find('#modal-delete-btn').attr('data-sub-category-id',sub_category_id);
                if(child  > 0 )
                {
                    $(this).find('#modal-delete-notice').html(' <br>چون این رکورد دارای فرزند میباشد امکان حذف نمیباشد .').show();
                    $('#modal-delete-btn').attr('disabled','disabled');
                }
                else if(product_count > 0)
                {
                    $(this).find('#modal-delete-notice').html('<br>چون دارای محصول میباشد نمیتوان این رکورد را حذف کرد.').show();
                    $('#modal-delete-btn').attr('disabled','disabled');
                }
                else
                {
                    $(this).find('#modal-delete-notice').hide();
                    $('#modal-delete-btn').removeAttr('disabled');
                }
            });

            $('#modal-delete-btn').click(function () {
                var id = $(this).attr('data-delete-id');
                var cid = $(this).attr('data-category-id');
                var sid = $(this).attr('data-sub-category-id');
                redirect('<?php print $url."&page=$main->page" ?>'+'&del_id='+id+'&cid='+cid+'&sid='+sid);
            });


        });
    </script>
</body>
</html>