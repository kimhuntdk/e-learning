<?php
// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มในหน้า add.php หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบและรับข้อมูลจากฟอร์ม
    $elearning_type = filter_input(INPUT_POST, 'eleaning_type', FILTER_SANITIZE_STRING);
    $elearning_name = filter_input(INPUT_POST, 'eleaning_name', FILTER_SANITIZE_STRING);
    $elearning_url = filter_input(INPUT_POST, 'eleaning_url', FILTER_SANITIZE_URL);

    // ตรวจสอบความถูกต้องของข้อมูล
    if (empty($elearning_type) || empty($elearning_name) || empty($elearning_url)) {
        echo "Please fill in all fields.";
    } else {
        // ทำการเชื่อมต่อฐานข้อมูล
        require_once '../inc/db_connect.php';
        $mysqli = connect();

        // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูล
        $sql = "INSERT INTO grad_eleaning_view (eleaning_type, eleaning_name, eleaning_url, eleaning_view) VALUES (?, ?, ?, 0)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $elearning_type, $elearning_name, $elearning_url);

        // ทำการเพิ่มข้อมูล
        if ($stmt->execute()) {
            echo "E-Learning added successfully.";
        } else {
            echo "Add E-Learning failed: " . $stmt->error;
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $stmt->close();
        $mysqli->close();
    }
} else {
    echo "Invalid request.";
}
?>
