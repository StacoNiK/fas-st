<?php namespace FasSt;

class HttpClient
{
    public $ch;
    protected static $instance;

    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, [
                "Origin: http://fas.st",
                "Referer: http://fas.st/",
                "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/50.0.2661.102 Chrome/50.0.2661.102 Safari/537.36",
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                "Authorization: www",
                "Connection: keep-alive",
                "Accept-Language: en-US,en;q=0.8",
                "Access-Control-Request-Headers: accept, authorization, content-type",
                "Access-Control-Request-Method: POST"
            ]);
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            curl_setopt($this->ch, CURLOPT_SAFE_UPLOAD, false);
        }
        curl_setopt($this->ch, CURLOPT_POST, false);
    }

    /**
     * Выполнение запроса
     */
    public function request($url, $data = false, $custom_requst = false)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        if ($custom_requst) {
            curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $custom_requst);
        } else {
            curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "GET");
        }
        if ($data) {
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($this->ch, CURLOPT_POST, false);
        }
        return curl_exec($this->ch);
    }

    public function get($url)
    {
        return $this->request($url);
    }

    public function post($url, $data)
    {
        return $this->request($url, $data);
    }

    public function getResultUrl()
    {
        $info = curl_getinfo($this->ch);
        return $info['url'];
    }

    /**
     * Возвращает объект класса
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}