<?php
    include('sidebar.php');
    $id  = $_GET['id'];
    $sql = "SELECT * FROM `news` WHERE id='$id'";
    $rs  = $connction->query($sql);
    $row = mysqli_fetch_assoc($rs);
    if($row['type']=='National'){
        $select_national = "selected";
    }else{
        $select_international = "selected";
    }
    if($row['category']=='Sport'){
        $select_sport = "selected";
    }else if($row['category']=='Social'){
        $select_social = "selected";
    }else{
        $select_ent = "selected";
    }
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Edit News Contents</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $row['title']?>" >
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="type" >
                                            <option value="National" <?php echo $select_national?> >National</option>
                                            <option value="Internetional" <?php echo $select_international?> >Internetional</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-select" name="category" >
                                            <option value="Sport" <?php echo $select_sport?> >Sport</option>
                                            <option value="Social"<?php echo $select_social?> >Social</option>
                                            <option value="Entertainment"<?php echo $select_ent?> >Entertainment</option>
                                        </select>
                                    </div>

                                    <div class="form-group ">
                                        <label class="d-flex">Thumbnail   (<p style="color: red;">Size 350x200</p>)</label>
                                        <input type="file" class="form-control" name="thumbnail" >
                                        <img src="assets/image/<?php echo $row['thumbnail'] ?>" width="120" height="120" style="object-fit: cover;" alt="">
                                        <!-- Hidden thumbnail -->
                                        <input type="hidden" value="<?php echo $row['thumbnail'] ?>" name="old_thumbnail" >
                                    </div>
                                    <div class="form-group">
                                        <label class="d-flex" >Banner  (<p style="color: red;">Size 730x415</p>)</label>
                                        <input type="file" class="form-control" name="banner" >
                                        <img src="assets/image/<?php echo $row['banner'] ?>" width="120" height="120" style="object-fit: cover;" alt="">
                                        <!-- Hidden banner -->
                                        <input type="hidden" value="<?php echo $row['banner'] ?>" name="old_banner" >
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" >
                                            <?php echo $row['description'] ?>
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <button name="btn_update" type="submit" class="btn btn-success">Update</button>
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