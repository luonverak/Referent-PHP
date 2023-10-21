<?php
    include('sidebar.php');
    $id  = $_GET['id'];
    $sql = "SELECT * FROM `logo` WHERE id='$id'";
    $rs  = $connction->query($sql);
    $row = mysqli_fetch_assoc($rs);
    if($row['type']=='Header'){
        $selectHeader = 'selected';
    }else{
        $selectFooter = 'selected';
    }
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Edit Logo News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="type" >
                                            <option value="Header" <?php echo $selectHeader?>>Header</option>
                                            <option value="Footer"<?php echo $selectFooter?>>Footer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>File</label>
                                        <input type="file" name="thubmnail" class="form-control">
                                        <img src="assets/image/<?php echo $row['thumbnail']?>" alt="">
                                        <input name="old_thumbnail" type="hidden" value="<?php echo $row['thumbnail']?>" >
                                    </div>

                                    <div class="form-group">
                                        <button name="update_logo" type="submit" class="btn btn-success">Update</button>
                                        <a href="index.php" type="submit" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>