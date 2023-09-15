<!DOCTYPE html>
<html>
<head>
    <title>Edit E-Learning</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Edit E-Learning</h2>
        <?php
        // ตรวจสอบว่ามีค่า 'id' ใน $_GET หรือไม่
        if (isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            // เรียกข้อมูล E-Learning จากฐานข้อมูล
            require_once '../inc/db_connect.php';
            $mysqli = connect();
            $sql = "SELECT * FROM grad_eleaning_view WHERE eleaning_id = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                if ($row) {
                    ?>
                    <form action="update.php" method="POST">
                        <input type="hidden" name="eleaning_id" value="<?php echo $row['eleaning_id']; ?>">

                        <div class="form-group">
                            <label for="eleaning_type">Type:</label>
                            <input type="text" class="form-control" name="eleaning_type" value="<?php echo $row['eleaning_type']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="eleaning_name">Name:</label>
                            <input type="text" class="form-control" name="eleaning_name" value="<?php echo $row['eleaning_name']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="eleaning_url">URL:</label>
                            <input type="text" class="form-control" name="eleaning_url" value="<?php echo $row['eleaning_url']; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                    <?php
                } else {
                    echo "E-Learning not found.";
                }
                $result->close();
            } else {
                echo "Query failed: " . $stmt->error;
            }

            $stmt->close();
            $mysqli->close();
        } else {
            echo "E-Learning ID not provided.";
        }
        ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
