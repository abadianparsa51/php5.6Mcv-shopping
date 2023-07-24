<?php
    require_once '../init.php';
    $code = $main->safeString($main->get('code'));
    if($main->get('status') == '')
        $status = -1;
    else
        $status = $main->toInt($main->get('status'));

    $params = "code=$code&status=$status";

    $url = "?".$params;


    $where = '';
    if($code != '')
        $where.= " AND code LIKE '%$code%' ";
    if($status != -1)
        $where.= " AND status = '$status' ";

    $main->setSortColumn(array('id','code','user_id','status','is_pay'
        ,'order_date'));
    $resultPagination  = $main->pagination('orders',$where);


    if($main->get('del_id') != '')
    {
        $main->deleteOrder($main->get('del_id'));
        $main->redirect("$url&page=$main->page&msg=del");
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
        لیست سفارشات
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
            ?>
            <form class="form-inline" id="form-search" method="get" action="">
                <div class="form-group">
                    <label for="code">کد سفارش : </label>
                    <input type="text" value="<?php print $code; ?>" class="form-control" id="code" name="code">
                </div>
                <div class="form-group">
                    <lable for="status">وضیعت سفارش:</lable>
                    <select name="status" id="status">
                        <option value="-1" <?php if($status == -1) print 'selected';?>>-----</option>
                        <option value="1" <?php if($status == 1) print 'selected';?>>در حال برسی</option>
                        <option value="2" <?php if($status == 2) print 'selected';?>>در انتظار پرداخت</option>
                        <option value="3" <?php if($status == 3) print 'selected';?>>پرداخت شده</option>
                        <option value="4" <?php if($status == 4) print 'selected';?>>کنسل شده</option>
                        <option value="5" <?php if($status == 5) print 'selected';?>>ارسال شده</option>
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
            <div class="clearfix"></div>
            <br>
            <table class="table table-bordered">
                <tr class="text-center">
                    <td><?php $main->sortPaginationField($url,'ردیف ','id');?></td>
                    <td><?php $main->sortPaginationField($url,'کد سفارش ','code') ?></td>
                    <td><?php $main->sortPaginationField($url,'نام کاربر','user_id') ?></td>
                    <td>
                        مبلغ سفارش
                        (ریال)
                    </td>
                    <td><?php $main->sortPaginationField($url,'وضیعت سفارش ','status') ?></td>
                    <td><?php $main->sortPaginationField($url,'وضیعت پرداخت ','is_pay') ?></td>
                    <td><?php $main->sortPaginationField($url,' تاریخ سفارش ','order_date') ?></td>
                    <td>عملیات</td>
                </tr>
                <?php
                    $retID = $main->renderID($resultPagination['totalRows']);
                    while($rows = $main->getRow($resultPagination['result']))
                    {
                        $n = ($retID['opt'] == '+') ? $retID['n']++ : $retID['n']--;
                        $e_url = "view_order_items.php?id=$rows[id]";
                        $user = $main->getUser($rows['user_id']);
                        ?>
                            <tr class="text-center">
                                <td>
                                    <?php print $n;  ?>
                                </td>
                                <td>
                                    <?php print $rows['code']; ?>
                                </td>
                                <td>
                                    <a href="edit_user.php?id=<?php print $rows['user_id'] ?>" target="_blank">
                                        <?php print $user['email']; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php
                                        print number_format($main->getTotalOrderPrice($rows['id']));
                                    ?>
                                </td>
                                <td>
                                    <?php $main->getStatusOrder($rows['status']); ?>
                                </td>

                                <td>
                                    <?php
                                        if($rows['is_pay'] == 1)
                                        {
                                            print "پرداخت شده";
                                        }
                                        else
                                            print '-';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $order_date_array = explode(' ',$rows['order_date']);
                                        print $main->g2j($order_date_array[0]).' '.$order_date_array[1];
                                    ?>
                                </td>
                                <td>
                                    <a target="_blank" href="<?php print $e_url; ?>" data-toggle="tooltip" title="نمایش جزئیات سفارش" class="btn btn-success" >
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                    <button data-id="<?php print $rows['id']; ?>"  data-title="<?php print $rows['code']; ?>" data-toggle="tooltip" title="حذف" type="button" class="btn btn-danger delete-row">
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








    </script>
</body>
</html>