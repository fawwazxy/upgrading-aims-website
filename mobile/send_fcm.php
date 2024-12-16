<?php
function sendFCM($token,$title,$body){

    $url = 'https://fcm.googleapis.com/fcm/send';

    $apiKey = 'AAAAw99tSIg:APA91bHUrbGeJJtT8RWCIvgK8mCIeg8IMCHcRwDhSqgOWkJnKpQI_qv0wfnGo20K6M8A5FWzkh0QhGZXpFa96vYnNskhn_XNaegkVYII72-7sqda-hpHfuMyEUU8fQfaRouuDqK_XYWS';

    $headers = array(
        'Authorization:key='.$apiKey,
        'Content-Type:application/json'
    );

    $notifbody = [
        'title' => $title,
        'body' => $body,
        'content_available' => true,
    ];

    $body = [
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        'priority' => 'high',
        'to' => $token,
        'notification' => $notifbody,

    ];

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($body));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}