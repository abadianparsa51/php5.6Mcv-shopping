<?php 
require_once '../init.php';
$do = $main->post('do');
if( $do == 'getSubCat')
{
    $id = $main->toInt($main->post('id'));
    $result = $main->getParentCategoryList($id);
    while ($row = $main->getRow($result))
    {
        ?>
        <option value="<?php echo $row['id'] ?>"><?php echo $row['title'] ?></option>
        <?php
    }
}
else if ($do == 'x')
{

}
?>