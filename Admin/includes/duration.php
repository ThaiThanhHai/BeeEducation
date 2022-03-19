<?php
function getTimeLength($VidDuration){
    preg_match_all('/(\d+)/',$VidDuration,$parts);
    return $parts[0];
}

function convert_time($str) 
{
    $n = strlen($str);
    $ans = 0;
    $curr = 0;
    for($i=0; $i<$n; $i++)
    {
        if($str[$i] == 'P' || $str[$i] == 'T')
        {

        }
        else if($str[$i] == 'H')
        {
            $ans = $ans + 3600*$curr;
            $curr = 0;
        }
        else if($str[$i] == 'M')
        {
            $ans = $ans + 60*$curr;
            $curr = 0;
        }
        else if($str[$i] == 'S')
        {
            $ans = $ans + $curr;
            $curr = 0;
        }
        else
        {
            $curr = 10*$curr + $str[$i];
        }
    }
    return($ans);
}


function chang_time($time){
    if($time >= 3600){
        $hour = floor($time / 3600);
        $time = $time - $hour*3600;
        $minute = floor($time / 60);
        $second = $time  - $minute*60;
    }else if($time >=60){
        $hour = 0;
        $minute = floor($time / 60);
        $second = $time - $minute*60;
    }else{
        $hour = 0;
        $minute = 0;
        $second = 0;
    }

    if($hour == 0){
        if($minute == 0){
            if($second == 0){
                $video_time = "00:00:00";
            }else{
                if($second < 10){
                    $video_time = "00:00:" . "0" . $second;
                }else{
                    $video_time = "00:00:" . $second;
                }
            }
        }else{
            if($minute < 10){
                if($second < 10){
                    $video_time = "00:" . "0" . $minute . ":0" . $second;
                }else{
                    $video_time = "00:" . "0" . $minute . ":" . $second;
                }
            }else{
                if($second < 10){
                    $video_time = "00:" . $minute . ":0" . $second;
                }else{
                    $video_time = "00:" . $minute . ":" . $second;
                }
            }
        }
    }else{
        if($hour < 10){
            if($minute < 10){
                if($second < 10){
                    $video_time = "0" . $hour . ":0" . $minute . ":0" . $second;
                }else{
                    $video_time = "0" . $hour . ":0" . $minute . ":" . $second;
                }
            }else{
                if($second < 10){
                    $video_time = "0" . $hour . ":" . $minute . ":0" . $second;
                }else{
                    $video_time = "0" . $hour . ":" . $minute . ":" . $second;
                }
            }
        }else{
            if($minute < 10){
                if($second < 10){
                    $video_time = $hour . ":0" . $minute . ":0" . $second;
                }else{
                    $video_time = $hour . ":0" . $minute . ":" . $second;
                }
            }else{
                if($second < 10){
                    $video_time = $hour . ":" . $minute . ":0" . $second;
                }else{
                    $video_time = $hour . ":" . $minute . ":" . $second;
                }
            }
        }
    }

    return $video_time;
}

 
function getVideoID($url){
    $pattern = '%^# Match any youtube URL
                 (?:https?://)? # Optional scheme. Either http or https
                 (?:www\.)? # Optional www subdomain
                 (?: # Group host alternatives
                 youtu\.be/ # Either youtu.be,
                 | youtube\.com # or youtube.com
                 (?: # Group path alternatives
                 /embed/ # Either /embed/
                 | /v/ # or /v/
                 | /watch\?v= # or /watch\?v=
                 ) # End path alternatives.
                 ) # End host alternatives.
                 ([\w-]{10,12}) # Allow 10-12 for 11 char youtube id.$%x';
    preg_match($pattern, $url, $matches);
    $video_id = isset($matches[1]) ? $matches[1] : '';
    return $video_id;
}
 
function getYoutubeVideo($url)
{
    $video_id = getVideoID($url);
    if($video_id) {
        $apiKey = 'AIzaSyCN4ABuPypTTZH53c7FikVV-DTWsm4D42g';
 
        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/videos/?id=' . $video_id . '&key=' . $apiKey . '&part=snippet,contentDetails,statistics,status');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        $response = curl_exec($ch);
        curl_close($ch);
 
        $obj = json_decode($response);
        if (!$obj) {
            echo 'Lỗi Video ID';
            die();
        }
        // print_r($obj);

        foreach ($obj->items as $video) {
            //Thời gian
            return $video->contentDetails->duration;
        }
 
    }else{
        echo 'Không tìm thấy ID';
    }
 
}

?>

