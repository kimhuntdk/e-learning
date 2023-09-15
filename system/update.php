<!DOCTYPE html>
<html>
<head>
    <title>Update E-Learning</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Update E-Learning</h2>
        <?php
        // ตรวจสอบว่ามีค่า 'eleaning_id' และ 'eleaning_type' ใน $_POST หรือไม่
        if (isset($_POST['eleaning_id'], $_POST['eleaning_type'])) {
            $eleaning_id = filter_input(INPUT_POST, 'eleaning_id', FILTER_SANITIZE_NUMBER_INT);
            $eleaning_type = filter_input(INPUT_POST, 'eleaning_type', FILTER_SANITIZE_STRING);
            $eleaning_name = filter_input(INPUT_POST, 'eleaning_name', FILTER_SANITIZE_STRING);
            $eleaning_url = filter_input(INPUT_POST, 'eleaning_url', FILTER_SANITIZE_URL);

            // ตรวจสอบความถูกต้องของข้อมูล
            if (empty($eleaning_type) || empty($eleaning_name) || empty($eleaning_url)) {
                echo "Please fill in all fields.";
            } else {
                // เรียกข้อมูล E-Learning จากฐานข้อมูล
                require_once '../inc/db_connect.php';
                $mysqli = connect();
                $sql = "UPDATE grad_eleaning_view SET eleaning_type = ?, eleaning_name = ?, eleaning_url = ? WHERE eleaning_id = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sssi", $eleaning_type, $eleaning_name, $eleaning_url, $eleaning_id);

                // ทำการอัปเดตข้อมูล
                if ($stmt->execute()) {
                    echo "E-Learning updated successfully.";
                } else {
                    echo "Update failed: " . $stmt->error;
                }

                // ปิดการเชื่อมต่อฐานข้อมูล
                $stmt->close();
                $mysqli->close();
            }
        } else {
            echo "Invalid request.";
        }
        ?>
        <br>
        <a href="add.php" class="btn btn-secondary">Back to List</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
