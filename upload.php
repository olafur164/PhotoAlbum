<?php include_once 'app/init.php'; ?>
<!DOCTYPE html>
<html>
<?php include_once 'assets/template/header.phtml'; ?>
    <body>
<?php include_once 'assets/template/navbar.phtml'; ?>
<?php if (!$user->isLoggedIn()): ?>
<?php include_once 'assets/template/modals.phtml'; ?>
<?php endif; ?>
        <!-- container -->
        <div class="container-fluid">
            <div class="upload-panel">


                <form id="upload" method="post" action="app/upload.php" enctype="multipart/form-data">
                    <input type="file" id="fileselect" name="fileselect[]" multiple="multiple">

                            <div class="row" id="files">
                            
                            </div>
                            <br>
                            <div class="multiple" style="display: block;">
                                <button type="submit" class="btn btn-success allstart" style="display: inline-block;">
                                    Upload
                                </button>
                            </div>
                </form>
            </div>
        </div>
        <!-- container ends -->
<?php include_once 'assets/template/footer.phtml'; ?>

		<script src="assets/js/dropzone.js"></script>
        <script src="assets/js/multiselect.js"></script>
    </body>
</html>