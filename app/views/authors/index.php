<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    /* Thêm CSS tùy chỉnh cho ảnh profile */
    .author-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        /* Đảm bảo ảnh không bị kéo dãn */
        border-radius: 50%;
        /* Tạo ảnh tròn */
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <?php
        // Kiểm tra sự tồn tại của biến session và khóa user_id
        if (isset($_SESSION['user']) && isset($_SESSION['user']['user_id'])) {
            $currentUserId = $_SESSION['user']['user_id']; // ID của user hiện tại
            $isCurrentUser = $currentUserId === $sub_content['author']['user_id']; // Kiểm tra nếu user hiện tại là tác giả
        } else {
            // Nếu không có session hoặc user_id, đặt giá trị mặc định
            $currentUserId = null;
            $isCurrentUser = false;
        }
        ?>

        <h1 class="mb-4">
            <?php echo $isCurrentUser ? "Thông tin của bạn" : "Thông tin tác giả"; ?>
        </h1>

        <?php if (isset($sub_content['author'])): ?>
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="<?php echo _WEB_ROOT . $sub_content['author']['image_path']; ?>" class="author-image"
                    alt="Author Image">
                <h5 class="card-title mt-3"><?php echo htmlspecialchars($sub_content['author']['full_name']); ?></h5>
                <p class="card-text"><strong>Website:</strong> <a
                        href="<?php echo htmlspecialchars($sub_content['author']['website']); ?>"><?php echo htmlspecialchars($sub_content['author']['website']); ?></a>
                </p>

                <?php $profile = json_decode($sub_content['author']['profile_json_text'], true); ?>
                <?php if ($profile): ?>
                <p class="card-text"><strong>Bio:</strong> <?php echo htmlspecialchars($profile['bio']); ?></p>
                <p class="card-text"><strong>Interests:</strong>
                    <?php echo htmlspecialchars(implode(', ', $profile['interests'])); ?></p>
                <!-- Add more sections like education, work_experiences as needed -->
                <?php endif; ?>

                <?php if ($isCurrentUser): ?>
                <a href="<?php echo _WEB_ROOT; ?>/author/edit/<?php echo $sub_content['author']['user_id']; ?>"
                    class="btn btn-primary">Cập nhật</a>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <p>Thông tin tác giả không tồn tại.</p>
        <?php endif; ?>

        <h3 class="mt-4">Danh sách bài báo</h3>
        <?php if (isset($sub_content['papers']) && !empty($sub_content['papers'])): ?>
        <div class="row">
            <?php foreach ($sub_content['papers'] as $paper): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo _WEB_ROOT; ?>/public/img/AI.png" class="card-img-top" alt="Paper Image">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="<?php echo _WEB_ROOT; ?>/paper/detail/<?php echo $paper['paper_id']; ?>">
                                <?php echo htmlspecialchars($paper['title']); ?>
                            </a>
                        </h5>
                        <p class="card-text"><?php echo htmlspecialchars($paper['abstract']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p>Không có bài báo nào.</p>
        <?php endif; ?>
    </div>
</body>

</html>