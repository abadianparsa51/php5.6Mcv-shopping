<?php
    require_once 'init.php';
?>
<!doctype html>
<html lang="en">
<head>
    <base href="<?php print $main->getBaseUrl(); ?>">
    <meta charset="UTF-8">
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
    <title><?php print $config['title']; ?></title>
    <meta name="keywords" content="<?php print $config['meta_keywords']; ?>">
    <meta name="description" content="<?php print $config['meta_description']; ?>">
    <link rel="shortcut icon" href="<?php echo str_replace('../','',$config['favicon']); ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/template.css">
</head>
<body>
    <div class="container-fluid" style="margin-top: 25px;">
        <?php require_once 'template/header.php';?>
    </div>
<!--    <div class="container-fluid" id="search-bar">-->
<!--        --><?php //require_once 'template/search-bar.php';?>
<!--        </div>-->
    <?php require_once 'template/nav.php'; ?>
    <div class="container-fluid">
    <?php require_once 'template/content.php'; ?>
    </div>
    <div class="container-fluid" id="footer">
        <?php require_once 'template/footer.php';?>
    </div>
    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/superfish.min.js"></script>
    <script src="js/lib.js"></script>
</body>
</html>