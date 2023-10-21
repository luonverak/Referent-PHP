<?php
    include('sidebar.php');
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Add Logo News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="type" >
                                            <option value="Header">Header</option>
                                            <option value="Footer">Footer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>File</label>
                                        <input type="file" name="thubmnail" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <button name="save_logo" type="submit" class="btn btn-primary">Save</button>
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