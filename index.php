<?php
require __DIR__ . '/vendor/autoload.php';

use Bramus\Router\Router;

$setu_url = 'https://api.github.com/repos/laosepi/setu/git/trees/1383ad40b259f7b73989f62b298e230aa0dc0fdf';
$ua = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36';
$jsd = 'https://cdn.jsdelivr.net/gh/laosepi/setu/pics/';

$router = new Router();

$router->get('/refresh', function () use ($setu_url, $ua) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $setu_url);
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $res = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error ' . curl_error($ch);
        curl_close($ch);
        return;
    }
    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
        echo 'Error ' . $res;
        curl_close($ch);
        return;
    }
    curl_close($ch);
    $file = fopen('setu.json', 'w') or exit('open file error');
    fwrite($file, $res);
    fclose($file);
    echo 'successful';
});

function setu(){
    $file_name = 'setu.json';
    $file = fopen($file_name, 'r');
    $setu_file = fread($file, filesize($file_name));
    $setus = json_decode($setu_file, true)['tree'];
    fclose($file);
    return $setus[mt_rand(0, sizeof($setus))]['path'];
}

$router->get('/setu', function () use ($jsd) {
    $setu = setu();
    header('Content-Type: image/png');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $jsd . $setu);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_exec($ch);
    curl_close($ch);
});

$router->get('/setu!', function () use ($jsd) {
    $setu = setu();
    http_response_code(302);
    header('Location: ' . $jsd . $setu);
});

$router->run();