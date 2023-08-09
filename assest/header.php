<header class="blog-header border-bottom shadow-sm bg-white">
    <div class="container-fluid" style="padding-left: 3rem; padding-right:3rem">

        <div class="d-flex flex-column flex-md-row align-items-center py-2">
            <a href="index.php" class="my-0 mr-md-auto" style="width: 6rem;">
               <span>Welcome to .....</span>
            </a>

            <?php if ($loggedin) : ?>

                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 px-5 text-muted" href="index.php">Home</a>
                    <?php
                    if ($_SESSION['role'] == "Admin"){
                    ?>
                    <a class="p-2 px-5 text-muted" href="categories.php">Category</a>
                    <a class="p-2 px-5 text-muted" href="users.php">Users</a>
                    <?php }  ?>
                    <a class="p-2 px-5 text-muted" href="article.php">Posts</a>
                </nav>

            <?php else : ?>
                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 px-5 text-muted" href="articleOfCategory.php">Posts</a>
                </nav>

            <?php endif;  ?>

            <a class="btn btn-outline-success" href="<?= ($loggedin) ? 'Logout.php' : 'login.php'; ?>">
                <?= ($loggedin) ? 'Logout' : 'Sign in'; ?>
            </a>

        </div>
    </div>
</header>