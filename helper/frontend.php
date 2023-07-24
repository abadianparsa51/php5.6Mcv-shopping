<?php
defined('DB_HOST') or die;
class Frontend extends Base
{

    public function getCategories($parent_id = 0)
    {
        $parent_id = $this->toInt($parent_id);
        $q = "SELECT * FROM categories WHERE parent_id = '$parent_id' ORDER BY title ASC ";
        return $this->query($q);
    }

    public function getCategory($id)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM categories WHERE `id` = '$id' ";
        $r = $this->query($q);
        return $this->getRow($r);
    }

    public function getSpecialProducts($n = 4){
        $n = $this->toInt($n);
        $q = "SELECT * FROM products WHERE `is_special` = 1 AND `status` = 1 ORDER BY id DESC LIMIT 0,$n";
        return $this->query($q);
    }
    public function getProduct($id)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM products WHERE `id` = '$id' AND `status` = 1 ";
        $r = $this->query($q);
        return $this->getRow($r);
    }

    public function userRegister($fn,$ln,$email,$password,$password2)
    {
        $date=date('Y-m-d H:i:s');
        $fn=$this->safeString($fn);
        $ln=$this->safeString($ln);
        $email=$this->safeString($email);
        $password=$this->safeString($password);
        $password2=$this->safeString($password2);
        $status= 1;
        $is_admin= 0;

        if($this->checkUserEmail($email))
        {
            if($password == $password2)
            {
                $q="INSERT INTO users 
                (fn,ln,email,password,reg_date_time,status,is_admin)
                 VALUES ('$fn','$ln','$email','$password','$date','$status','$is_admin')";
                return $this->query($q);

            }
            else
                return -1;
        }
        else
            return -2;

    }


    public function userLogin($email,$password)
    {
        $email=$this->safeString($email);
        $password=$this->safeString($password);
        $q="SELECT * FROM users WHERE email= '$email' AND password= '$password' AND status= '1' AND is_admin= '0'";
        $result=$this->query($q);
        $row=$this->getRow($result);
        $this->freeResult($result);
        if(isset($row['id']))
        {
            $_SESSION['user_id']=$row['id'];
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function userIsLogin()
    {
        if(isset($_SESSION['user_id']))
            return true;
        else
            return false;
    }

    public function getUserProfile()
    {
        $id=$_SESSION['user_id'];
        $q="SELECT * FROM users WHERE id='$id'";
        $r=$this->query($q);
        $row=$this->getRow($r);
        $this->freeResult($r);
        return $row;
    }

    public function beforeUserLogout()
    {
        $id = $_SESSION['user_id'];
        $currentDateTime = date('Y-m-d H:i:s');
        $q = "UPDATE users SET last_login = '$currentDateTime' WHERE id = '$id'";
        $this->query($q);
    }

    public function accountRecovery($email)
    {
        $email=$this->safeString($email);
        $q="SELECT * FROM users WHERE email= '$email' AND status= '1' and is_admin = '0'";
        $r=$this->query($q);
        $row=$this->getRow($r);
        $this->freeResult($r);
        if(isset($row['id']))
        {
            return $row;
        }
        else
            return 0;
    }

    public function saveUserProfile()
    {
        $id=$_SESSION['user_id'];
        $currentProfile = $this->getUserProfile();
        $fn=$this->safeString($this->post('fn'));
        $ln=$this->safeString($this->post('ln'));
        $tel=$this->safeString($this->post('tel'));
        $mobile=$this->safeString($this->post('mobile'));
        $address=$this->safeString($this->post('address'));
        $email = $this->safeString($this->post('email'));
        $pass1 = $this->safeString($this->post('pass1'));
        $pass2 = $this->safeString($this->post('pass2'));
        $pass3 = $this->safeString($this->post('pass3'));

        $q="UPDATE users SET fn='$fn',ln = '$ln',
                tel = '$tel' , mobile = '$mobile' , address = '$address' ";

        if ($currentProfile['email'] != $email) {

            if ($this->checkUserEmail($email)) {
                $q .= " , email = '$email' ";
            } else
                return -1;
        }

        if ($pass1 != '' && $pass2 != '' && $pass3 != '') {
            if ($currentProfile['password'] == $pass1) {
                if ($pass2 == $pass3) {
                    $q .= " , password = '$pass3' ";
                } else
                    return -3;
            } else
                return -2;
        }

        if ($currentProfile['avatar'] == '') {
            $resultUpload = $this->uploadImage('avatar', 'avatars');
            if ($resultUpload > 1) {
                if (!is_int($resultUpload)) {
                    //ok
                    $q .= ",avatar = 'avatars/$resultUpload' ";
                } else {
                    if ($resultUpload == 2)
                        return -4;
                    elseif ($resultUpload == 3)
                        return -5;

                }
            }
        }

        $q .= " WHERE id = '$id'";
        return $this->query($q);

    }

    public function deleteUserProfileAvatar()
    {
        $id = $_SESSION['user_id'];
        $currentProfile = $this->getUserProfile();
        $path = $currentProfile['avatar'];
        if ($currentProfile['avatar'] != '' && file_exists($path)) {
            unlink($path);
        }
        $q = "UPDATE users SET avatar = '' WHERE id = '$id'";
        $this->query($q);
    }

    public function getProductImages($id)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM product_image WHERE product_id = '$id'";
        return $this->query($q);
    }

    public function getLastProducts($n = 4){
        $n = $this->toInt($n);
        $q = "SELECT * FROM products WHERE `status` = 1 ORDER BY id DESC LIMIT 0,$n";
        return $this->query($q);
    }

    public function getCountProduct($cat,$sub)
    {
        $cat = $this->toInt($cat);
        $sub = $this->toInt($sub);
        $q = "SELECT COUNT(*) AS n FROM products WHERE
              category_id = '$cat' AND sub_category_id = '$sub' AND status = '1' ";
        $r = $this->query($q);
        return $this->getRow($r)['n'];
    }


    public function getListProducts($cat,$sub,$m=12)
    {
        $m = $this->toInt($m);
        $cat = $this->toInt($cat);
        $sub = $this->toInt($sub);
        $w = '';
        if($sub > 0)
            $w .= " AND sub_category_id = '$sub' ";
        $q = "SELECT COUNT(*) as n FROM products WHERE `status` = 1 AND category_id = '$cat'
              $w
              ORDER BY id DESC ";
        $r= $this->query($q);
        $rowCount = $this->getRow($r);
        $totalRows = $rowCount['n'];
        $totalPage = ceil($totalRows / $m);
        $n = ($m * $this->page) - $m;
        $q2 = "SELECT * FROM products WHERE `status` = 1 AND category_id = '$cat'
              $w
              ORDER BY id DESC LIMIT $n,$m";
        $ret = array();
        $ret['totalRows'] = $totalRows;
        $ret['totalPage'] = $totalPage;
        $ret['result'] = $this->query($q2);
        return $ret;
    }


    public function getSearchProducts($title,$cat,$sub,$m=12)
    {
        $m = $this->toInt($m);
        $title = $this->safeString($title);
        $cat = $this->toInt($cat);
        $sub = $this->toInt($sub);
        $w = "  WHERE `status` = 1  ";
        if($title != '')
            $w .= " AND title_fa LIKE '%$title%' ";
        if($cat > 0)
            $w .= " AND category_id = '$cat' ";
        if($sub > 0)
            $w .= " AND sub_category_id = '$sub' ";

        $q = "SELECT COUNT(*) as n FROM products $w
              ORDER BY id DESC ";
        $r= $this->query($q);
        $rowCount = $this->getRow($r);
        $totalRows = $rowCount['n'];
        $totalPage = ceil($totalRows / $m);
        $n = ($m * $this->page) - $m;
        $q2 = "SELECT * FROM products $w
              ORDER BY id DESC LIMIT $n,$m";
        $ret = array();
        $ret['totalRows'] = $totalRows;
        $ret['totalPage'] = $totalPage;
        $ret['result'] = $this->query($q2);
        return $ret;
    }

    public function getSliderList()
    {
        $q = "SELECT * FROM slider ";
        return $this->query($q);
    }


    public function getCartItemList()
    {
        $html = '';
        if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0)
        {
            foreach ($_SESSION['cart_items'] as $k => $val)
            {
                $html .= '<tr class="text-center" id="cart-pro-'.$k.'">';
                $html .= "<td>$val[title]</td>";
                $html .= "<td>$val[num]</td>";
                $html .= "<td>".number_format($val['total_price'])."</td>";
                $html .= '</tr>';
            }
        }
        else
        {
            $html = '<tr class="text-center" id="cart-no-item">';
            $html .= '<td colspan="3">محصولی در سبد خرید شما نمی باشد.</td>';
            $html .= '</tr>';
        }
        print $html;
    }

    public function regOrder()
    {
        $user_id = $_SESSION['user_id'];
        $currentUser = $this->getUserProfile();
        $code = str_shuffle(strtotime(date("YmdHis")). mt_rand(0000,9999));
        $order_date = date("Y-m-d H:i:s");
        $q1 = "INSERT INTO `orders` VALUES ('NULL','$code','$user_id','$order_date','1','0','0')";
        $order_id = $this->query($q1);
        foreach ($_SESSION['cart_items'] as $k => $val)
        {
            $p = $val['price'];
            $num = $val['num'];
            $q2 = "INSERT INTO `order_items` VALUES ('NULL','$order_id','$k','$p','$num')  ";
            $this->query($q2);
        }
        unset($_SESSION['cart_items']);
        unset($_SESSION['all_price_total']);
        $msg = "سفارش شما با کد ";
        $msg.= $code;
        $msg .= " در سایت ثبت شد. ";
        if($currentUser['mobile']!='')
            $this->sendSms($currentUser['mobile'],$msg);
    }

    public function deleteOrder($id)
    {
        $user_id = $_SESSION['user_id'];
        $id = $this->toInt($id);
        $q1 = "DELETE FROM orders WHERE id = '$id' AND user_id = '$user_id'";
        $this->query($q1);
        $q2 = "DELETE FROM order_items WHERE order_id = '$id' AND user_id = '$user_id' ";
        $this->query($q2);
        $q3 = "DELETE FROM pay_info WHERE order_id = '$id' AND user_id = '$user_id' ";
        $this->query($q3);
    }


    public function getOrder($id)
    {
        $user_id = $_SESSION['user_id'];
        $id = $this->toInt($id);
        $q = "SELECT * FROM orders WHERE id = '$id' AND user_id = '$user_id' ";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        return $row;
    }



}