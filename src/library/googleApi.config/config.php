<?php
// Defined Google Client Credentials, Scopes, and URIs
require_once(__DIR__."../../../config/env.php");
if(!session_id()) session_start();

$gOauthURL = "https://accounts.google.com/o/oauth2/auth?scope=" . urlencode(GCLIENT_SCOPE) . 
             "&redirect_uri=" . urlencode(GCLIENT_REDIRECT) . 
             "&client_id=" . urlencode(GCLIENT_ID) . 
             "&access_type=offline" . 
             "&response_type=code";


if(isset($_GET['code'])){
    $_SESSION['code'] = $_GET['code'];
    require_once("GoogleDriveUploadAPI.php");
    $gdriveAPI = new GoogleDriveUploadAPI();

     $gdriveAPI->GetValidAccessToken();
}
