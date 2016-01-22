<?php

include_once 'config.php';
require_once __DIR__ . '/classes/authentication.php';
//If user is not logged in then return to index page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
use LoginRadiusSDK\LoginRadius;
use LoginRadiusSDK\SocialLogin\SocialLoginAPI;
use LoginRadiusSDK\LoginRadiusException;

$post_value = $_POST;
$post_func = isset($post_value['func']) && !empty($post_value['func']) ? trim($post_value['func']) : '';
$accessToken = isset($_SESSION['access_token']) && !empty($_SESSION['access_token']) ? trim($_SESSION['access_token']) : '';
$userRegBasic = new SocialLoginAPI (LR_API_KEY, LR_API_SECRET, array('authentication'=>false, 'output_format' => 'json'));
try {
    if ($post_func == 'extendedProfile') {
        $output = $userRegBasic->getUserProfiledata($accessToken);
    } else if ($post_func == 'contact') {
        $output = $userRegBasic->getContacts($accessToken);
    } else if ($post_func == 'likes') {
        $output = $userRegBasic->getLikes($accessToken);
    } else if ($post_func == 'albums') {
        $output = $userRegBasic->getPhotoAlbums($accessToken);
    } else if ($post_func == 'checkins') {
        $output = $userRegBasic->getCheckins($accessToken);
    } else if ($post_func == 'audio') {
        $output = $userRegBasic->getAudio($accessToken);
    } else if ($post_func == 'mentions') {
        $output = $userRegBasic->getMentions($accessToken);
    } else if ($post_func == 'following') {
        $output = $userRegBasic->getFollowing($accessToken);
    } else if ($post_func == 'events') {
        $output = $userRegBasic->getEvents($accessToken);
    } else if ($post_func == 'posts') {
        $output = $userRegBasic->getPosts($accessToken);
    } else if ($post_func == 'companies') {
        $output = $userRegBasic->getFollowedCompanies($accessToken);
    } else if ($post_func == 'groups') {
        $output = $userRegBasic->getGroups($accessToken);
    } else if ($post_func == 'status') {
        $output = $userRegBasic->getStatus($accessToken);
    } else if ($post_func == 'photos') {
        $albumId = isset($post_value['id']) && !empty($post_value['id']) ? trim($post_value['id']) : '';
        $output = $userRegBasic->getPhotos($accessToken, $albumId);
    } else if ($post_func == 'videos') {
        $output = $userRegBasic->getVideos($accessToken);
    } else if ($post_func == 'poststatus') {
        
            $title = isset($post_value['title']) && !empty($post_value['title']) ? trim($post_value['title']) : '';
            $url = isset($post_value['url']) && !empty($post_value['url']) ? trim($post_value['url']) : '';
            $imageurl = isset($post_value['imageurl']) && !empty($post_value['imageurl']) ? trim($post_value['imageurl']) : '';
            $status = isset($post_value['status']) && !empty($post_value['status']) ? trim($post_value['status']) : '';
            $description = isset($post_value['description']) && !empty($post_value['description']) ? trim($post_value['description']) : '';
            $output = $userRegBasic->postStatus($accessToken, $title, $url, $imageurl, $status, $title, $description);
           // $_SESSION[$post_func] = $output;
        
    } else if ($post_func == 'sendmessage') {
        $to = isset($post_value['to']) && !empty($post_value['to']) ? trim($post_value['to']) : '';
        $subject = isset($post_value['subject']) && !empty($post_value['subject']) ? trim($post_value['subject']) : '';
        $message = isset($post_value['message']) && !empty($post_value['message']) ? trim($post_value['message']) : '';
        $output = $userRegBasic->sendMessage($accessToken, $to, $subject, $message);
        $_SESSION[$post_func] = $output;
    }
} catch (LoginRadiusException $e) {
    $output['errorCode'] = $e->getErrorResponse()->description;
}
echo json_encode($output);
