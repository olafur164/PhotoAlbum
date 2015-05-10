<?php include_once 'app/init.php'; ?>
<!DOCTYPE html>
<html>
<?php include_once 'assets/template/header.phtml'; ?>
    <body>
<?php include_once 'assets/template/navbar.phtml'; ?>
<?php if (!$user->isLoggedIn()): ?>
<?php include_once 'assets/template/modals.phtml'; ?>
        <!-- container -->
        <div class="container-fluid">
            <div class="container">
                <form class="form-signin" method="post" action="app/login.php">
                    <h1 class="form-signin-heading text-muted">Sign In</h1>
                    <input type="text" class="form-control" placeholder="Username" name="username" required="" autofocus="">
                    <input type="password" class="form-control" placeholder="Password" name="password" required="">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
<?php endif; ?>
<?php if ($user->isLoggedIn()): ?>
<?php Redirect::to('myImages.php'); ?>
<?php endif; ?>
        <!-- container ends -->
<?php include_once 'assets/template/footer.phtml'; ?>

        <script>
        $("img.lazy").lazyload({
            threshold : 150,
            effect : "fadeIn"
        });
        </script>
    </body>
</html>