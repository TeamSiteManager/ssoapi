<?php
/**
 * Created by PhpStorm.
 * User: SiteManager
 * Date: 10/10/2019
 * Time: 15:00
 * SSO API PHP EXAMPLE
 */


//these credentials can be found inside SiteManager > Project Dashboard > Add-Ons > SSO API
$clientId = 'xxxxxxxxxxxxxx';
$clientSecret = 'xxxxxxxxxxxxxx';

$ch = curl_init();
$endpoint = "https://api.sitemn.gr/token/";
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'scope' => 'sso',
    'grant_type' => 'client_credentials',
]);

$response = curl_exec($ch);
$data = json_decode($response, true);
$accessToken = $data['access_token'];


$ch = curl_init();
$endpoint = 'https://api.sitemn.gr/logintoken/?access_token=' . $accessToken;

curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'user_email' => "johndoe@email.com", //email of user added to sitemanager project
    'project_name' => 'sitemanager_project', //unique name of sitemanager project
    'logoutURL' => 'https://app.myproject.com/start/', //link to return to your platform
]);

$response = curl_exec($ch);
$data = json_decode($response, true);

if ($data["status"]["type"] == "success")
{

    $logintoken = $data['logintoken'];
    $login_url = $data['loginURL']; //use this url to login to the project

    echo "<a href='" . $login_url . "' target='_blank'>sso login</a>";

} else {

    echo $data["status"]["message"];

}

?>