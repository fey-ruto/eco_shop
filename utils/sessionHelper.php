<?php
function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function destroySession() {
    session_destroy();
    header('Location: ../view/login.html');
    exit();
}
?>
