<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin tác giả</title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Cập nhật thông tin của bạn</h1>

        <?php if (isset($sub_content['author'])): ?>
        <form
            action="<?php echo _WEB_ROOT; ?>/author/update/<?php echo htmlspecialchars($sub_content['author']['user_id']); ?>"
            method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="full_name">Họ tên</label>
                <input type="text" class="form-control" id="full_name" name="full_name"
                    value="<?php echo htmlspecialchars($sub_content['author']['full_name']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="website">Website</label>
                <input type="url" class="form-control" id="website" name="website"
                    value="<?php echo htmlspecialchars($sub_content['author']['website']); ?>">
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea class="form-control" id="bio" name="bio" rows="3"
                    required><?php echo htmlspecialchars(json_decode($sub_content['author']['profile_json_text'], true)['bio']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="interests">Interests (comma separated)</label>
                <input type="text" class="form-control" id="interests" name="interests"
                    value="<?php echo htmlspecialchars(implode(',', json_decode($sub_content['author']['profile_json_text'], true)['interests'])); ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="image">Ảnh đại diện</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <?php if ($sub_content['author']['image_path']): ?>
                <img src="<?php echo _WEB_ROOT . $sub_content['author']['image_path']; ?>" alt="Current Image"
                    class="img-thumbnail mt-2" style="width: 150px;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
        <?php else: ?>
        <p>Thông tin tác giả không tồn tại.</p>
        <?php endif; ?>
    </div>
</body>

</html>