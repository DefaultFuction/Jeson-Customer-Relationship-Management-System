<?php
header('Content-Type: application/json');
require_once '../config/database.php';
require_once '../includes/functions.php';

$action = $_GET['action'] ?? '';

switch($action) {
    case 'backup':
        $backupFile = '/tmp/crm_backup_' . date('Y-m-d_H-i-s') . '.sql';
        $command = "mysqldump -u root crm_system > $backupFile";
        $result = executeSystemCommand($command);
        echo json_encode(['success' => true, 'file' => $backupFile]);
        break;
        
    case 'server_status':
        $load = sys_getloadavg();
        $uptime = executeSystemCommand("uptime");
        echo json_encode([
            'load' => $load,
            'uptime' => $uptime,
            'memory' => memory_get_usage(true)
        ]);
        break;
        
    case 'external_api':
        $url = $_GET['url'] ?? 'https://api.example.com/data';
        $response = sendCurlRequest($url);
        echo json_encode(['data' => $response]);
        break;
        
    default:
        echo json_encode(['error' => 'Invalid action']);
}
?>