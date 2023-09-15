<?php
session_start();
require_once 'inc/db_connect.php';
$mysqli = connect();
if(isset($_SESSION[ "SES_USER_LER" ])){


// ตรวจสอบว่ามีค่า 'id' ใน $_POST หรือไม่
if (isset($_POST['id'])) {
    // รับค่า 'id' และทำความสะอาดเพื่อป้องกัน SQL Injection
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // ตรวจสอบว่า $id มีค่าที่ถูกต้องหรือไม่
    if ($id !== false && $id >= 0) {
        $sql = "SELECT * FROM grad_eleaning_view WHERE eleaning_id='$id'";
        $rs = $mysqli->query($sql);
        $row = $rs->fetch_array();
        //
        $sql_w = "UPDATE grad_eleaning_view SET eleaning_view = eleaning_view + 1 WHERE eleaning_id = $id";
        $stmt = $mysqli->query($sql_w);
       
        ?>
<iframe width="100%" height="400px;" src="<?php echo $row['eleaning_url'];?>" frameborder="0" allowfullscreen></iframe>
  <?php  } else {
        // 'id' ไม่ถูกต้องหรือมีปัญหา
        echo "Invalid ID input.";
    }
} else {
    // 'id' ไม่ถูกส่งมาใน $_POST
    echo "ID not provided in POST data.";
}
}else{
     echo "<font color='red'>";
     echo "กรุณาเข้าสู่ระบบก่อนดูวิดีโอ";
     echo "</font>";
}
?>
