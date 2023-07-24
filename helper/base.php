<?php
defined('DB_HOST') or die;
abstract class Base
{

    protected $dbLink = null;
    public $page = null;
    public $limit = null;
    private $sortColumn = array();

    public function __construct()
    {
        $this->dbLink = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD)
                or die(mysqli_connect_error());

        mysqli_select_db($this->dbLink,DB_NAME)
            or die($this->getMysqlError());

        $this->query("SET NAMES 'UTF8'");

        $this->page = ( $this->get('page') != '' ) ? $this->toInt($this->get('page'))  : 1;
        if($this->page <= 0)
            $this->page = 1;

        $this->limit = $this->toInt($this->get('limit'));

        if(!isset($_SESSION['limit']))
            $_SESSION['limit'] = 10;

        if($this->limit > 0)
        {
            ///if($this->limit <= 0)
             //   $this->limit = 10;
            $_SESSION['limit'] = $this->limit;
        }


        if(!isset($_SESSION['sort']))
            $_SESSION['sort'] = 'asc';

        $sort = $this->get('sort');
        if($sort != '')
        {
            if($sort == 'desc')
                $sort = 'desc';
            else
                $sort = 'asc';
            $_SESSION['sort'] = $sort;
        }

        if(!isset($_SESSION['field']))
            $_SESSION['field'] = 'id';

        $field = $this->safeString($this->get('field'));
        if($field != '')
            $_SESSION['field'] = $field;

    }


    public function setSortColumn($sortColumn)
    {
        $this->sortColumn = $sortColumn;
    }

    public function __destruct()
    {
        if($this->dbLink)
            mysqli_close($this->dbLink);
    }


    public function getMysqlError()
    {
        return mysqli_error($this->dbLink);
    }

    public function query($q)
    {
        $result =  mysqli_query($this->dbLink,$q);
        if(stristr($q,'insert'))
            return mysqli_insert_id($this->dbLink);
        else if(stristr($q,'update') || stristr($q,'delete'))
            return mysqli_affected_rows($this->dbLink);
        else
            return $result;
    }

    public function getRow($result)
    {
        return mysqli_fetch_assoc($result);
    }

    public function freeResult($result)
    {
        mysqli_free_result($result);
    }

    public function post($key)
    {
        if(isset($_POST[$key]))
            return trim($_POST[$key]);
        else
            return '';
    }

    public function get($key)
    {
        if(isset($_GET[$key]))
            return trim($_GET[$key]);
        else
            return '';
    }

    public function redirect($url)
    {
        header("location:$url");
        die;//security fix bug
    }

    public function setDanger($key,$message)
    {
        if($this->get('msg') == $key)
            print "<div class=\"alert alert-danger text-center\">$message</div>";
    }

    public function setSuccess($key,$message)
    {
        if($this->get('msg') == $key)
            print "<div class=\"alert alert-success text-center\">$message</div>";
    }

    public function setWarning($key,$message)
    {
        if($this->get('msg') == $key)
            print "<div class=\"alert alert-warning text-center\">$message</div>";
    }

    public function setInfo($key,$message)
    {
        if($this->get('msg') == $key)
            print "<div class=\"alert alert-info text-center\">$message</div>";
    }

    public function safeString($str)
    {
        return htmlentities($str,ENT_QUOTES,'UTF-8');
    }

    public function g2j($date)
    {
        $dateArray = explode('-',$date);
        $jDate = gregorian_to_jalali($dateArray[0],$dateArray[1],$dateArray[2]);
        $jDate[1] = ($jDate[1] >= 10) ? $jDate[1] : "0{$jDate[1]}";
        $jDate[2] = ($jDate[2] >= 10) ? $jDate[2] : "0{$jDate[2]}";
        return "$jDate[0]-$jDate[1]-$jDate[2]";
    }

    public function j2g($date)
    {
        $dateArray = explode('-',$date);
        $jDate = jalali_to_gregorian($dateArray[0],$dateArray[1],$dateArray[2]);
        $jDate[1] = ($jDate[1] >= 10) ? $jDate[1] : "0{$jDate[1]}";
        $jDate[2] = ($jDate[2] >= 10) ? $jDate[2] : "0{$jDate[2]}";
        return "$jDate[0]-$jDate[1]-$jDate[2]";
    }

    public function checkUserEmail($email)
    {
        $email = $this->safeString($email);
        $q = "SELECT COUNT(*) AS n FROM users WHERE email = '$email'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        if($row['n'] > 0)
            return false;
        else
            return true;
    }


    public function uploadImage($fieldName,$uploadFolderName)
    {
        $allowFileType = array('jpg','gif','jpeg','png');
        $error = $_FILES[$fieldName]['error'];
        if( isset($_FILES[$fieldName]) && $error == 0)
        {
            $name = strtolower($_FILES[$fieldName]['name']);
            $tmp_name = $_FILES[$fieldName]['tmp_name'];
            $fileType = pathinfo($name,PATHINFO_EXTENSION);
            $indexFile = array_search($fileType,$allowFileType);
            if(in_array($fileType,$allowFileType))
            {
               $newExt = $allowFileType[$indexFile];
               $newFileName = date('YmdHis').mt_rand(111111,999999);
               $fullFileNewName = $newFileName.".".$newExt;
               $path = "$uploadFolderName/$fullFileNewName";
               $resultMove = move_uploaded_file($tmp_name,$path);
               if($resultMove)
                   return $fullFileNewName;
               else
                   return 3;//can not move file
            }
            else
                return 2;//invalid file type*/

        }
        else
            return 1;//file upload nashod
    }

    public function toInt($str)
    {
        return (int)$str;
    }

    public function toFloat($str)
    {
        return (float)$str;
    }

    public function pagination($table_name,$where = '')
    {
        if($where == '')
            $where = '';
        else
        {
            $where = ' WHERE 1 = 1 '.$where;
        }
        $ret = array();
        $m = $_SESSION['limit'];
        $qCount = "SELECT COUNT(id) AS c FROM $table_name $where ";
        $rCount = $this->query($qCount);
        $rowCount = $this->getRow($rCount);
        $this->freeResult($rCount);
        $totalRows = $rowCount['c'];
        $totalPage = ceil($totalRows / $m);
        $n = ($m * $this->page) - $m;
        if(!in_array($_SESSION['field'],$this->sortColumn))
            $_SESSION['field'] = $this->sortColumn[0];
        $order = " ORDER BY {$_SESSION['field']} {$_SESSION['sort']}";
        $q = "SELECT * FROM $table_name $where $order LIMIT $n,$m";
        $r = $this->query($q);
        $ret['totalRows'] = $totalRows;
        $ret['totalPage'] = $totalPage;
        $ret['result'] = $r;
        return $ret;
    }


    public function renderPagination($url,$totalPage)
    {
        if($this->page == $totalPage)
        {
            $lastPageHref = 'javascript:void(0);';
            $lastPageClass = 'disabled';
        }
        else
        {
            $lastPageHref = $url."&page=$totalPage";
            $lastPageClass = '';
        }
        if($this->page == 1)
        {
            $firstPageHref = 'javascript:void(0);';
            $firstPageClass = 'disabled';
        }
        else
        {
            $firstPageHref = $url."&page=1";
            $firstPageClass = '';
        }

        if($this->page >= $totalPage)
        {
            $nextPageHref = 'javascript:void(0);';
            $nextPageClass = 'disabled';
        }
        else
        {
            $nextPageHref = $url."&page=".($this->page + 1);
            $nextPageClass = '';
        }

        if($this->page <= 1)
        {
            $prevPageHref = 'javascript:void(0);';
            $prevPageClass = 'disabled';
        }
        else
        {
            $prevPageHref = $url."&page=".($this->page - 1);
            $prevPageClass = '';
        }



        ?>
        <nav class="text-center">
            <ul class="pagination" id="pagination">
                <li class="<?php print $lastPageClass; ?>">
                    <a href="<?php print $lastPageHref; ?>" title="صفحه آخر" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-step-forward"></span>
                    </a>
                </li>
                <li class="<?php print $nextPageClass; ?>">
                    <a href="<?php print $nextPageHref; ?>" title="صفحه بعد" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <span>
                            <input data-url="<?php print $url; ?>" data-container="body" data-toggle="popover" data-placement="top" data-content="صفحه مورد نظر وجود ندارد."  data-total-page="<?php print $totalPage; ?>"  type="text" value="<?php print $this->page; ?>" name="page" id="page">
                            از
                            <?php print $totalPage; ?>

                            <select name="limit" id="limit" data-url="<?php print $url; ?>">
                                <?php
                                    for($i = 10;$i <= 100;$i += 10)
                                    {
                                        $sel = ($_SESSION['limit'] == $i) ? 'selected' : '';
                                        ?>
                                            <option <?php print $sel; ?> value="<?php print $i; ?>">
                                                <?php print $i; ?>
                                            </option>
                                        <?php
                                    }
                                ?>
                            </select>
                    </span>



                </li>
                <li class="<?php print $prevPageClass; ?>">
                    <a href="<?php print $prevPageHref; ?>" title="صفحه قبل" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                    </a>
                </li>
                <li class="<?php print $firstPageClass; ?>">
                    <a href="<?php print $firstPageHref; ?>" title="صفحه اول" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-step-backward"></span>
                    </a>
                </li>
            </ul>
        </nav>

        <?php
    }

    public function sortPaginationField($url,$title,$field,$html = '')
    {
        if($_SESSION['sort'] == 'asc')
        {
            $url2 = "$url&field=$field&sort=desc";
            $span = '<span class="fa fa-sort-asc"></span>';
        }
        elseif($_SESSION['sort'] == 'desc')
        {
            $url2 = "$url&field=$field&sort=asc";
            $span = '<span class="fa fa-sort-desc"></span>';
        }

        if($_SESSION['field'] == $field)
        {
            ?>
                <a href="<?php print $url2; ?>">
                    <?php print $span; ?>
                    <?php print $title; ?>
                </a>
                <?php print $html; ?>
            <?php
        }
        else
        {
            ?>
            <a href="<?php print $url2; ?>">
                <span class="fa fa-sort"></span>
                <?php print $title; ?>
            </a>
            <?php print $html; ?>
            <?php
        }

    }

    public function renderID($totalRows)
    {
        $ret = array();
        if($_SESSION['sort'] == 'asc')
        {
            $n = (($_SESSION['limit'] * $this->page) - $_SESSION['limit']) + 1;
            $ret['n'] = $n;
            $ret['opt'] = '+';
        }
        else
        {
            if($this->page == 1)
                $n = $totalRows;
            else
                $n = $totalRows - ($this->page * $_SESSION['limit']) + $_SESSION['limit'];
            $ret['n'] = $n;
            $ret['opt'] = '-';
        }

        return $ret;
    }

    public function getBaseUrl()
    {
        return 'http://'.$_SERVER['HTTP_HOST'].APP_FOLDER;
    }


    public function createSeoUrl($str)
    {
        $str = mb_strtolower($str,'UTF-8');
        return str_replace(' ','-',$str);
    }

    public function sendEmail($to,$subject,$body)
    {
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        //$mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($to, '');
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        return $mail->send();
    }

    public function pagination2($totalPage,$params = '')
    {
        $url = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
        ?>
        <nav class="pagination-nav">
            <ul class="pagination">
                <?php
                if($this->page > 1)
                {
                    ?>
                    <li>
                        <a data-toggle="tooltip" href="<?php print $url.'?page=1'.$params;  ?>" title="اولین صفحه">
                            <span class="glyphicon glyphicon glyphicon-step-forward"></span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tooltip" href="<?php print $url.'?page='.($this->page - 1 ).$params;  ?>" title="صفحه قبل">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </li>
                <?php
                    }
                ?>
                <?php
                    if($totalPage <= 10 )
                    {
                        $start = 1;
                        $end = $totalPage;
                    }
                    else
                    {
                        $result = $this->page / 10;
                        if(is_float($result))
                        {
                            if($result <= 0.9)
                                $start = 1;
                            else
                            {
                                $r = explode('.',$result);
                                $start = "$r[0]0";
                            }
                        }
                        else
                        {
                            $start = $result * 10;
                        }

                        $e = $start + 10;
                        $e2 = $totalPage - $start;
                        $e3 = $e2 + $start;
                        if(strlen($e2) == 1)
                            $end = $e3;
                        else
                            $end = $e;
                        if($end == 11)
                            $end = 10;
                    }
                    for($i = $start;$i <= $end; $i++)
                    {
                        $numUrl = $url . "?page=".$i.$params;
                        $classActive = ($this->page == $i) ? 'active' : '';
                        $textNum = "صفحه " . $i;
                    ?>
                        <li class="<?php print $classActive; ?>">
                            <a href="<?php print $numUrl; ?>" data-toggle="tooltip" title="<?php print $textNum; ?>">
                                <?php print $i; ?>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                <?php
                if($this->page < $totalPage)
                {
                    ?>
                    <li>
                        <a data-toggle="tooltip" href="<?php print $url.'?page='.($this->page + 1 ).$params;  ?>" title="صفحه بعد">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tooltip" href="<?php print $url.'?page='.$totalPage.$params;  ?>" title="آخرین صفحه">
                            <span class="glyphicon glyphicon glyphicon-step-backward"></span>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </nav>

        <?php
    }

    public function getConfig($id = 1)
    {
        $id = $this->toInt($id);
        $q = "SELECT * FROM config WHERE id = '$id'";
        $r = $this->query($q);
        $row = $this->getRow($r);
        $this->freeResult($r);
        return $row;
    }
    
    
    public function getStatusOrder($st)
    {
        if($st == 1)
            print 'در حال برسی';
        else if($st == 2)
            print 'در انتظار پرداخت';
        else if($st == 3)
            print 'پرداخت شده';
        else if($st == 4)
            print 'کنسل شده';
        else if($st == 5)
            print 'ارسال شده';
    }


    public function getTotalOrderPrice($order_id)
    {
        $order_id = $this->toInt($order_id);
        $q = "SELECT sum(price * num) as total_price FROM order_items WHERE order_id = '$order_id'";
        $r = $this->query($q);
        return $this->getRow($r)['total_price'];
    }


    public function getListOrderItems($order_id)
    {
        $order_id = $this->toInt($order_id);
        $q = "SELECT * FROM order_items WHERE order_id = '$order_id' ";
        return $this->query($q);
    }


    public function sendSms($to,$message)
    {
        $sender = "100065995";
        $api = new \Kavenegar\KavenegarApi("4B5A34597A414A77677069783451614C54476C336C413D3D");
        $retSms = $api->Send($sender,$to,$message);
        return $retSms[0]->status;
    }


}
