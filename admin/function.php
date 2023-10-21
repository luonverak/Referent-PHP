<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
    // connection
    $connction = new mysqli('localhost','root','','web_cms_3');
    // move image to folder
    function moveImage($profile){
        $image = date('dmyhis').'-'.$_FILES[$profile]['name'];
        $path    = './assets/image/'.$image;
        move_uploaded_file($_FILES[$profile]['tmp_name'],$path);
        return $image;
    }
    function registerAccount(){
        global $connction;
        if(isset($_POST['btn_register'])){
            $username = $_POST['username'];
            $email    = $_POST['email'];
            $password = md5($_POST['password']);
            $profile  = moveImage('profile');
            // get username for compare
            $getusername = "SELECT * FROM `user` WHERE 1";
            $r = $connction->query($getusername);
            while($row=mysqli_fetch_assoc($r)){
                if($username==$row['username']){
                    $username=null;
                }
            }
            if(!empty($username) && !empty($email) && !empty($password) && !empty($profile)){
                $sql = "INSERT INTO `user`(`username`, `email`, `password`, `profile`)
                        VALUES ('$username','$email','$password','$profile')";
                $rs  = $connction->query($sql);
                if($rs){
                    echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Created !",
                                    text: "Account has been created!",
                                    icon: "success",
                                    button: "Aww yiss!",
                                });
                            })
                        </script>
                        ';
                }
            }else{
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Something Wrong !",
                            text: "Account can\'t create!",
                            icon: "error",
                            button: "Aww yiss!",
                          });
                    })
                </script>
                ';
            }
        }
    }
    registerAccount();

    session_start();
    function login(){
        global $connction;
        if(isset($_POST['btn_login'])){
            $user_email = $_POST['name_email'];
            $password   = md5($_POST['password']);
            if(!empty($user_email) && !empty($password)){
                $sql = "SELECT id FROM `user`
                        WHERE (username='$user_email' OR email='$user_email') AND password='$password'";
                $rs  = $connction->query($sql);
                $row = mysqli_fetch_assoc($rs);
                if($row){
                    $_SESSION['user'] = $row['id'];
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Login Success !",
                                text: "Account has been login!",
                                icon: "success",
                                button: "Aww yiss!",
                            }).then((result) => {
                                if(result){
                                    window.location.href="index.php";
                                }
                            }).catch((err) => {
                                if(err){
                                }
                            });
                        })
                    </script>
                        ';
                }
            }else{
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Something Wrong !",
                            text: "Account can\'t login!",
                            icon: "error",
                            button: "Aww yiss!",
                          });
                    })
                </script>
                ';
            }
        }
    }
    login();
    function logOut(){
        global $connction;
        if(isset($_POST['btnLogOut'])){
            unset($_SESSION['user']);
            header('location: login.php');
        }
    }
    logOut();
    function addNewsPost(){
        global $connction;
        if(isset($_POST['btn_save'])){
            $title       = $_POST['title'];
            $type        = $_POST['type'];
            $category    = $_POST['category'];
            $thumbnail   = moveImage('thumbnail');
            $banner      = moveImage('banner');
            $description = $_POST['description'];
            $author_id   = $_SESSION['user'];
            if(!empty($title) && !empty($type) && !empty($category) && !empty($thumbnail) && !empty($banner) && !empty($description) && !empty($author_id)){
                $sql = "INSERT INTO `news`(`author_id`, `type`, `category`, `title`, `description`, `banner`, `thumbnail`)
                        VALUES ('$author_id','$type','$category','$title','$description','$banner','$thumbnail')";
                $rs  = $connction->query($sql);
                if($rs){
                    echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Success !",
                                    text: "Insert success!",
                                    icon: "success",
                                    button: "Aww yiss!",
                                });
                            })
                        </script>
                        ';
                }
            }else{
                    echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Error !",
                                    text: "Can not insert!",
                                    icon: "error",
                                    button: "Aww yiss!",
                                });
                            })
                        </script>
                        ';

            }
        }
    }
    addNewsPost();
    function getNewsPost(){
        global $connction;
        $sql="SELECT t_user.username,t_news.* FROM `user` as t_user INNER JOIN `news` as t_news ON t_user.id = t_news.author_id";
        $rs = $connction->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y',strtotime($date));
            echo '
            <tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['title'].'</td>
                <td>'.$row['type'].'</td>
                <td>'.$row['category'].'</td>
                <td><img src="assets/image/'.$row['thumbnail'].'" width="110" hiegth="110" style="object-fit:cover;" /></td>
                <td>'.$row['views'].'</td>
                <td>'.$date.'</td>
                <td>'.$row['username'].'</td>
                <td width="150px">
                    <a href="update-news-post.php?id='.$row['id'].'"class="btn btn-success">Update</a>
                    <button type="button" remove-id="'.$row['id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Remove
                    </button>
                </td>
            </tr>
            ';
        }
    }
    function updateNewsPost(){
        global $connction;
        if(isset($_POST['btn_update'])){
            $title       = $_POST['title'];
            $type        = $_POST['type'];
            $category    = $_POST['category'];
            $thumbnail   = $_FILES['thumbnail']['name'];
            $banner      = $_FILES['banner']['name'];
            $description = $_POST['description'];
            $author_id   = $_SESSION['user'];
            $id          = $_GET['id'];
            if(empty($thumbnail)){
                $thumbnail = $_POST['old_thumbnail'];
            }else{
                $thumbnail   = moveImage('thumbnail');
            }
            if(empty($banner)){
                $banner = $_POST['old_banner'];
            }else{
                $banner      = moveImage('banner');
            }
            if(!empty($title) && !empty($type) && !empty($category) && !empty($thumbnail) && !empty($banner) && !empty($description) && !empty($author_id)){
                $update_at = date('d/M/Y');
                $sql = "UPDATE `news`
                        SET `author_id`='$author_id',`type`='$type',`category`='$category',`title`='$title',`description`='$description',`banner`='$banner',`thumbnail`='$thumbnail',`update_at`='$update_at'
                        WHERE `id`='$id'";
                $rs  = $connction->query($sql);
                if($rs){
                    echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Success !",
                                    text: "Update success!",
                                    icon: "success",
                                    button: "Aww yiss!",
                                });
                            })
                        </script>
                        ';
                }
            }else{
                    echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Error !",
                                    text: "Can not insert!",
                                    icon: "error",
                                    button: "Aww yiss!",
                                });
                            })
                        </script>
                        ';

            }
        }
    }
    updateNewsPost();
    function deleteNewsPost(){
        global $connction;
        if(isset($_POST['accept_delete'])){
            $id  = $_POST['remove_id'];
            $sql = "DELETE FROM `news` WHERE id='$id'";
            $rs  = $connction->query($sql);
            if($rs){
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Deleted !",
                            text: "Data has been delete!",
                            icon: "success",
                            button: "Aww yiss!",
                        });
                    })
                </script>
                    ';
            }
        }
    }
    deleteNewsPost();
    function addLogoPost(){
        global $connction;
        if(isset($_POST['save_logo'])){
            $type      = $_POST['type'];
            $thubmnail = moveImage('thubmnail');
            if(!empty($type) && !empty($thubmnail)){
                $sql = "INSERT INTO `logo`(`type`, `thumbnail`) VALUES ('$type','$thubmnail')";
                $rs  = $connction->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Inserted !",
                                text: "Data has been insert!",
                                icon: "success",
                                button: "Aww yiss!",
                            });
                        })
                    </script>
                        ';
                }
            }
        }
    }
    addLogoPost();
    function getLogoPost(){
        global $connction;
        $sql = "SELECT * FROM `logo`";
        $rs  = $connction->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
            <tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['type'].'</td>
                <td><img src="assets/image/'.$row['thumbnail'].'" /></td>
                <
                <td width="150px">
                    <a href="update-logo-post.php?id='.$row['id'].'"class="btn btn-primary">Update</a>
                    <button type="button" remove-id="'.$row['id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Remove
                    </button>
                </td>
            </tr>
            ';
        }
    }
    function updateLogoPost(){
        global $connction;
        if(isset($_POST['update_logo'])){
            $id = $_GET['id'];
            $type = $_POST['type'];
            $thumbnail = $_FILES['thumbnail']['name'];
            if(empty($thumbnail)){
                $thumbnail = $_POST['old_thumbnail'];
            }else{
                $thumbnail = moveImage('thubmnail');
            }
            if(!empty($type) && !empty($thumbnail)){
                $sql = "UPDATE `logo`
                        SET `type`='$type',`thumbnail`='$thumbnail'
                        WHERE `id`='$id'";
                $rs  = $connction->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Updated !",
                                text: "Data has been update!",
                                icon: "success",
                                button: "Aww yiss!",
                            });
                        })
                    </script>
                        ';
                }
            }
        }
    }
    updateLogoPost();
    function deleteLogoPost(){
        global $connction;
        if(isset($_POST['delete_logo'])){
            $id  = $_POST['remove_id'];
            $sql = "DELETE FROM logo WHERE id='$id'";
            $rs  = $connction->query($sql);
            if($rs){
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Deleted !",
                            text: "Data has been delete!",
                            icon: "success",
                            button: "Aww yiss!",
                        });
                    })
                </script>
                    ';
            }
        }
    }
    deleteLogoPost();
?>