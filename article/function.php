<!-- @import jquery & sweet alert  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
    $connction = new mysqli('localhost','root','','web_cms_3');

    function getLogo($type){
        global $connction;
        $sql = "SELECT * FROM `logo` WHERE type='$type' ORDER BY id DESC LIMIT 1";
        $rs  = $connction->query($sql);
        $row = mysqli_fetch_assoc($rs);
        echo $row['thumbnail'];
    }
    function getTrending(){
        global $connction;
        $sql = "SELECT * FROM `news` ORDER by id DESC LIMIT 3";
        $rs  = $connction->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
                <i class="fas fa-angle-double-right"></i>
                <a href="news-detail.php?id='.$row['id'].'">'.$row['title'].'</a>
            ';
        }
    }
    function getNewsDetail($id){
        global $connction;
        $sql = "SELECT * FROM `news` WHERE id='$id'";
        $rs  = $connction->query($sql);
        $row = mysqli_fetch_assoc($rs);
        $date = $row['create_at'];
        $date = date('d/M/Y',strtotime($date));
        echo '
            <div class="main-news">
                <div class="thumbnail">
                    <img src="../admin/assets/image/'.$row['banner'].'">
                </div>
                <div class="detail">
                    <h3 class="title">'.$row['title'].'</h3>
                    <div class="date">'.$date.'</div>
                    <div class="description">'.$row['description'].'</div>
                </div>
            </div>
        ';
    }
    function getNewsType($id){
        global $connction;
        $sql = "SELECT * FROM `news` WHERE id='$id'";
        $rs  = $connction->query($sql);
        $row = mysqli_fetch_assoc($rs);
        return $row['type'];
    }
    function getRateNews($id){
        global $connction;
        $type= getNewsType($id);
        $sql ="SELECT * FROM `news` WHERE type='$type' AND id NOT IN($id) ORDER BY id DESC LIMIT 3";
        $rs  =$connction->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
            <figure>
                <a href="news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" alt="">
                    </div>
                    <div class="detail">
                        <h3 class="title">'.$row['title'].'</h3>
                        <div class="date">17/July/2022</div>
                        <div class="description">'.$row['description'].'</div>
                    </div>
                </a>
            </figure>
            ';
        }
    }
    function getViews($id){
        global $connction;
        $sql = "UPDATE `news` SET `views`=`views`+1  WHERE id='$id'";
        $rs  = $connction->query($sql);
    }
    function getMinNews($type){
        global $connction;
        if($type=='Trending'){
            $sql = "SELECT * FROM `news` ORDER by `views` DESC  LIMIT 1";
            $rs  = $connction->query($sql);
            $row = mysqli_fetch_assoc($rs);
            echo '
            <div class="col-8 content-left">
                <figure>
                    <a href="news-detail.php?id='.$row['id'].'">
                        <div class="thumbnail">
                            <img src="../admin/assets/image/'.$row['banner'].'" alt="">
                            <div class="title">'.$row['title'].'</div>
                        </div>
                    </a>
                </figure>
            </div>
            ';
        }else{
            $sql = "SELECT * FROM `news` WHERE id !=(SELECT id FROM `news` ORDER by `views` DESC  LIMIT 1) ORDER BY id DESC LIMIT 2";
            $rs  = $connction->query($sql);
            while($row = mysqli_fetch_assoc($rs)){
                echo '
                    <div class="col-12">
                        <figure>
                            <a href="news-detail.php?id='.$row['id'].'">
                                <div class="thumbnail">
                                    <img src="../admin/assets/image/'.$row['banner'].'" width="350" alt="">
                                    <div class="title">'.$row['title'].'</div>
                                </div>
                            </a>
                        </figure>
                    </div>
                    ';
            }
        }
    }
    function search($query){
        global $connction;
        $sql = "SELECT * FROM `news` WHERE `title` LIKE '%$query%'";
        $rs  = $connction->query($sql);
        while($row = mysqli_fetch_assoc($rs)){
          echo '
            <div class="col-4">
                <figure>
                    <a href="">
                        <div class="thumbnail">
                            <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" alt="">
                        </div>
                        <div class="detail">
                            <h3 class="title">'.$row['title'].'</h3>
                            <div class="date">'.$row['create_at'].'</div>
                            <div class="description">'.$row['description'].'</div>
                        </div>
                    </a>
                </figure>
            </div>
            ';
        }
    }
    function listNews($category,$type,$page,$limit){
        global $connction;
        $start = ($page-1) * $limit;
        $sql = "SELECT * FROM `news` WHERE (`category`='$category' AND `type`='$type')
                ORDER BY id DESC LIMIT $start,$limit";
        $rs  = $connction->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
                        <div class="col-4">
                            <figure>
                                <a href="news-detail.php?id='.$row['id'].'">
                                    <div class="thumbnail">
                                        <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" alt="">
                                    </div>
                                    <div class="detail">
                                        <h3 class="title">'.$row['title'].'</h3>
                                        <div class="date">'.$row['create_at'].'</div>
                                        <div class="description">'.$row['description'].'</div>
                                    </div>
                                </a>
                            </figure>
                        </div>
                        ';
        }
    }
    function getPageInage($category,$type,$limit){
        global $connction;
        $sql = "SELECT COUNT(`id`) as total_id FROM `news`
                WHERE (`category`='$category' AND type='$type')";
        $rs  = $connction->query($sql);
        $row = mysqli_fetch_assoc($rs);
        $total_id = $row['total_id'];
        $page = ceil($total_id/$limit);
        for($i=1;$i<=$page;$i++){
            echo '
                <li>
                    <a href="?page='.$i.'">'.$i.'</a>
                </li>
            ';
        }
    }
    function getAllNews($category,$limit){
        global $connction;
        $sql = "SELECT * FROM `news` WHERE `category`='$category' ORDER BY id DESC LIMIT $limit";
        $rs  = $connction->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
            <div class="col-4">
                <figure>
                    <a href="news-detail.php?id='.$row['id'].'">
                        <div class="thumbnail">
                            <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" alt="">
                        <div class="title">'.$row['title'].'</div>
                        </div>
                    </a>
                </figure>
            </div>
            ';
        }
    }
?>