<?php

include_once "functions.php";

$filePath = "log.txt";
$file = new AccessAnalyzer($filePath);

$output = [
    "views" => $file->viewsCount(),
    "urls" => $file->urlsCount(),
    "traffic" => $file->trafficCount(),
    "crawlers" => $file->crawlersCount(),
    "statusesCodes" => $file->statusesCount(),
];

echo json_encode($output);

?>