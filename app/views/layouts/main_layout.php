<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php 
    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (isset($_SESSION['user'])) {
        // Nếu đã đăng nhập, hiển thị header dành cho admin
        $this->render('blocks/header_user');
    } else {
        // Nếu chưa đăng nhập, hiển thị header thông thường
        $this->render('blocks/header');
    }
    ?>

    <div>
        <?php
        // Render view con với dữ liệu truyền từ controller
        if (isset($content)) {
            $this->render($content, isset($sub_content) ? ['sub_content' => $sub_content] : []);
        }
        ?>
    </div>

    <?php $this->render('blocks/footer'); ?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?php echo _WEB_ROOT; ?>/public/js/script.js"></script>
</body>

</html>