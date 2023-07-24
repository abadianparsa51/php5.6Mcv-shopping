<?php defined('DB_USERNAME') or die;
    $search = $main->safeString($main->get('search'));
?>
<div class="container">
    <div class="col-lg-6" id="logo">
        <a href="#">
            <img src="images/logo.png" alt="logo">
        </a>
    </div>
    <div class="col-lg-6" style="float: left">
        <form action="search.php" method="get" id="form-search">
            <div id="form-search-holder">
                <div class="pull-right">
                    <input value="<?php print $search; ?>" name="search" type="text"
                           placeholder="برای جستجو کلمه ای را وارد کنید ..." id="keyword-form-search"

                </div>
                <div class="pull-right">
                    <button type="submit" id="submit-form-search">
                        <span class="fa fa-search"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
<!--    <div class="col-lg-3">-->
<!--        <div id="cart-btn">-->
<!--            <span class="fa fa-shopping-cart fa-2x"></span>-->
<!--            <span id="cart-count">-->
<!--                --><?php
//                $count_item = isset($_SESSION['cart_items']) ? count($_SESSION['cart_items']) : '0';
//                print $count_item;
//                ?>
<!--            </span>-->
<!--            <span> کالا(ها)-->
<!--                --->
<!--            </span>-->
<!--            <span id="cart-price">-->
<!--                --><?php
//                $total_price = isset($_SESSION['all_price_total'])
//                    ? array_sum($_SESSION['all_price_total']) : '0';
//                print number_format($total_price);
//                ?>
<!--            </span><span>ریال</span>-->
<!--            <span class="fa fa-chevron-down"></span>-->
<!--        </div>-->
<!--        <div id="cart-box">-->
<!--           <table class="table table-bordered" id="cart-item-list">-->
<!--               <tr class="text-center">-->
<!--                   <td> محصول</td>-->
<!--                   <td>تعداد</td>-->
<!--                   <td>قیمت</td>-->
<!--               </tr>-->
<!--               --><?php
//                    $main->getCartItemList();
//               ?>
<!--           </table>-->
<!--            <a class="btn btn-success btn-block" href="checkout.php">تسویه حساب</a>-->
<!--            <a class="btn btn-info btn-block" href="cart.php">سبد خرید</a>-->
<!--        </div>-->
<!--    </div>-->
</div>