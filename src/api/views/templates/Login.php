<?php
namespace App\api\views;

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'TemplateHeader.php';?>
<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/login.css", true); ?>
</style>
<body>
    <div class="container">
        <div class="row g-0 login-card">
            <div class="col-6 login-form">
                <div>
                    <h2 class="scheduler-logo">Scheduler</h2>
                    <p>Sign in to your account below.</p>
                    <div id="errorDialog" class="error-dialog">
                        <div><i class="fa fa-exclamation-triangle"></i><span id="errorMessage"></span></div>
                    </div>
                    <div class="d-flex flex-column">
                        <div><input type="text" id="email" placeholder="Email"></div>
                        <div><input type="password" id="password" placeholder="Password"></div>
                        <div><p>Don't have an account? <a href="/public/index.php/app/register">Register</a></p></div>
                        <div class="mt-2"><button id="loginButton">Login</button></div>
                    </div>
                </div>
            </div>
            <div class="col-6 p-0 login-infographic d-md-none d-lg-block">
                <div class="d-flex justify-content-center align-items-center p-4">
                    <div class="login-graphic"><?php echo file_get_contents(__DIR__ . "/../assets/graphic_one.svg"); ?></div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/main.js", true); ?>
</script>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/login.js", true); ?>
</script>
</html>
