<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function logMessage($text) {
    $log_date = date('Y-m-d H:i:s.u');
    $filename = '/var/log/sms.log';
    file_put_contents($filename, "$log_date  $text\n", FILE_APPEND);
}

logMessage("Start script");

$phoneNumbers = explode(" ", $_POST['phone']);
$message = $_POST['message'];
$param = '0';

if ($param == '1') {
    $message = substr($message, 0, 70);
}

foreach($phoneNumbers as $phone) {
    try {
        $url = '....'; // здесь адрес sms-шлюза
        $params = http_build_query(['num' => $phone, 'msg' => $message]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        logMessage("Sending: $phone $message");

        sleep(3); // задержка в 3 секунды

    } catch (\Exception $e) {
        logMessage("Exception: " . $e->getMessage());
    }
}

logMessage("End script");

header("Location: send.html?success=true"); // редирект обратно на форму с сообщением об успехе
?>







                                                                                                                                                          
