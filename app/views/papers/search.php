<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Tìm kiếm bài báo</h1>

        <form id="search-form">
            <div class="form-group">
                <label for="keyword">Từ khoá:</label>
                <input type="text" id="keyword" name="keyword" class="form-control">
            </div>
            <div class="form-group">
                <label for="author">Tên tác giả:</label>
                <input type="text" id="author" name="author" class="form-control">
            </div>
            <div class="form-group">
                <label for="conference">Tên hội nghị:</label>
                <input type="text" id="conference" name="conference" class="form-control">
            </div>
            <div class="form-group">
                <label for="date">Thời gian:</label>
                <input type="text" id="date" name="date" class="form-control">
            </div>
            <div class="form-group">
                <label for="topic">Lĩnh vực:</label>
                <input type="text" id="topic" name="topic" class="form-control">
            </div>
            <button type="button" class="btn btn-primary" onclick="searchPapers()">Tìm kiếm</button>
        </form>

        <div id="search-results" class="mt-4">
            <!-- Kết quả tìm kiếm sẽ được hiển thị ở đây -->
        </div>
    </div>

    <script>
    function searchPapers(page = 1) {
        $.ajax({
            url: '<?php echo _WEB_ROOT; ?>/paper/searchPapers',
            method: 'GET',
            data: $('#search-form').serialize() + '&page=' + page,
            success: function(data) {
                $('#search-results').html(data);
            }
        });
    }
    </script>
</body>

</html>