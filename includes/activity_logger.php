<?php
function writeActivityLog($message) {
    $logDirectory = __DIR__ . "/../logs";
    $logFile = $logDirectory . "/activity_log.txt";

    if (!is_dir($logDirectory)) {
        mkdir($logDirectory, 0755, true);
    }

    $dateTime = date("Y-m-d H:i:s");
    $entry = "[" . $dateTime . "] " . $message . PHP_EOL;

    file_put_contents($logFile, $entry, FILE_APPEND);
}
?>