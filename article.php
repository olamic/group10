<!-- Include Head -->
<?php include "assest/head.php"; ?>
<?php

// Check if the admin is already logged in, if yes then redirect him to home page
if (!$loggedin) {
    header("location: index.php");
    exit;
}
if ($_SESSION['role'] == "Admin") {
// Get all Articles Data
    $stmt = $conn->prepare("SELECT * FROM article, category WHERE id_categorie = category_id ORDER BY article_id DESC");
    $stmt->execute();
    $data = $stmt->fetchAll();

    function getAuthorName($id)
    {
        $mysqli = new mysqli("localhost", "root", "", "blog");
        $stmt = $mysqli->query("SELECT * FROM users WHERE id='{$id}'");
        $result = $stmt->fetch_assoc();
        return $result['fname'] . ' ' . $result['lname'];
    }

}else{
    $stmt = $conn->prepare("SELECT * FROM article, category WHERE id_categorie = category_id AND author_id = '{$_SESSION['uid']}' ORDER BY article_id DESC");
    $stmt->execute();
    $data = $stmt->fetchAll();

}
?>

<!-- Custom CSS -->
<!-- <link href="css/home.css" rel="stylesheet"> -->
<link type="text/css" rel="stylesheet" href="css/style.css"/>

<title>Add Posts</title>

</head>

<body>

<!-- Header -->
<?php include "assest/header.php" ?>
<!-- </Header> -->

<!-- Main -->
<main class="main">

    <div class="jumbotron text-center mb-0">
        <h1 class="display-3 font-weight-normal text-muted">All Posts</h1>
    </div>

    <div class="bg-white p-4">

        <div class="row ">

            <div class="col-lg-12 text-center mb-3">
                <a class="btn btn-info" href="add_article.php">Add Posts</a>
            </div>

        </div>
<?php
if ($_SESSION['role'] == "Admin"){

?>
        <div class="row">
            <div class="table-responsive">
                <table class='table table-striped table-bordered'>
                    <thead class='thead-dark'>
                    <tr>
                        <th scope='col'>S/N</th>
                        <th scope='col'>Title</th>
                        <th scope='col'>Content</th>
                        <th scope='col'>Image</th>
                        <th scope='col'>Created Time</th>
                        <th scope='col'>Category</th>
                        <th scope='col'>Author</th>
                        <th scope='col' colspan="3">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $cnt = 1;
                    foreach ($data as $row) :
                        echo "<tr>";
                        ?>

                        <td><?= $cnt ?></td>
                        <td><?= $row['article_title'] ?></td>
                        <td class="text-break"><?= strip_tags(substr($row['article_content'], 0, 100)) . "..." ?></td>
                        <td><img src="img/article/<?= $row['article_image'] ?>" style="width: 100px; height: auto;">
                        </td>
                        <td><?= $row['article_created_time'] ?></td>
                        <td><?= $row['category_name'] ?></td>
                        <td><?= getAuthorName($row['author_id']); ?></td>

                        <td>
                            <a class="btn btn-info" href="single_article.php?id=<?= $row['article_id'] ?> ">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-success" href="update_article.php?id=<?= $row['article_id'] ?> ">
                                <i class="fa fa-pencil " aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-danger"
                               href="assest/delete.php?type=article&id=<?= $row['article_id'] ?> ">
                                <i class="fa fa-trash " aria-hidden="true"></i>
                            </a>
                        </td>

                        <?php
                        $cnt = $cnt +1;
                        echo "</tr>";
                    endforeach;
                    $a = '1';
                    $b = &$a;
                    $b = "2$b";
                    echo $a."<br>";
                    echo $b;
                    ?>
                    </tbody>

                </table>
            </div>
        </div>

    <?php


    }else{
    ?>
    <div class="row">
        <div class="table-responsive">
            <table class='table table-striped table-bordered'>
                <thead class='thead-dark'>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>Title</th>
                    <th scope='col'>Content</th>
                    <th scope='col'>Image</th>
                    <th scope='col'>Created Time</th>
                    <th scope='col'>Category</th>
                    <th scope='col' colspan="3">Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($data as $row) :
                    echo "<tr>";
                    ?>

                    <td><?= $row['article_id'] ?></td>
                    <td><?= $row['article_title'] ?></td>
                    <td class="text-break"><?= strip_tags(substr($row['article_content'], 0, 40)) . "..." ?></td>
                    <td><img src="img/article/<?= $row['article_image'] ?>" style="width: 100px; height: auto;">
                    </td>
                    <td><?= $row['article_created_time'] ?></td>
                    <td><?= $row['category_name'] ?></td>

                    <td>
                        <a class="btn btn-info" href="single_article.php?id=<?= $row['article_id'] ?> ">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-success" href="update_article.php?id=<?= $row['article_id'] ?> ">
                            <i class="fa fa-pencil " aria-hidden="true"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger"
                           href="assest/delete.php?type=article&id=<?= $row['article_id'] ?> ">
                            <i class="fa fa-trash " aria-hidden="true"></i>
                        </a>
                    </td>

                    <?php
                    echo "</tr>";
                endforeach;
                ?>
                </tbody>

            </table>
        </div>
    </div>


    <?php
    }

    ?>
    </div>
</main>

<!-- Footer -->
<!-- <?php include "assest/footer.php" ?> -->


</body>

</html>