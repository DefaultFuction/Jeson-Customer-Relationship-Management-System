<?php
require_once dirname(__DIR__) . '/config/database.php';

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function executeSystemCommand($command) {
    $output = shell_exec($command);
    return $output;
}

function sendCurlRequest($url, $method = 'GET', $data = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    if($method == 'POST' && !empty($data)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }
    
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function getServerInfo() {
    $info = [];
    $info['hostname'] = gethostname();
    $info['os'] = PHP_OS;
    $info['php_version'] = phpversion();
    $info['server_software'] = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'Unknown';
    $info['disk_free'] = disk_free_space("/");
    $info['disk_total'] = disk_total_space("/");
    return $info;
}
?>