<?php 
require_once 'app/init.php';
if (!$picID = Input::get('id')) {
    Redirect::to('index.php');
}
else 
{
?>
<!DOCTYPE html>
<html>
<?php include_once 'assets/template/header.phtml'; ?>
    <body>
<?php include_once 'assets/template/navbar.phtml'; ?>
        <!-- container -->
        <div class="container-fluid">
            <div class="panel">
    <?php $getImage = new DB(); 
    if ($user->isLoggedIn()) {
        $getImage = $data->getImageInfo($picID, $userData[0]);
        if ($getImage) {
            ?>
                <div class="marginsplit"></div>
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-md-push-4 col-lg-4 col-lg-push-4">
                        <img class="img-responsive" src="uploads/<?= $getImage[1]; ?>" alt="">
                    </div>
                    <div class="row"></div>
                    <div class="col-xs-12 col-md-push-5 col-lg-push-4">
                        <form class="form-horizontal" action="app/edit.php" method="post">
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <input type="text" class="form-control hidden" name="id" value="<?= $getImage[0]; ?>">
                                    <label for="">Current Image name: <?= $getImage[3]; ?></label>
                                    <input type="text" class="form-control" name="newName" placeholder="Enter New name for the image - <?= $getImage[3]; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <button type="submit" class="btn btn-success allstart" style="display: inline-block;">
                                        Edit!
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
        }
        else {
            echo 'this image is not yours';
        }
        ?>
        <?php include_once 'assets/template/footer.phtml'; ?>
        <?php
    }
}
?>