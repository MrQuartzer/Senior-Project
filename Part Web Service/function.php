<?php
    function clean($data) {
        $data = trim($data);
        $data = stripslashes($data);
        return $data;
    }

    function ShowPrompt() {
        echo "<div class='alert alert-success'>".$_SESSION['prompt']."</div>";
    }
    function ShowError() {
        echo "<div class='alert alert-danger'>".$_SESSION['errorprompt']."</div>";
    }
?>