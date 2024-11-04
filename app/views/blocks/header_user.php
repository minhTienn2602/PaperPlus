<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php echo ($this->isActiveRoute('home/index') ? 'active' : ''); ?>">
                    <a class="nav-link" href="<?php echo _WEB_ROOT; ?>/home/index">Trang chủ</a>
                </li>
                <li class="nav-item <?php echo ($this->isActiveRoute('paper/search') ? 'active' : ''); ?>">
                    <a class="nav-link" href="<?php echo _WEB_ROOT; ?>/paper/search">Tìm kiếm</a>
                </li>
                <li class="nav-item <?php echo ($this->isActiveRoute('paper/add') ? 'active' : ''); ?>">
                    <a class="nav-link" href="<?php echo _WEB_ROOT; ?>/paper/add">Thêm bài báo</a>
                </li>

                <li class="nav-item <?php echo ($this->isActiveRoute('home/about') ? 'active' : ''); ?>">
                    <a class="nav-link" href="<?php echo _WEB_ROOT; ?>/home/about">Giới thiệu</a>
                </li>
            </ul>
            <div class="ml-auto auth-links">
                <?php if (isset($_SESSION['user'])): ?>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <?php if ($_SESSION['user']['user_type'] === 'admin'): ?>
                        Chào admin, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                        <?php else: ?>
                        Xin chào, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                        <?php endif; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                        <a class="dropdown-item"
                            href="<?php echo _WEB_ROOT; ?>/author/index/<?php echo htmlspecialchars($_SESSION['user']['user_id']); ?>">
                            <i class="fas fa-user mr-2"></i> My profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo _WEB_ROOT; ?>/user/logout">
                            <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                        </a>
                    </div>
                </div>
                <?php else: ?>
                <a href="<?php echo _WEB_ROOT; ?>/user/login" class="nav-link">Log In</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>