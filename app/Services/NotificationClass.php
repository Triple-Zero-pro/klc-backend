<?php


namespace App\Services;
use Illuminate\Support\Facades\DB;

/**
 * Class NotificationClass
 * @package App\Classes
 */
class NotificationClass
{

    /**
     * @var string
     */
    private static $server_key = "AAAANGmp70g:APA91bEl1_zyd0ZYoyJvKuS5HYK6dwzh71945X-DmcFKCSr4KbrdvCaaf3ABpEYnfak0Mv6NmS_ymdzIah1nDmxJdZoGYIm37gEYa-L-p6xLTCw7vBlGOwzAwQQy54-t8AX7jKZqFYmx";

    /**
     * @param string $to
     * @param array $data
     * @return false|string
     */
    public static function sendPushNotification($to = '', $data = array())
    {
        $api_key = 'AAAAzahjYcI:APA91bEX3xWuvDeQmrKbmyD-x3bAr7qUZ7l0QqytQM4IlaLi_4PpeFhgn7X1rWknIEwQY8igQtDeUdkTQpQ-qDP4Sh7j4ePaBQZt0NEVO7rYlu-RAZ82Se7nK0_9vSDj0WHYQafboa9K';
        $fields = array('to' => $to, 'notification' => $data);

        $headers = array('Authorization: key=' . $api_key, 'Content-Type: application/json');

        $url = 'https://fcm.googleapis.com/fcm/send';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        curl_close($ch);

        return json_encode($result, true);
    }

    /**
     * @param $send_to_token
     * @param $notification_title
     * @param $notification_data
     * @param $notificationType
     */
    public static function fcmPushNotification($send_to_token, $notification_title, $notification_data, $notificationType)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $request = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
                'headers' => [
                    "Authorization" => "key=" .  self::$server_key,
                    "content-type" => "application/json"
                ],
                'json' =>
                    [
                        'to' => $send_to_token,
                        'notification' => [
                            "title" => $notification_title,
                            "body" => $notification_data,
                            "content_available" => true,
                            "priority" => 'normal',
                            "sound" => 'sound',
                            "badge" => "2",
                            "type" => $notificationType,
                            "parameter" => "",
                            "imageUrl" => "http://h5.4j.com/thumb/Ninja-Run.jpg",
                            //"gameUrl" => "https://h5.4j.com/Ninja-Run/index.php?pubid=noad"
                        ],
                        'data' => [
                            "title" => $notification_title,
                            "content" => $notification_data,
                            "type" => $notificationType
                            //"imageUrl" => "http://h5.4j.com/thumb/Ninja-Run.jpg",
                            //"gameUrl" => "https://h5.4j.com/Ninja-Run/index.php?pubid=noad"
                        ],

                    ]
            ]);
            return true;
        }
        catch (\Exception $exception)
        {
            return response()->json(["error" => $exception->getMessage()], $exception->getCode());
        }

        //$tokens_array = array($send_to_token);
        //self::fcmPushNotificationToIOS($notification_title, $notification_data, $tokens_array, $notificationType);
    }


    /**
     * @param $title
     * @param $description
     * @param array $tokens
     * @param null $type
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function multiplePushNotification($title, $description, $tokens = array(), $type = null)
    {
        try {
            if (!empty($tokens)){
                foreach ($tokens as $token){
                    static::fcmPushNotification($token, $title, $description, $type);
                }
            }
            return response()->json("", 200);
        }
        catch (\Exception $exception)
        {
            return response()->json(["error" => $exception->getMessage()], $exception->getCode());
        }
    }

    /**
     * @param $title
     * @param $description
     * @param array $tokens
     * @param null $type
     * @param null $parameter
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function fcmPushNotificationToIOS($title, $description, $tokens = array(), $type = null, $parameter = null)
    {
        $client = new \GuzzleHttp\Client();
        foreach ($tokens as $token)
        {
            $request = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
                'headers' => [
                    "Authorization" => "key=" . self::$server_key,
                    "content-type" => "application/json"
                ],
                'json' =>
                    [
                        'to' => $token,
                        'notification' => [
                            "title" => $title,
                            "body" => $description,
                            "content_available" => true,
                            "priority" => 'high',
                            "sound" => 'sound',
                            "badge" => "2",
                            "type" => $type,
                            "parameter" => $parameter,
                            "imageUrl" => "http://h5.4j.com/thumb/Ninja-Run.jpg",
                            //"gameUrl" => "https://h5.4j.com/Ninja-Run/index.php?pubid=noad"
                        ],
                    ]
            ]);
        }
    }


    /**
     * @param $notification
     * @param null $parameter
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function pushNotificationsToAllUsers(\App\Models\Notification $notification, $parameter = null)
    {
        $users = DB::table('users')->select(['id', 'phone_token', 'lang'])
            ->where('is_active', 1)
            ->where('phone_token', '!=', null)
            ->get();

        $client = new \GuzzleHttp\Client();
        foreach ($users as $user)
        {
            $request = $client->request('POST','https://fcm.googleapis.com/fcm/send',[
                'headers' => [
                    "Authorization" => "key=" .  self::$server_key,
                    "content-type" => "application/json"
                ],
                'json' =>
                    [
                        'data' => [
                            "title" => $notification->{'title_' . $user->lang},
                            "content" => $notification->{'description_' . $user->lang},
                            "type" => $notification->type,
                            "parameter" => $parameter
                            //"imageUrl" => "http://h5.4j.com/thumb/Ninja-Run.jpg",
                            //"gameUrl" => "https://h5.4j.com/Ninja-Run/index.php?pubid=noad"
                        ],
                        'to' => $user->phone_token
                    ]
            ]);
            $tokens_array = array($user->phone_token);
            self::fcmPushNotificationToIOS($notification->{'title_' . $user->lang}, $notification->{'description_' . $user->lang}, $tokens_array, $notification->type, $parameter);
        }

    }

}
