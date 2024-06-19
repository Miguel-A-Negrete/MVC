<?php
function flash($name = '', $message = '', $class = 'form-message form-message-red') {
    if (!empty($name) && !empty($message)) {
        echo '<div class="' . $class . '">' . $message . '</div>';
    }
}

function redirect($location) {
    header("location: " . $location);
    exit();
}
?>