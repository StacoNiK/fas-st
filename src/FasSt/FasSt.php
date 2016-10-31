<?php namespace FasSt;

class FasSt
{
    protected static $service_url = 'http://api.fas.st/v1/pack';

    public static function reduce($url)
    {
        $client = new HttpClient();
        $client->request(self::$service_url, false, 'OPTIONS');
        $result = $client->post(self::$service_url, "access_token=anonymous&username=website_visitor&url=".urlencode($url));
        $data = json_decode($result, true);
        if (is_array($data)) {
            if (array_key_exists('url', $data)) {
                return $data['url'];
            }
        }
        return false;
    }
}