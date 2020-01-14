<?php
    error_reporting(~0);
    ini_set('display_errors', 1);
    ini_set('default_socket_timeout', 7);

    function curl_get_contents($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_PORT, 80);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=UTF-8'));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
        include 'proxyinfo.php';

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

    function cmp($a, $b) {
        return strcmp($a->number, $b->number);
    }

    $feedUrl = 'http://feed.thisamericanlife.org/talpodcast';
    $remoteFeed = curl_get_contents($feedUrl);
    preg_match_all('/<item>.*?<\/item>/si', $remoteFeed, $matches);

    $remoteEpisodes = array();
    foreach ($matches[0] as $episode) {
        // echo $episode; //Debugging

        $genericObject = new stdClass();
        preg_match('/<pubDate>(.*?)<\/pubDate>/si', $episode, $date);
        preg_match('/<title>(\d+): (.*?)<\/title>/si', $episode, $title);
        preg_match('/<link>(.*?)<\/link>/si', $episode, $link);
        preg_match('/<description>(.*?)<\/description>/si', $episode, $description);
        preg_match('/<enclosure url="(.*?)"/si', $episode, $mp3);

        $genericObject->number = intval($title[1]);
        $genericObject->date = $date[1];
        $genericObject->title = $title[2];
        $genericObject->link = $link[1];
        $genericObject->description = preg_replace('/&lt;.*?&gt;/i', '', $description[1]);
        $genericObject->mp3 = $mp3[1];

        $remoteEpisodes[] = $genericObject;
    }

    global $localEpisodes;
    $localEpisodes = json_decode(file_get_contents('./tal.json'), true);
    foreach ($remoteEpisodes as $episode) {
        $arrayIndex = count($localEpisodes) - $episode->number;
        if ($arrayIndex < 0) {
            //New episode
            array_unshift($localEpisodes, $episode);
            usort($localEpisodes, function($a, $b) {
                if (is_object($a)) { $anum = $a->number; } else { $anum = $a['number']; }
                if (is_object($b)) { $bnum = $b->number; } else { $bnum = $b['number']; }
                return $bnum - $anum;
            });
        }
    }

    $myfile = fopen("tal.json", "w") or die("Unable to open file!");
    fwrite($myfile, json_encode($localEpisodes));
    fclose($myfile);

    include('./rss_output.php');
?>