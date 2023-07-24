<?php defined('DB_USERNAME') or die;
$search = $main->safeString($main->get('search'));
?>
<div class="container-fluid">
    <div class="col-sm-2" id="logo">
        <a href="#">
            <img src="media/image/logo.jpg">
        </a>
    </div>
    <div class="col-sm-7"></div>
    <div class="col-sm-3" style="margin-left: 0; margin-top: 10px;">
        <form action="search.php" method="get" id="form-search">
            <div id="form-search-holder">
                <div class="pull-right">
                    <input type="text" class="form-control"
                           style="border-color: whitesmoke;
                               background: #dfdfdf;border-radius: 20px;
                               height: 25px;width: 250px;" placeholder="Search.." name="search">
                </div>

            </div>
        </form>
    </div>

</div>