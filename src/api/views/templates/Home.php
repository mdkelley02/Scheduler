<?php
namespace App\api\views;

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'TemplateHeader.php';?>
<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/home.css", true); ?>
</style>
<body>
    <div class="container">
        <div id="test">hello from home.php</div>
    </div>
</body>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/main.js", true); ?>
</script>
</html>
