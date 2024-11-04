<?php if (isset($papers) && !empty($papers)): ?>
<div class="row">
    <?php foreach ($papers as $paper): ?>
    <div class="col-md-4">
        <div class="card mb-4">
            <img src="<?php echo _WEB_ROOT; ?>/public/img/AI.png" class="card-img-top" alt="Paper Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($paper['title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($paper['abstract']); ?></p>
                <a href="<?php echo _WEB_ROOT; ?>/paper/detail/<?php echo $paper['paper_id']; ?>"
                    class="btn btn-primary">Chi tiết</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination controls -->
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php if ($currentPage > 1): ?>
        <li class="page-item"><a class="page-link" href="#"
                onclick="searchPapers(<?php echo $currentPage - 1; ?>)">Previous</a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>"><a class="page-link" href="#"
                onclick="searchPapers(<?php echo $i; ?>)"><?php echo $i; ?></a></li>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
        <li class="page-item"><a class="page-link" href="#"
                onclick="searchPapers(<?php echo $currentPage + 1; ?>)">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php else: ?>
<p>Không tìm thấy bài báo nào.</p>
<?php endif; ?>