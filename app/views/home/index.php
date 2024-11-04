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
    <div class="container mt-5">
        <h1 class="mb-4">Trang chủ</h1>

        <?php if (isset($sub_content) && !empty($sub_content)): ?>
        <?php foreach ($sub_content as $topicName => $papers): ?>
        <h2 class="my-4"><?php echo htmlspecialchars($topicName); ?></h2>
        <div class="row">
            <?php if (empty($papers)): ?>
            <p class="col-12">No papers available for this topic.</p>
            <?php else: ?>
            <?php foreach ($papers as $paper): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- Sử dụng ảnh cố định AI.png -->
                    <img src="<?php echo _WEB_ROOT; ?>/public/img/AI.png" class="card-img-top" alt="AI Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($paper['title']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?php echo htmlspecialchars($paper['author_string_list']); ?>
                        </h6>
                        <p class="card-text">
                            <?php echo htmlspecialchars($paper['abstract']); ?>
                        </p>
                        <!-- Liên kết đến chi tiết bài báo -->
                        <a href="<?php echo _WEB_ROOT; ?>/paper/detail/<?php echo htmlspecialchars($paper['paper_id']); ?>"
                            class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>No topics available.</p>
        <?php endif; ?>
    </div>
</body>

</html>