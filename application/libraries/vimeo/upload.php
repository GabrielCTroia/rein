<?php

// Turn on error reporting
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

include 'vimeo.php';

$vimeo = new phpVimeo('862103b8d1e32733d80d1a7fbfcded18413dca64', '78a6aa39c0b46970d11946528062bc3acf303ca9', 'c6b32389a8329e25b495076004978c6f', 'b2a0439afa17c7a05dabd1475ee7700d8f86a7e1');

try {
    $video_id = $vimeo->upload('PATH_TO_VIDEO_FILE');

    if ($video_id) {
        echo '<a href="http://vimeo.com/' . $video_id . '">Upload successful!</a>';

        //$vimeo->call('vimeo.videos.setPrivacy', array('privacy' => 'nobody', 'video_id' => $video_id));
        $vimeo->call('vimeo.videos.setTitle', array('title' => 'YOUR TITLE', 'video_id' => $video_id));
        $vimeo->call('vimeo.videos.setDescription', array('description' => 'YOUR_DESCRIPTION', 'video_id' => $video_id));
    }
    else {
        echo "Video file did not exist!";
    }
}
catch (VimeoAPIException $e) {
    echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
}