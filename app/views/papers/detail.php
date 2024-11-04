<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .card-img-top {
        width: 200px;
        /* Điều chỉnh kích thước ảnh */
        height: auto;
        /* Đảm bảo tỷ lệ hình ảnh */
    }

    .card-title {
        font-size: 2.5rem;
        /* Điều chỉnh kích thước tiêu đề */
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Chi tiết bài báo</h1>

        <?php if (isset($sub_content['paper'])): ?>
        <div class="card">
            <img src="<?php echo _WEB_ROOT; ?>/public/img/AI.png" class="card-img-top" alt="AI Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($sub_content['paper']['title']); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    <?php echo htmlspecialchars($sub_content['paper']['author_string_list']); ?>
                </h6>
                <p class="card-text"><?php echo htmlspecialchars($sub_content['paper']['abstract']); ?></p>
                <p class="card-text"><strong>Conference:</strong>
                    <?php echo htmlspecialchars($sub_content['conference']['name']); ?></p>
                <p class="card-text"><strong>Topic:</strong>
                    <?php echo htmlspecialchars($sub_content['topic']['topic_name']); ?></p>
            </div>
        </div>

        <!-- Button to add user as member -->
        <?php if (isset($_SESSION['user'])): ?>
        <?php $currentUserId = $_SESSION['user']['user_id']; ?>
        <?php $paperId = $sub_content['paper']['paper_id']; ?>
        <?php $isFirstAuthor = false; ?>
        <?php foreach ($sub_content['authors'] as $author): ?>
        <?php if ($author['user_id'] == $currentUserId && $author['role'] == 'first_author'): ?>
        <?php $isFirstAuthor = true; ?>
        <?php break; ?>
        <?php endif; ?>
        <?php endforeach; ?>

        <?php if (!$isFirstAuthor): ?>
        <form action="<?php echo _WEB_ROOT; ?>/participation/add" method="post">
            <input type="hidden" name="author_id" value="<?php echo htmlspecialchars($currentUserId); ?>">
            <input type="hidden" name="paper_id" value="<?php echo htmlspecialchars($paperId); ?>">
            <button type="submit" class="btn btn-primary mt-3">Làm thành viên</button>
        </form>
        <?php else: ?>
        <p>Bạn đã là first author của bài báo này.</p>
        <?php endif; ?>
        <?php endif; ?>

        <?php else: ?>
        <p>Bài báo không tồn tại.</p>
        <?php endif; ?>

        <h3 class="mt-4">Tác giả</h3>
        <?php if (isset($sub_content['authors']) && !empty($sub_content['authors'])): ?>
        <ul>
            <?php foreach ($sub_content['authors'] as $author): ?>
            <li><a href="<?php echo _WEB_ROOT; ?>/author/index/<?php echo $author['user_id']; ?>">
                    <?php echo htmlspecialchars($author['full_name']); ?> -
                    <?php echo htmlspecialchars($author['role']); ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p>Không có thông tin tác giả.</p>
        <?php endif; ?>
    </div>
</body>

</html>