<!DOCTYPE html>
<?php
    include('function.php');
    $user_id = $_SESSION['user'];
    if(empty($_SESSION['user'])){
        header('location: login.php');
    }
    $sql = "SELECT * FROM `user` WHERE id='$user_id'";
    $rs  = $connction->query($sql);
    $row = mysqli_fetch_assoc($rs);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- @theme style -->
    <link rel="stylesheet" href="assets/style/theme.css">

    <!-- @Bootstrap -->
    <link rel="stylesheet" href="assets/style/bootstrap.css">

    <!-- @script -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/bootstrap.js"></script>

    <!-- @tinyACE -->
    <script src="https://cdn.tiny.cloud/1/5gqcgv8u6c8ejg1eg27ziagpv8d8uricc4gc9rhkbasi2nc4/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</head>
<body>
    <main class="admin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <div class="content-left">
                        <!-- <div class="wrap-top">
                            <img src="assets/icon/admin-logo.png" alt="">
                            <h5>Jong Deng News</h5>
                        </div> -->
                        <a href="index.php" style="background-color: transparent;">
                        <div class="wrap-center">
                            <img src="./assets/image/<?php echo $row['profile']?>" width="40" height="40" style="object-fit: cover;" alt="">
                            <h6>Welcome Admin <?php echo $row['username']?></h6>
                        </div>
                        </a>
                        <div class="wrap-bottom">
                            <ul>
                                <li class="parent">
                                    <a class="parent" href="javascript:void(0)">
                                        <span>News Content</span>
                                        <img src="assets/icon/arrow.png" alt="">
                                    </a>
                                    <ul class="child">
                                        <li>
                                            <a href="view-news-post.php">View Post</a>
                                            <a href="add-news-post.php">Add New</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent">
                                    <a class="parent" href="javascript:void(0)">
                                        <span>News Logo</span>
                                        <img src="assets/icon/arrow.png" alt="">
                                    </a>
                                    <ul class="child">
                                        <li>
                                            <a href="view-logo-post.php">View Post</a>
                                            <a href="add-logo-post.php">Add New</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="parent">
                                    <a class="parent" href="logout.php">
                                        <span>LogOut</span>
                                        <img src="assets/icon/arrow.png" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>