<?php
    require_once '../init.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        مدیریت اسلاید ها
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/template.css">

</head>
<body>



    <div class="container-fluid" id="main">
            <table class="table table-bordered">
                <tr class="text-center">
                    <td>عنوان</td>
                    <td>عملیات</td>
                </tr>
                <?php
                    $q = "SELECT * FROM slider ";
                    $r = $main->query($q);
                    while($rows = $main->getRow($r))
                    {
                        $edit_url = "edit_slide.php?id=$rows[id]";
                        ?>
                            <tr class="text-center">
                                <td>
                                    <?php print $rows['title']; ?>
                                </td>
                                <td>
                                    <a href="<?php print $edit_url; ?>" data-toggle="tooltip" title="ویرایش" class="btn btn-success" >
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                            </tr>
                        <?php
                    }
                ?>
            </table>
            <div class="text-center">
                <input value="بازگشت" type="button" onclick="redirect('index.php')" class="btn btn-info">
            </div>


    </div>


    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/lib.js"></script>
    <script>
        $(document).ready(function () {






        });

    </script>
</body>
</html>