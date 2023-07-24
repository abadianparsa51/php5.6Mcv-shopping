<?php
    require_once '../init.php';

    $title = $main->safeString($main->get('title'));
    if($main->get('parent_id') == '')
        $parent_id = -1;
    else
        $parent_id = $main->toInt($main->get('parent_id'));
    $url = "title=$title&parent_id=$parent_id&page=$main->page";

    $id = $main->toInt($main->get('id'));
    $row  = $main->getCategory($id);


    if($main->post('btn_save'))
    {
        $resultSave = $main->saveCategory($id);
        if($resultSave > 0)
            $main->redirect("?msg=ok&$url&id=$id");
        else
            $main->redirect("?msg=error&$url&id=$id");
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
        ویرایش گروه یا زیر گروه
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/template.css">

</head>
<body>


    <div class="container" id="main">

        <?php
            $main->setSuccess('ok','با موفقیت ویرایش شد.');
            $main->setDanger('error','عنوان تکراری میباشد.');
        ?>

        <form id="frm-add" class="form-horizontal" method="post" action="">
            <div class="form-group">
                <label for="parent_id" class="col-sm-2 control-label">
والد :
                </label>
                <div class="col-sm-10">
                    <select <?php if($row['parent_id'] == 0) print 'disabled';  ?> name="parent_id" dir="rtl" class="form-control" id="parent_id">
                        <?php
                            if($row['parent_id'] == 0)
                            {
                        ?>
                                <option <?php if ($row['parent_id'] == 0) print 'selected';  ?> > گروه اصلی</option>

                                <?php
                            }
                            $resultParentCategoryList = $main->getParentCategoryList();
                            while($rows = $main->getRow($resultParentCategoryList))
                            {
                               $sel1 = ($rows['id'] == $row['parent_id']) ? 'selected' : '';

                                ?>
                                <option value="<?php print $rows['id']; ?>" <?php echo $sel1?>>
                                    -<?php print $rows['title']; ?>
                                </option>
                                <?php
                                $resultParentCategoryList2 = $main->getParentCategoryList($rows['id']);
                                while($rows2 = $main->getRow($resultParentCategoryList2))
                                {
                                    $sel2 = ($rows['id'] == $row['parent_id']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php print $rows2['id']; ?>" <?php //echo $sel2?>>
                                        --<?php print $rows2['title']; ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">
                    عنوان :
                </label>
                <div class="col-sm-10">
                    <input value="<?php print $row['title']; ?>" type="text" class="form-control" id="title" name="title">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-success" value="ذخیره" name="btn_save">
                    <input onclick="redirect('list_category.php?<?php print $url; ?>');" type="button" class="btn btn-danger" value="بازگشت">
                </div>
            </div>
        </form>


    </div>


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/lib.js"></script>
    <script>
        $(document).ready(function () {
            $('#parent_id').select2();
        });
    </script>
</body>
</html>