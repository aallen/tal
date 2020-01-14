<?php
    error_reporting(~0);
    ini_set('display_errors', 1);
    ini_set('default_socket_timeout', 7);

    function curl_get_contents($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_PORT, 80);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=UTF-8'));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');

        $data = curl_exec($ch);

        $info = curl_getinfo($ch);
        $errContent = curl_error($ch);

        if ($errContent) {
            echo $errContent . "<br/>\n\n";
            print_r($info);
        }
        curl_close($ch);
        return $data;
    }

    $feedUrl = 'http://feed.thisamericanlife.org/talpodcast';
    $remoteFeed = curl_get_contents($feedUrl);

    echo $remoteFeed;

    // $localFile = file_get_contents('./tal.json');
    // $jsonFile = $localFile;

    // if ($localFile) {
    // } else {
    //     // $feedContent = file_get_contents($feedUrl);
    //     // echo $feedContent;
    // }

?>