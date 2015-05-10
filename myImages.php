<?php include_once 'app/init.php'; ?>
<?php if (!$user->isLoggedIn()) {
    Session::flash('warning', 'Þú hefur ekki aðgang að þessari síðu. Vinsamlegast skráðu þig fyrst á síðuna.');
    Redirect::to('index.php'); 
}
?>
<!DOCTYPE html>
<html>
<?php include_once 'assets/template/header.phtml'; ?>
    <body>
<?php include_once 'assets/template/navbar.phtml'; ?>
        <!-- container -->
        <div class="container-fluid">
            <div class="panel">
<?php if ($user->isLoggedIn()): ?>
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
                <div class="marginsplit"></div>
                <div id="gallery-content">
                    <div id="gallery-content-center">
<?php foreach ($userImage as $value => $image): ?>
                        <a class="fancybox" rel="group" data-title-id="<?= $image[0]; ?>" href="uploads/<?php echo $image[1]; ?>">
                            <img class="all lazy img-responsives" src="uploads/thumbnails/<?php echo $image[2]; ?>" alt="</a><?= $image[3]; ?>">
                        </a>
                        <div id="<?= $image[0]; ?>" class="hidden">
                            <a href="download.php?file=<?= $image[1]; ?>">Download</a> 
                            <a href="edit.php?id=<?= $image[0]; ?>">Edit</a>
                            <br>
                            <h2><?= $image[3]; ?></h2>
                        </div>
<?php endforeach; ?>
                    </div>
                </div>
<?php endif; ?>
                
            </div>
        </div>
        <!-- container ends -->
<?php include_once 'assets/template/footer.phtml'; ?>

        <script type="text/javascript">
            $(".fancybox")
                .fancybox({
                beforeLoad: function() {
                var el, id = $(this.element).data('title-id');

                if (id) {
                    el = $('#' + id);
                
                    if (el.length) {
                        this.title = el.html();
                    }
                }

                },
                helpers : {
                    title: {
                        type: 'inside'
                    }
                }
            });
        </script>

        <script>
        $("img.lazy").lazyload({
            threshold : 150,
            effect : "fadeIn"
        });
        </script>

        <script src="assets/js/dropzone.js"></script>
        <script src="assets/js/multiselect.js"></script>
    </body>
</html>