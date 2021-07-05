<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('src/scrapIG.php');

$ig = new scrapIG();

#sample scrapping user profile
    $url = 'https://www.instagram.com/thedailyshow/';
    #$url = 'https://www.instagram.com/maell_lee/';
    #$url = 'https://www.instagram.com/comicvilla/';
    $ig->echoPre( $ig->getProfile($url, true) );

#sample scrapping REGULAR(image/video/multi) type post data
    #$url = 'https://www.instagram.com/p/CQcmLdQt4lA/';
    #$ig->echoPre( $ig->getPost($url, true) );

#sample scrapping IGTV type post data
    #$url = 'https://www.instagram.com/tv/CQw-9nFLxRt/';    
    #$ig->echoPre( $ig->getPost($url, true) );

#sample scrapping REEL type post data
    #$url = 'https://www.instagram.com/reel/CQBmeaBlf4L/';
    #$ig->echoPre( $ig->getPost($url, true) );

#sample scrapping stories type post data (NOT WORKING ON STORIES TYPE)
    #$url = 'https://www.instagram.com/stories/highlights/17857419958771472/';
    #$ig->echoPre( $ig->getPost($url, true) );

?>
