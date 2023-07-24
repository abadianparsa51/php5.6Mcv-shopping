<?php
defined('DB_HOST') or die;
class Backend extends Base
{

    public function login($email, $password)
    {
        $email = $this->safeString($email);
        $password = $this->safeString($password);
        $q = "SELECT * FROM users WHERE email = '$email' AND password = '$password'
                AND status = '1' AND is_admin = '1' ";
        $result = $this->query($q);
        $row = $this->getRow($result);
        $this->freeResult($result);
        if (isset($row['id'])) {
            //admin login ok
            $_SESSION['admin_id'] = $row['id'];
            return true;
        } else {
            //admin login error
            return false;
        }
    }

    public function isLogin()
    {
        if (isset($_SESSION['admin_id']))
            return true;
        else
            return false;
    }

    public function beforeLogout()
    {
        $id = $_SESSION['admin_id'];
        $currentDateTime = date('Y-m-d H:i:s');
        $q = "UPDATE users SET last_login = '$currentDateTime' WHERE id = '$id'";
        $this->query($q);
    }

    public function getProfile()
    {
        $id = $_SESSION['admin_id'];
        $q = "SELECT * FROM users WHERE id = '$id'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        return $row;
    }

    public function saveProfile()
    {
        $id = $_SESSION['admin_id'];
        $currentProfile = $this->getProfile();
        $fn = $this->safeString($this->post('fn'));
        $ln = $this->safeString($this->post('ln'));
        $tel = $this->safeString($this->post('tel'));
        $mobile = $this->safeString($this->post('mobile'));
        $address = $this->safeString($this->post('address'));
        $email = $this->safeString($this->post('email'));
        $pass1 = $this->safeString($this->post('pass1'));
        $pass2 = $this->safeString($this->post('pass2'));
        $pass3 = $this->safeString($this->post('pass3'));

        $q = "UPDATE users SET fn = '$fn' , ln = '$ln'
            ,tel = '$tel' , mobile = '$mobile' , address = '$address' ";


        if ($currentProfile['email'] != $email) {
            //user change
            if ($this->checkUserEmail($email)) {
                $q .= " , email = '$email' ";
            } else
                return -1;//already
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
            $resultUpload = $this->uploadImage('avatar', '../avatars');
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


    public function deleteProfileAvatar()
    {
        $id = $_SESSION['admin_id'];
        $currentProfile = $this->getProfile();
        $path = '../' . $currentProfile['avatar'];
        if ($currentProfile['avatar'] != '' && file_exists($path)) {
            unlink($path);
        }
        $q = "UPDATE users SET avatar = '' WHERE id = '$id'";
        $this->query($q);
    }

    public function checkCategory($title,$parent_id)
    {
        $title = $this->safeString($title);
        $parent_id = $this->toInt($parent_id);
        $q = "SELECT * FROM categories WHERE title = '$title' AND parent_id = '$parent_id'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        if(isset($row['id']))
            return false;
        else
            return true;
    }

    public function addCategory()
    {
        $parent_id = $this->toInt($this->post('parent_id'));
        $title = $this->safeString($this->post('title'));
        if($this->checkCategory($title,$parent_id))
        {
            $q = "INSERT INTO categories VALUES ('NULL','$title','$parent_id')";
            return $this->query($q);
        }
        else
            return -1;
    }

    public function getParentCategoryList($parent_id = 0)
    {
        $parent_id = $this->toInt($parent_id);
        $q = "SELECT * FROM categories WHERE parent_id = '$parent_id'";
        return $this->query($q);
    }

    public function getCategory($id)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM categories WHERE id = '$id'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        return $row;
    }

    public function saveCategory($id)
    {
        $id = $this->toInt($id);
        $parent_id = $this->toInt($this->post('parent_id'));
        $title = $this->safeString($this->post('title'));
        $currentRow = $this->getCategory($id);
        if($currentRow['parent_id'] == 0)
        {
            //group main
            if($currentRow['title'] != $title)
            {
                if($this->checkCategory($title,0))
                {
                    $q = "UPDATE categories SET title = '$title' WHERE id = '$id'";
                    $this->query($q);
                    return 1;
                }
                else
                    return -1;
            }
            return 1;
        }
        else
        {
            $q = "UPDATE categories SET ";
            $isChangeParentID = false;
            $isChangeTitle = false;

            if($currentRow['parent_id'] != $parent_id )
            {
                if($this->checkCategory($title,$parent_id))
                {
                    $q .= " parent_id = '$parent_id' ";
                    $isChangeParentID = true;
                }
                else
                    return -1;
            }

            if($currentRow['title'] != $title )
            {
                if($this->checkCategory($title,$parent_id))
                {
                    if($isChangeParentID)
                        $q .= " , ";
                    $q .= " title = '$title' ";
                    $isChangeTitle = true;
                }
                else
                    return -1;
            }
            
            $q.= " WHERE id = '$id' ";
            if($isChangeParentID || $isChangeTitle)
                $this->query($q);

            return 1;
        }
    }

    public function getCountChildForCategory($parent_id)
    {
        $parent_id = $this->toInt($parent_id);
        $q = "SELECT COUNT(*) AS n FROM categories WHERE parent_id = '$parent_id'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        return $row['n'];
    }

    public function deleteCategory($id,$category_id,$sub_category_id)
    {
        $id = $this->toInt($id);
        $category_id = $this->toInt($category_id);
        $sub_category_id = $this->toInt($sub_category_id);
        if($this->getCountChildForCategory($id) == 0 &&
            $this->getCountProduct($category_id,$sub_category_id) == 0)
        {
            $q = "DELETE FROM categories WHERE id = '$id'";
            $this->query($q);
            return 1;
        }
        else
        {

            if($this->getCountChildForCategory($id) > 0)
                return 2;
            else if ($this->getCountProduct($category_id,$sub_category_id) > 0)
                return 3;
        }
    }

    public function checkProductTitle($category_id,$sub_category_id,$title_fa)
    {
        $category_id = $this->toInt($category_id);
        $sub_category_id = $this->toInt($sub_category_id);
        $title_fa = $this->safeString($title_fa);
        $q = "SELECT id FROM products WHERE title_fa = '$title_fa'
               AND category_id = '$category_id' AND sub_category_id = '$sub_category_id' ";
        $r = $this->query($q);
        $row = $this->getRow($r);
        if(isset($row['id']))
            return false;
        else
            return true;
    }

    public function addProductStep1()
    {
        $date = date('Y-m-d H:i:s');
        $category_id = $this->toInt($this->post('category_id'));
        $sub_category_id = $this->toInt($this->post('sub_category_id'));
        $title_fa = $this->safeString($this->post('title_fa'));
        $title_en = $this->safeString($this->post('title_en'));
        $short_content = $this->safeString($this->post('short_content'));
        $long_content = $this->safeString($this->post('long_content'));
        $status = isset($_POST['status']) ? 1 : 0;
        $is_special = isset($_POST['is_special']) ? 1 : 0;
        if($this->checkProductTitle($category_id,$sub_category_id,$title_fa))
        {
            $q = "INSERT INTO products (category_id,sub_category_id,title_fa,title_en,short_content,long_content,status,date_created,is_special)
              VALUES ('$category_id','$sub_category_id','$title_fa'
                ,'$title_en','$short_content','$long_content','$status','$date','$is_special') ";
            return $this->query($q);
        }
        else
            return -1;
    }


    public function saveProductStep2($id)
    {
        $date = date('Y-m-d H:i:s');
        $id = $this->toInt($id);
        $model = $this->safeString($this->post('model'));
        $code = $this->safeString($this->post('code'));
        $price = $this->safeString($this->post('price'));
        $price_discount = $this->safeString($this->post('price_discount'));
        $price = str_ireplace(',','',$price);
        $price_discount = str_ireplace(',','',$price_discount);
        $quantity = $this->toInt($this->post('quantity'));
        $q = "UPDATE products SET model = '$model' , code = '$code'
                ,price = '$price',price_discount = '$price_discount'
                ,date_edit = '$date'
                 ,quantity = '$quantity' WHERE id = '$id' ";
        $this->query($q);

    }


    public function saveProductStep3($id)
    {
        $date = date('Y-m-d H:i:s');
        $id = $this->toInt($id);
        $thumb_image = $this->safeString($this->post('thumb_image'));
        $q = "UPDATE products SET thumb_image = '$thumb_image' 
                ,date_edit = '$date'
               WHERE id = '$id' ";
        $this->query($q);

        $i = 0;
        foreach($_POST['img'] as $img)
        {
            $img = $this->safeString(trim($img));
            $alt = $this->safeString(trim($_POST['alt'][$i]));
            $q2 = "INSERT INTO product_image VALUES ('NULL','$id','$img','$alt')";
            $this->query($q2);
            $i++;
        }

    }


    public function saveProductStep4($id)
    {
        $date = date('Y-m-d H:i:s');
        $id = $this->toInt($id);
        $meta_keywords = $this->safeString($this->post('meta_keywords'));
        $meta_description = $this->safeString($this->post('meta_description'));
        $q = "UPDATE products SET meta_keywords = '$meta_keywords',date_edit = '$date'
              , meta_description = '$meta_description' WHERE id = '$id' ";
        $this->query($q);

    }

    public function getCountProduct($category_id,$sub_category_id)
    {
        $category_id = $this->toInt($category_id);
        $sub_category_id = $this->toInt($sub_category_id);
        $q = "SELECT COUNT(*) AS n FROM products WHERE category_id = '$category_id'  ";
        if($sub_category_id > 0)
            $q .= " AND  sub_category_id = '$sub_category_id' ";
        $r = $this->query($q);
        $row = $this->getRow($r);
        return $row['n'];
    }

    public function changeStatusProduct($id,$val)
    {
        $date = date('Y-m-d H:i:s');
        $id = $this->toInt($id);
        $val = $this->toInt($val);
        $q = "UPDATE products SET status = '$val' ,date_edit = '$date' WHERE id = '$id'";
        $this->query($q);
    }

    public function changeSpecialProduct($id,$val)
    {
        $date = date('Y-m-d H:i:s');
        $id = $this->toInt($id);
        $val = $this->toInt($val);
        $q = "UPDATE products SET is_special = '$val' ,date_edit = '$date' WHERE id = '$id'";
        $this->query($q);
    }

    public function deleteProduct($id)
    {
        $id = $this->toInt($id);
        $q1 = "DELETE FROM products WHERE id = '$id'";
        $this->query($q1);
        $q2 = "DELETE FROM product_image WHERE product_id = '$id'";
        $this->query($q2);
    }

    public function getProduct($id)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM products WHERE id = '$id'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        return $row;
    }

    public function saveProductStep1($id)
    {
        $id = $this->toInt($id);
        $date = date('Y-m-d H:i:s');
        $category_id = $this->toInt($this->post('category_id'));
        $sub_category_id = $this->toInt($this->post('sub_category_id'));
        $title_fa = $this->safeString($this->post('title_fa'));
        $title_en = $this->safeString($this->post('title_en'));
        $short_content = $this->safeString($this->post('short_content'));
        $long_content = $this->safeString($this->post('long_content'));
        $status = isset($_POST['status']) ? 1 : 0;
        $is_special = isset($_POST['is_special']) ? 1 : 0;
        $currentProduct = $this->getProduct($id);
        $q = "UPDATE products SET 
                title_en = '$title_en' 
                ,short_content = '$short_content' 
                ,long_content = '$long_content' 
                ,status = '$status' 
                ,is_special = '$is_special'
                 ,date_edit = '$date'                
                ";

        if($currentProduct['title_fa'] != $title_fa
            || $currentProduct['category_id'] != $category_id
            || $currentProduct['sub_category_id'] != $sub_category_id )
        {
            if($this->checkProductTitle($category_id,$sub_category_id,$title_fa))
            {
                $q.= " ,title_fa = '$title_fa' , category_id = '$category_id' 
                        ,sub_category_id = '$sub_category_id' ";
            }
            else
                return 0;//already
        }
        $q.= " WHERE id = '$id' ";
        $this->query($q);
        return 1;
    }


    public function getImageProductList($id)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM product_image WHERE product_id = '$id'";
        return $this->query($q);
    }

    public function deleteImageProduct($product_id,$id)
    {
        $product_id = $this->toInt($product_id);
        $id = $this->toInt($id);
        $q = "DELETE FROM product_image WHERE product_id = '$product_id' AND id = '$id'";
        return $this->query($q);

    }

    public function saveProductStep3Edit($id)
    {
        $date = date('Y-m-d H:i:s');
        $id = $this->toInt($id);
        $thumb_image = $this->safeString($this->post('thumb_image'));
        $q = "UPDATE products SET thumb_image = '$thumb_image' 
                ,date_edit = '$date'
               WHERE id = '$id' ";
        $this->query($q);

        $i = 0;
        foreach($_POST['img'] as $img)
        {
            $img = $this->safeString(trim($img));
            $alt = $this->safeString(trim($_POST['alt'][$i]));
            $img_id = $this->safeString(trim($_POST['img_id'][$i]));
            if($img_id == 0)
                $q2 = "INSERT INTO product_image VALUES ('NULL','$id','$img','$alt')";
            else
                $q2 = "UPDATE product_image SET img = '$img' , alt = '$alt' WHERE product_id = '$id' AND id = '$img_id'";
            $this->query($q2);
            $i++;
        }

    }


    public function getUser($id)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM users WHERE id = '$id'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        return $row;
    }

    public function deleteUser($id)
    {
        $id = $this->toInt($id);
        $currentUser = $this->getUser($id);
        $q = "DELETE FROM users WHERE id = '$id'";
        $this->query($q);
        $path = '../' . $currentUser['avatar'];
        if ($currentUser['avatar'] != '' && file_exists($path)) {
            unlink($path);
        }
    }


    public function changeStatusUser($id,$val)
    {
        $id = $this->toInt($id);
        $val = $this->toInt($val);
        $q = "UPDATE users SET status = '$val'  WHERE id = '$id'";
        $this->query($q);
    }

    public function changeUserType($id,$val)
    {
        $id = $this->toInt($id);
        $val = $this->toInt($val);
        $q = "UPDATE users SET is_admin = '$val' WHERE id = '$id'";
        $this->query($q);
    }

    public function deleteUserAvatar($id)
    {
        $id = $this->toInt($id);
        $currentUser = $this->getUser($id);
        $path = '../' . $currentUser['avatar'];
        if ($currentUser['avatar'] != '' && file_exists($path)) {
            unlink($path);
        }
        $q = "UPDATE users SET avatar = '' WHERE id = '$id'";
        $this->query($q);
    }


    public function saveUserProfile($id)
    {
        $id = $this->toInt($id);
        $currentProfile = $this->getUser($id);
        $fn = $this->safeString($this->post('fn'));
        $ln = $this->safeString($this->post('ln'));
        $tel = $this->safeString($this->post('tel'));
        $mobile = $this->safeString($this->post('mobile'));
        $address = $this->safeString($this->post('address'));
        $email = $this->safeString($this->post('email'));
        $pass = $this->safeString($this->post('pass'));

        $q = "UPDATE users SET fn = '$fn' , ln = '$ln'
            ,tel = '$tel' , mobile = '$mobile' , address = '$address' , password = '$pass' ";


        if ($currentProfile['email'] != $email) {
            //user change
            if ($this->checkUserEmail($email)) {
                $q .= " , email = '$email' ";
            } else
                return -1;//already
        }



        if ($currentProfile['avatar'] == '') {
            $resultUpload = $this->uploadImage('avatar', '../avatars');
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

    public function getSlide($id)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM slider WHERE id = '$id'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        return $row;
    }


    public function saveSlide($id)
    {
        $id = $this->toInt($id);
        $title = $this->safeString($this->post('title'));
        $link = $this->safeString($this->post('link'));
        $img = $this->safeString($this->post('img'));
        $q = "UPDATE slider SET title = '$title', link = '$link'
              ,img = '$img' WHERE id = '$id'";
        $this->query($q);
    }

    public function saveConfig()
    {
        $id = 1;
        $title = $this->safeString($this->post('title'));
        $meta_keywords = $this->safeString($this->post('meta_keywords'));
        $meta_description = $this->safeString($this->post('meta_description'));
        $favicon = $this->safeString($this->post('favicon'));
        $q = "UPDATE config SET title = '$title', meta_keywords = '$meta_keywords'
              ,meta_description = '$meta_description'
              ,favicon = '$favicon'
               WHERE id = '$id'";
        $this->query($q);
    }

    public function deleteOrder($id)
    {
        $id = $this->toInt($id);
        $q1 = "DELETE FROM orders WHERE id = '$id'";
        $this->query($q1);
        $q2 = "DELETE FROM order_items WHERE order_id = '$id'";
        $this->query($q2);
        $q3 = "DELETE FROM pay_info WHERE order_id = '$id'";
        $this->query($q3);
    }

    public function getOrder($id)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM orders WHERE id = '$id'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        return $row;
    }

    public function OrderChangeStatus($id,$st)
    {
        $id = $this->toInt($id);
        $st = $this->toInt($st);
        $q = "UPDATE orders SET status = '$st' WHERE id = '$id'";
        $this->query($q);
    }

}