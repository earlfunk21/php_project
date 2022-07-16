
<?php
if (isset($_SESSION["error_level"]) && isset($_SESSION["message"])){
    $alert = 'alert alert-' . $_SESSION["error_level"];
    echo "<div class=\"$alert\">" . $_SESSION['message'] . "</div>";
}
?>