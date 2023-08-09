<?php
session_start();
$conn = new mysqli("localhost", "root", "", "blog");

function insertToDB($conn, $table, $data)
    {

        // Get keys string from data array
        $columns = implodeArray(array_keys($data));

        $values = implodeArray($data);

//    var_dump(array_count_values($data));

        try {
            var_dump($data);
            var_dump($columns);
            var_dump($values);
            // $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            // $stmt = $conn->query($sql);
            // // prepare sql and bind parameters
            // if ($stmt) {
            //     echo "Success";
            // } else {
            //     echo "Error" . $conn->error;
            // }
//        echo "New records created successfully";
        } catch (PDOException $error) {
            echo $error;
        }
    }

    function implodeArray($array)
    {
        return implode(", ", $array);
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
<?php

// Get type from header
$type = $_GET['type'];

if ($conn) {

    if (isset($_POST["submit"])) {

        switch ($type) {
            case "article":
                try {
                    // Upload Image
                    uploadImage2("arImage", "../img/article/");

                    // PREPARE DATA TO INSERT INTO DB
                    $data = array(
                        "article_title" => '"' . test_input($_POST["arTitle"]) . '"',
                        "article_content" => '"' . $_POST["arContent"] . '"',
                        "article_image" => '"' . test_input($_FILES["arImage"]["name"]) . '"',
                        "article_created_time" => '"' . date('Y-m-d H:i:s') . '"',
                        "id_categorie" => test_input($_POST["arCategory"]),
                        "author_id" => $_SESSION['uid']
                    );

                    // $tableName = 'article';

                    // Call insert function
                    insertToDB($conn, $type, $data);
                    $message = "Successfully added post";
                    // Go to show.php
                    header("Location: ../add_article.php?success=$message", true, 301);
                } catch (Exception $e) {
                    header("Location: ../add_article.php?error=$e", true, 301);
                }
                exit;
                break;

            case "category":
                try {
                    // Upload Image
                    uploadImage2("catImage", "../img/category/");

                    // PREPARE DATA TO INSERT INTO DB
                    $data = array(
                        "category_name" => '"' . $_POST["catName"] . '"',
                        "category_image" => '"' . $_FILES["catImage"]["name"] . '"',
                        "category_color" => '"' . $_POST["catColor"] . '"',
                    );

                    $tableName = 'category';
                    insertToDB($conn, $tableName, $data);
                    $message = "Successfully added a category";
                    header("Location: ../categories.php&success=$message", true, 301);
                } catch (Exception $e) {
                    header("Location: ../add_article.php?error=$e", true, 301);
                }

                // Go to show.php/**/
               header("Location: ../categories.php", true, 301);
                exit;
                break;

            case "comment":
                try {

                    $id = test_input($_POST["id_article"]);

                    // PREPARE DATA TO INSERT INTO DB
                    $data = array(
                        "comment_username" => test_input($_POST["username"]),
                        // "comment_avatar" => test_input($_POST["comment_avatar"]),
                        "comment_content" => test_input($_POST["comment"]),
                        "comment_date" => date('Y-m-d H:i:s'),
                        "id_article" => test_input($_POST["id_article"])
                    );

                    $tableName = 'comment';

                    // Call insert function
                    insertToDB($conn, $tableName, $data);
                    // Go to show.php
                    $response = "id=$id";
                }catch (Exception $e){
                    // print_r($e);
                    $response = "error=$e";
                }

                // header("Location: ../single_article.php?$response", true, 301);

                exit;
                break;

            default:
                echo "ERROR";
                break;
                
    }
    } else {
        echo 'Error: ' . $e->getMessage();
    }

// function uploadImage($name, $dest){
//     // Upload Image
//     $fileName = $_FILES[$name]['name'];
//     $fileTmpName = $_FILES[$name]['tmp_name'];
//     $fileError = $_FILES[$name]['error'];

//     if($fileError === 0){
//         $fileDestination = $dest.$fileName;
//         move_uploaded_file($fileTmpName, $fileDestination);
//         echo "Image Upload Successful";
//     }else {
//         echo "Image Upload Error";
//     }
// }

    function uploadImage2($name, $dest)
    {

        $target_dir = $dest;
        $target_file = $target_dir . basename($_FILES[$name]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (file_exists($target_file)) {
            echo("Sorry, file already exists.");
        } // Check file size
        elseif ($_FILES[$name]["size"] > 5000000000) {
            echo("Sorry, your file is too large.");

        } // Allow certain file formats
        elseif (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        } else {
            // Check if $uploadOk is set to 0 by an error

            if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
//            echo("Success");
            } else {
                echo("Sorry, there was an error uploading your file.");
            }
        }

    }

}
    ?>
