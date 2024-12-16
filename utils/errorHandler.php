<?php
function logError($errorMessage) {
    $errorLog = '../logs/error_log.txt';
    file_put_contents($errorLog, date('Y-m-d H:i:s') . " - $errorMessage\n", FILE_APPEND);
}
?>
