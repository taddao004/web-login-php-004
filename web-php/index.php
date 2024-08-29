<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesphp.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>ระบบสมัครสมาชิก</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-8">
                <h4>ระบบสมัครสมาชิก :</h4>
                <form action="" method="post">
                    <div class="mb-2">
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" required minlength="3" placeholder="ชื่อ">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="col-sm-9">
                            <input type="text" name="surname" class="form-control" required minlength="3" placeholder="นามสกุล">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="col-sm-9">
                            <input type="text" name="username" class="form-control" required minlength="3" placeholder="username">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" required minlength="3" placeholder="password">
                        </div>
                    </div>
                    <div class="d-grid col-sm-9 mb-3">
                        <button type="submit" class="btn-primary">สมัครสมาชิก</button>
                    </div>


                    <p>เป็นสมาชิกอยู่หรือไม่ คลิกเพื่อเข้าสู่ระบบ<a href="signin.php">เข้าสู่ระบบ</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['password'])) {
    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';


    require_once 'connect.php';


    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = sha1($_POST['password']);


    $stmt = $conn->prepare("SELECT id FROM regis_tb WHERE username = :username");
    $stmt->execute(array(':username' => $username));


    if ($stmt->rowCount() > 0) {
        echo '<script>
                setTimeout(function(){
                    swal({
                        title: "Username ซ้ำ !!",
                        text: "กรุณาสมัครใหม่อีกครั้ง",
                        type: "warning"
                    }, function(){
                        window.location = "index.php";
                    });
                }, 1000);
              </script>';
    } else {
        $stmt = $conn->prepare("INSERT INTO regis_tb (name, surname, username, password) VALUES (:name, :surname, :username, :password)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $result = $stmt->execute();


        if ($result) {
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title: "สมัครสมาชิกสำเร็จ",
                            text: "กรุณารอระบบ Login",
                            type: "success"
                        }, function() {
                            window.location = "index.html";
                        });
                    }, 1000);
                  </script>';
        } else {
            echo '<script>
                    setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            text: "ไม่สามารถสมัครสมาชิกได้",
                            type: "error"
                        }, function() {
                            window.location = "index.php";
                        });
                    }, 1000);
                  </script>';
        }
    }
}
?>
