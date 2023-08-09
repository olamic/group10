<?php //include "assest/head.php"; ?>
<?php
$conn = new mysqli("localhost", "root", "", "blog");
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page

$loggedin = false;

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $loggedin = true;

}
// Define variables and initialize with empty values

$err="";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $cpassword = trim($_POST['cpassword']);
    $role = "Users";
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $twitter = trim($_POST['twitter']);
    $linkedIn = trim($_POST['linkedIn']);
    if (!empty($username) && !empty($email) && !empty($password) && !empty($fname) && !empty($lname)) {
        // Validate credentials
        if ($password && $cpassword) {
            $hashedPassword = hash("SHA512", $password);
            // Prepare a select statement
            $sql = "INSERT INTO users (email, username, password, fname, lname, role, twitter, linked_in) 
                  VALUES ('{$email}','{$username}','{$hashedPassword}','{$fname}','{$lname}','{$role}','{$twitter}','{$linkedIn}')";
            $stmt = $conn->query($sql);
            if ($stmt) {
                // Redirect user to welcome page
                header("location: index.php");
            } else {
                // Display an error message if password is not valid
                $err = "The password you entered was not valid.";
            }
        }else{
            $err = "Two password do not match.";
        }
    }else{
        $err = "One or more required fields are not completed.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="#" sizes="32x32" type="image/png">

    <!-- Bootstrap, FontAwesome, Custom Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="css/style.css"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet">


    <title>Login</title>
</head>

<body class="d-flex flex-column min-vh-100">

<?php include "assest/header.php" ?>
<!-- Main -->
<main class="main">

    <!-- Latest Articles -->
    <div class="section jumbotron mb-0 h-100">
        <!-- container -->
        <div class="container d-flex flex-column justify-content-center align-items-center h-100">

            <div class="wrapper my-0 pt-3 bg-white w-50 text-center">
                <span class="font-weight-bold h1" style="width: 100px;height: auto;">WELCOME</span>
            </div>

            <!-- row -->
            <div class="wrapper bg-white rounded px-4 py-4 w-50">
                <?php if ($err){  ?>
                <span class="alert alert-warning"><?= $err; ?></span>
                <?php } ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="row">
                    <div class=" col-lg-6 form-group ">
                        <label>First Name</label><span class="text-danger">*</span>
                        <input type="text" name="fname"
                               class="form-control" value="">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>Last Name</label><span class="text-danger">*</span>
                        <input type="text" name="lname"
                               class="form-control" value="">
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-6 form-group">
                        <label>Email</label><span class="text-danger">*</span>
                        <input type="email" name="email"
                               class="form-control" value="">
                    </div>

                    <div class="col-lg-6 form-group">
                        <label>Username</label><span class="text-danger">*</span>
                        <input type="text" name="username"
                               class="form-control" value="">
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-6 form-group">
                        <label>Password </label><span class="text-danger">*</span>
                        <input type="password" name="password"
                               class="form-control">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>Confirm Password</label><span class="text-danger">*</span>
                        <input type="password" name="cpassword"
                               class="form-control">
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-lg-6 form-group">
                        <label>Twitter</label>
                        <input type="text" name="twitter"
                               class="form-control">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>Linked In </label>
                        <input type="text" name="linkedIn"
                               class="form-control">
                    </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Register">
                    </div>
                    <p>Already registered? <a href="login.php" class="text-muted">Login</a></p>

                </form>
            </div>

            <!-- /row -->

        </div>
        <!-- /container -->
    </div>


</main><!-- </Main> -->

<!-- Footer -->
<!-- <?php include "assest/footer.php" ?> -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>