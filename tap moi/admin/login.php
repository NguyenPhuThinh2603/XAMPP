<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .wrapper-login {
            max-width: 600px;
            min-height: 300px;
            border: 1px solid red;
            border-radius: 20px;
            margin: auto;
            padding: 20px;
            margin-top: auto;
        }
    </style>

</head>

<body>
    <?php
    require_once '../vendor/autoload.php';
    require_once '../config/database.php';

    use App\Models\User;

    if (isset($_POST['DANGNHAP'])) {
        $username = $_POST['username'];
        $password = sha1($_POST['password']);
        $args = [
            ['password', '=', $password],
            ['roles', '!=', 0],
            ['status', '=', 1],
        ];
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $args[] = ['email', '=', $username];
        } else {
            $args[] = ['username', '=', $username];
        }

        $user = User::where($args)->first();

        if ($user == null) {
            $message_login = "Đăng nhập thất bại";
        } else {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_image'] = $user->image;
            header("location:index.php");
        }
    }
    ?>
    <form action="login.php" method="post">
        <div class="wrapper-login mt-md-5">
            <h1 class="text-center text-danger fs-2">Đăng Nhập</h1>


            <div class="mb-3">
                <label><strong>Tên đăng nhập (*)</strong></label>
                <input type="text" name="username" class="form-control" required placeholder="Tên đăng nhập và email">
            </div>

            <div class="mb-3">
                <label><strong>Mật khẩu (*)</strong></label>
                <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu">
            </div>

            <div class="mb-3">
                <button type="submit" name="DANGNHAP" class="btn btn-danger form-control">Đăng nhập</button>
            </div>

            <div class="mb-3">
                <i>Chú ý: (*) Bắt buộc phải nhập</i>
                <?php if (isset($message_login)) : ?>
                    <p class="text-danger">
                        <strong><?php echo $message_login; ?></strong>
                    </p>
                <?php endif; ?>
            </div>

        </div>

    </form>
</body>

</html>