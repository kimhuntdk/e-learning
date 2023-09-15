<!DOCTYPE html>
<html>
<head>
    <title>E-Learning Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Add E-Learning</h2>
        <form action="insert.php" method="POST">
            <div class="form-group">
                <label for="eleaning_type">Type:</label>
                <input type="text" class="form-control" name="eleaning_type" required>
            </div>

            <div class="form-group">
                <label for="eleaning_name">Name:</label>
                <input type="text" class="form-control" name="eleaning_name" required>
            </div>

            <div class="form-group">
                <label for="eleaning_url">URL:</label>
                <input type="text" class="form-control" name="eleaning_url" required>
            </div>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <h2 class="mt-5">List of E-Learning</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Views</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // เรียกข้อมูล E-Learning จากฐานข้อมูล
                require_once '../inc/db_connect.php';
                $mysqli = connect();
                $sql = "SELECT * FROM grad_eleaning_view";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['eleaning_id']; ?></td>
                            <td><?php echo $row['eleaning_type']; ?></td>
                            <td><?php echo $row['eleaning_name']; ?></td>
                            <td><a href="<?php echo $row['eleaning_url']; ?>" target="_blank"><?php echo $row['eleaning_url']; ?></a></td>
                            <td><?php echo $row['eleaning_view']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['eleaning_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?id=<?php echo $row['eleaning_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No E-Learning records found.</td></tr>";
                }

                // ปิดการเชื่อมต่อฐานข้อมูล
                $mysqli->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
