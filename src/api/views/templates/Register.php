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
                    <p>Register for an account below.</p>
                    <div id="errorDialog" class="error-dialog">
                        <div><i class="fa fa-exclamation-triangle"></i><span id="errorMessage"></span></div>
                    </div>
                    <div class="d-flex">
                        <div><input type="text" id="name" placeholder="Name"></div>
                        <div><input type="text" id="email" placeholder="Email"></div>
                        <div><input type="password" id="password" placeholder="Password"></div>
                        <div><input type="password" id="confirmPassword" placeholder="Confirm Password"></div>
                        <div><p>Already have an account? <a href="/app/login">Login</a></p></div>
                        <div><button id="registerButton">Register</button></div>
                    </div>
                </div>
            </div>
            <div class="col-6 p-0 login-infographic d-md-none d-lg-block">
                <div class="d-flex justify-content-center align-items-center">
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
    <?php echo file_get_contents(__DIR__ . "/../scripts/register.js", true); ?>
</script>
</html>
