<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bài báo mới</title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Thêm bài báo mới</h1>

        <form id="addPaperForm" action="<?php echo _WEB_ROOT; ?>/paper/create" method="POST">
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="abstract">Tóm tắt</label>
                <textarea class="form-control" id="abstract" name="abstract" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="conference_id">Hội nghị</label>
                <select class="form-control" id="conference_id" name="conference_id" required>
                    <?php foreach ($this->data['sub_content']['conferences'] as $conference): ?>
                    <option value="<?php echo htmlspecialchars($conference['conference_id']); ?>">
                        <?php echo htmlspecialchars($conference['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="topic_id">Chủ đề</label>
                <select class="form-control" id="topic_id" name="topic_id" required>
                    <?php foreach ($this->data['sub_content']['topics'] as $topic): ?>
                    <option value="<?php echo htmlspecialchars($topic['topic_id']); ?>">
                        <?php echo htmlspecialchars($topic['topic_name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="authors">Tác giả</label>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên tác giả</th>
                            <th>Vai trò</th>
                            <th>Thông tin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->data['sub_content']['authors'] as $author): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($author['full_name']); ?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="author_roles[<?php echo htmlspecialchars($author['user_id']); ?>]"
                                        id="role_member_<?php echo htmlspecialchars($author['user_id']); ?>"
                                        value="member">
                                    <label class="form-check-label"
                                        for="role_member_<?php echo htmlspecialchars($author['user_id']); ?>">Member</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="author_roles[<?php echo htmlspecialchars($author['user_id']); ?>]"
                                        id="role_first_author_<?php echo htmlspecialchars($author['user_id']); ?>"
                                        value="first_author">
                                    <label class="form-check-label"
                                        for="role_first_author_<?php echo htmlspecialchars($author['user_id']); ?>">First
                                        Author</label>
                                </div>
                            </td>
                            <td>
                                <a href="<?php echo _WEB_ROOT; ?>/author/index/<?php echo htmlspecialchars($author['user_id']); ?>"
                                    class="btn btn-info btn-sm">
                                    Info
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a id="backButton" href="#" class="btn btn-secondary">Trở về</a>
            <button type="submit" class="btn btn-primary">Thêm bài báo</button>

        </form>
    </div>

    <script>
    document.getElementById('addPaperForm').addEventListener('submit', function(event) {
        var form = event.target;
        var authorRoles = form.querySelectorAll('input[name^="author_roles"]');
        var isAuthorSelected = Array.from(authorRoles).some(function(role) {
            return role.checked;
        });

        if (!isAuthorSelected) {
            event.preventDefault();
            alert('Bạn phải chọn ít nhất một tác giả.');
        }
    });
    // Set the href of the back button to the previous page URL
    document.getElementById('backButton').href = document.referrer;
    </script>
</body>

</html>