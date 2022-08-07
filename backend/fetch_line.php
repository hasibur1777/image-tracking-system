<?php
require "db_conn.php";


// select * from bc_business_global_catagory where biz_global_cat_id='ASS_LINE' and prod_code='tv' and is_active='1';

$short_code = $_POST["short_code"];
$result = mysqli_query($conn_qc, "select * from bc_business_global_catagory where biz_global_cat_id='ASS_LINE' and prod_code='$short_code' and is_active='1'");
$ret_html = "";
$ret_html .= '<option value="">Select One</option>';
?>

<?php
while ($row = mysqli_fetch_array($result)) {

    $temp = "<option value='" . $row['short_code'] . "'>" . $row['name'] . "</option>";
    $ret_html .= $temp;
}

echo $ret_html;
?>