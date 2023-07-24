<?php
    $currentPage = $_SERVER['PHP_SELF'];
?>
<nav class="navbar navbar-default" id="myNav" style="margin-top: 20px;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-nav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <div class="collapse navbar-collapse" id="bs-nav">
            <ul class="nav navbar-nav" id="top-menu">
                <li class="<?php if(stristr($currentPage,'index.php')) print 'active'; ?>">
                    <a href="index.php">خانه <span class="sr-only">(current)</span></a>
                </li>
                <?php
                $resultMainCategories = $main->getCategories();
                while($catRow = $main->getRow($resultMainCategories))
                {
                    $resultSubCat = $main->getCategories($catRow['id']);
                    $url = $main->getBaseUrl().'list/'.$catRow['id'].'/'.$main->createSeoUrl($catRow['title']).'/';
                    ?>
                    <li class="dropdown">
                        <a href="<?php print $url; ?>">
                            <?php
                            print $catRow['title'];
                            if($resultSubCat->num_rows > 0)
                            {
                            ?>
                                <span class="caret"></span>
                            <?php
                            }
                            ?>
                        </a>
                        <?php
                        if($resultSubCat->num_rows > 0)
                        {
                        ?>
                            <ul class="dropdown-menu" >
                            <?php
                            while($subCatRow = $main->getRow($resultSubCat))
                            {
                                $url2 = $main->getBaseUrl().'list/'.$catRow['id'].'/'.$subCatRow['id'].'/'.$main->createSeoUrl($catRow['title'])
                                    .'/'.$main->createSeoUrl($subCatRow['title']).'/';
                                ?>
                                <li><a href="<?php print $url2 ?>"><?php print $subCatRow['title'] ?></a></li>
                            <?php
                            }
                            ?>
                            </ul>
                        <?php
                        }
                        ?>
                    </li>
                <?php
                }
                ?>
                <li><a href="about-us.php">
                  درباره ما
                    </a> </li>
            </ul>
            <ul dir="ltr" style="margin-top: 13px;">
                <a href="login.php">
                    <i style="font-size: 22px;color: whitesmoke" class="fa fa-user-circle" aria-hidden="true"></i></a>
                <a href="register.php" style="margin-left: 20px;" ><i style="font-size: 22px;color: whitesmoke" class="fa fa-registered" aria-hidden="true"></i></a>

            </ul>
        </div>
    </div>
    </div>
</nav>
