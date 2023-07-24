<?php
require_once 'init.php';
$do = $main->post('do');
if( $do == 'checkEmail')
{
    $email = $main->safeString($main->post('email'));
    print $main->toInt($main->checkUserEmail($email));
}
else if ($do == 'getProAjax')
{
    $data = array();
    $pro = $main->getProduct($main->post('id'));
    if(isset($pro['id']))
    {
        $data['status'] = '1';
        $data['title'] = $pro['title_fa'];
        $img = str_replace('../','',$pro['thumb_image']);
        $data['img'] = "<img class=\"img-responsive\" src=\"$img\" alt=\"$pro[title_fa]\">";
        $data['desc'] = mb_substr($pro['short_content'],0,200,'UTF-8') . ' ...';
    }
    else
    {
        $data['status'] = '0';
    }
    print json_encode($data,JSON_UNESCAPED_UNICODE);
}
else if ($do == 'addToCart')
{
    $ret = array();
    $num = ($main->post('num') == '') ? 1 : $main->toInt($main->post('num'));
    $id = $main->toInt($main->post('id'));
    if($id > 0 && $num > 0)
    {
        $pro = $main->getProduct($id);
        if(isset($pro['id']))
        {
            if($pro['price_discount'] == '' || $pro['price_discount'] == '0' )
            {
                $price = $pro['price'];
            }
            else
                $price = $pro['price_discount'];

            if($price > 0)
            {
                $_SESSION['cart_items'][$id]['title'] = $pro['title_fa'];
                $_SESSION['cart_items'][$id]['num'] = $num;
                $_SESSION['cart_items'][$id]['price'] = $price;
                $_SESSION['cart_items'][$id]['total_price'] = $num * $price;
                $_SESSION['all_price_total'][$id] = $num * $price;
                $ret['status'] = 'ok';
                $html = '<tr class="text-center" id="cart-pro-'.$id.'">';
                $html .= "<td>$pro[title_fa]</td>";
                $html .= "<td>$num</td>";
                $html .= "<td>".number_format($num * $price)."</td>";
                $html .= '</tr>';
                $ret['row'] = $html;
                $ret['check_id'] = $id;

            }
            else
                $ret['status'] = 'error';

        }
        else
            $ret['status'] = 'error';
    }
    else
        $ret['status'] = 'error';
    print json_encode($ret,JSON_UNESCAPED_UNICODE);
}
else if ($do == 'getUpdateCart')
{
    $ret = array();
    $ret['count'] = isset($_SESSION['cart_items']) ? count($_SESSION['cart_items']) : '0';
    $total_price = isset($_SESSION['all_price_total'])
        ? array_sum($_SESSION['all_price_total']) : '0';
    $ret['price'] = number_format($total_price);
    print json_encode($ret,JSON_UNESCAPED_UNICODE);
}
?>