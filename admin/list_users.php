<?php
    require_once '../init.php';
    $email = $main->safeString($main->get('email'));
    $fn = $main->safeString($main->get('fn'));
    $ln = $main->safeString($main->get('ln'));
    $tel = $main->safeString($main->get('tel'));
    $mobile = $main->safeString($main->get('mobile'));

    if($main->get('status') == '')
        $status = -1;
    else
        $status = $main->toInt($main->get('status'));

    if($main->get('is_admin') == '')
        $is_admin = -1;
    else
        $is_admin = $main->toInt($main->get('is_admin'));

    $params = "email=$email&fn=$fn&ln=$ln";
    $params .= "&tel=$tel&mobile=$mobile&status=$status&is_admin=$is_admin";

    $url = "?".$params;


    $where = '';
    if($email != '')
        $where.= " AND email LIKE '%$email%' ";
    if($fn != '')
        $where.= " AND fn LIKE '%$fn%' ";
    if($ln != '')
        $where.= " AND ln LIKE '%$ln%' ";
    if($tel != '')
        $where.= " AND tel LIKE '%$tel%' ";
    if($mobile != '')
        $where.= " AND mobile LIKE '%$mobile%' ";
    if($status != -1)
        $where.= " AND status = '$status' ";
    if($is_admin != -1)
        $where.= " AND is_admin = '$is_admin' ";


    $main->setSortColumn(array('id','email','fn','ln','tel'
        ,'mobile','status','is_admin','last_login','reg_date_time'));
    $resultPagination  = $main->pagination('users',$where);


    if($main->get('del_id') != '')
    {
        $main->deleteUser($main->get('del_id'));
        $main->redirect("$url&page=$main->page&msg=del");
    }


    if($main->get('st_id') != '' && $main->get('val') != '' )
    {
        $main->changeStatusUser($main->get('st_id'),$main->get('val'));
        $main->redirect("$url&page=$main->page&msg=st");
    }

    if($main->get('user_id') != '' && $main->get('val') != '' )
    {
        $main->changeUserType($main->get('user_id'),$main->get('val'));
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
        مدیریت کاربران
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
            $main->setSuccess('st','با موفقیت وضیعت کاربر تغییر یافت.');
            $main->setSuccess('special','با موفقیت نوع کاربر تغییر یافت.');
            ?>
            <form class="form-inline" id="form-search" method="get" action="">
                <div class="form-group">
                    <label for="email">ایمیل:</label>
                    <input type="text" value="<?php print $email; ?>" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="fn">نام:</label>
                    <input type="text" value="<?php print $fn; ?>" class="form-control" id="fn" name="fn">
                </div>
                <div class="form-group">
                    <label for="ln">نام خانوادگی:</label>
                    <input type="text" value="<?php print $ln; ?>" class="form-control" id="ln" name="ln">
                </div>
                <div class="form-group">
                    <label for="tel">تلفن : </label>
                    <input type="text" value="<?php print $tel; ?>" class="form-control" id="tel" name="tel">
                </div>
                <div class="form-group">
                    <label for="mobile">موبایل: </label>
                    <input type="text" value="<?php print $mobile; ?>" class="form-control" id="mobile" name="mobile">
                </div>
                <div class="clearfix" style="margin-bottom: 10px;"></div>

                <div class="form-group">
                    <lable for="status">وضیعت کاربر:</lable>
                    <select name="status" id="status">
                        <option value="-1" <?php if($status == -1) print 'selected';?>>-----</option>
                        <option value="1" <?php if($status == 1) print 'selected';?>>فعال</option>
                        <option value="0" <?php if($status == 0) print 'selected';?>>غیر فعال</option>
                    </select>
                </div>

                <div class="form-group">
                    <lable for="is_admin">نوع کاربر:</lable>
                    <select name="is_admin" id="is_admin">
                        <option value="-1" <?php if($is_admin == -1) print 'selected';?>>
                            همه کاربرها
                        </option>
                        <option value="1" <?php if($is_admin == 1) print 'selected';?>>
                            مدیران
                        </option>
                        <option value="0" <?php if($is_admin == 0) print 'selected';?>>
                            کاربران
                        </option>
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
            ?>
            <div class="clearfix"></div>
            <br>
            <form method="post" action="">
            <table class="table table-bordered">
                <tr class="text-center">
                    <td><?php $main->sortPaginationField($url,'ردیف ','id'); ?></td>
                    <td><?php $main->sortPaginationField($url,'ایمیل ','email') ?></td>
                    <td><?php $main->sortPaginationField($url,'نام','fn') ?></td>
                    <td><?php $main->sortPaginationField($url,'نام خانوادگی ','ln') ?></td>
                    <td><?php $main->sortPaginationField($url,'تلفن ','tel') ?></td>
                    <td><?php $main->sortPaginationField($url,'موبایل ','mobile') ?></td>
                    <td><?php $main->sortPaginationField($url,' تاریخ ثبت نام ','reg_date_time') ?></td>
                    <td><?php $main->sortPaginationField($url,' تاریخ آخرین ورود ','last_login') ?></td>
                    <td><?php $main->sortPaginationField($url,' وضیعت کاربر ','status') ?></td>
                    <td><?php $main->sortPaginationField($url,' نوع کاربر ','is_admin') ?></td>
                    <td>عملیات</td>
                </tr>
                <?php
                    $retID = $main->renderID($resultPagination['totalRows']);
                    while($rows = $main->getRow($resultPagination['result']))
                    {
                        $n = ($retID['opt'] == '+') ? $retID['n']++ : $retID['n']--;
                        $edit_url = "edit_user.php?id=$rows[id]&page=$main->page&$params";
                        ?>
                            <tr class="text-center">
                                <td>
                                    <?php print $n;  ?>
                                </td>
                                <td>
                                    <?php print $rows['email']; ?>
                                </td>
                                <td>
                                    <?php print $rows['fn']; ?>
                                </td>
                                <td>
                                    <?php print $rows['ln']; ?>
                                </td>
                                <td>
                                    <?php print $rows['tel']; ?>
                                </td>

                                <td><?php print $rows['mobile']; ?></td>
                                <td>
                                    <?php
                                        if($rows['reg_date_time'] != '0000-00-00 00:00:00')
                                        {
                                            $date_create_array = explode(' ',$rows['reg_date_time']);
                                            print $main->g2j($date_create_array[0]).' '.$date_create_array[1];
                                        }else
                                        {
                                            print '-';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($rows['last_login'] != '0000-00-00 00:00:00')
                                    {
                                        $date_edit_array = explode(' ',$rows['last_login']);
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
                                            <button onclick="change_status(<?php print $rows['id'] ?>,0);" title="غیر فعال کردن کاربر" data-toggle="tooltip" type="button" class="btn btn-success">
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </button>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <button onclick="change_status(<?php print $rows['id'] ?>,1);" title="فعال کردن کاربر" data-toggle="tooltip" type="button" class="btn btn-danger">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($rows['is_admin'] == 1)
                                    {
                                        ?>
                                        <button onclick="change_user_type(<?php print $rows['id'] ?>,0);" title="تبدیل مدیر به کاربر" data-toggle="tooltip" type="button" class="btn btn-success">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </button>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <button onclick="change_user_type(<?php print $rows['id'] ?>,1);" title="تبدیل کاربر به مدیر" data-toggle="tooltip" type="button" class="btn btn-danger">
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
                                    <button data-id="<?php print $rows['id']; ?>"  data-title="<?php print $rows['email']; ?>" data-toggle="tooltip" title="حذف" type="button" class="btn btn-danger delete-row">
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




        });




        function change_status(id,val) {
            var url = '<?php print $url; ?>&st_id='+id+'&val='+val;
            redirect(url);
        }

        function change_user_type(id,val) {
            var url = '<?php print $url; ?>&user_id='+id+'&val='+val;
            redirect(url);
        }




    </script>
</body>
</html>