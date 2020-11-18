<?php
namespace AestronSdk\Sms;

use AestronSdk\Exception\ClientException;
use AestronSdk\Exception\ErrorCode;
use GuzzleHttp\Client as httpClient;

/**
 * Class SmsClient
 */
class SmsClient
{
    /**
     * sms client host
     * @var string
     */
    protected static $host = 'https://sms.bigo.sg/';

    /**
     * http timeOut
     * @var int
     */
    protected static $timeOut = 3;

    /**
     * appId
     * @var string
     */
    protected static $appId;

    /**
     * certificate
     * @var string
     */
    protected static $certificate;

    /**
     * api version
     * @var int
     */
    protected static $version = 2;

    /**
     * set appId for generate token
     * @param string $appId
     */
    public static function setAppId($appId = '')
    {
        self::$appId = $appId;
    }

    /**
     * setCertificate for generate token
     * @param string $certificate
     */
    public static function setCertificate($certificate = '')
    {
        self::$certificate = $certificate;
    }

    /**
     * @param $timeOut
     */
    public static function setHttpTimeOut($timeOut)
    {
        self::$timeOut = $timeOut;
    }

    /**
     * @param $timeOut
     */
    public static function setHttpHost($host)
    {
        self::$host = $host;
    }

    /**
     * send sms
     * @param $options
     * @throws ClientException
     */
    public static function send($options)
    {
        if (empty($options['to']) || empty($options['content'])) {
            throw new ClientException(
                'to or content cannot be empty',
                ErrorCode::INVALID_ARGUMENT
            );
        }
        if (empty(self::$appId) || empty(self::$certificate)) {
            throw new ClientException(
                'appId or certificate cannot be empty',
                ErrorCode::INVALID_ACCESS_KEY
            );
        }
        //  argument init
        //  if expireTime is invalid,  the default value is 30.
        if (!isset($options['expireTime']) && !is_int($options['expireTime'])) {
            $options['expireTime'] = 30;
        }

        //  encrypt token="version:appId:expiredTime:signature"
        $method     = "SmsService.sendSms";
        $fields     = "{$method}&{$options['to']}&{$options['content']}";
        $expireTime = time() + $options['expireTime'];
        $signature  = Signature::sha1($fields . self::$appId . self::$certificate . $expireTime);
        $token      = self::$version . ":" . self::$appId . ":" . $expireTime . ":" . $signature;

        //  http post json
        $json = [
            'to'      => $options['to'],
            'content' => $options['content'],
            'from'    => !empty($options['from']) ? $options['from'] : '',
            'type'    => !empty($options['type']) ? $options['type'] : '',
            'session' => !empty($options['session']) ? $options['session'] : '',
        ];

        //  http post request with token
        $httpClient = new HttpClient([
            'base_uri' => self::$host,
            'timeout'  => 2.0,
        ]);
        $res = $httpClient->post($method, [
            'json' => $json,
            'header' => [
                'token' => $token,
            ],
        ]);
        $statusCode = $res->getStatusCode();
        if ($statusCode == 401) {
            throw new ClientException(
                'InvalidToken',
                ErrorCode::INVALID_TOKEN
            );
        } elseif($statusCode != 200) {
            throw new ClientException(
                "Unknown error,http code={$statusCode},response={$res->getBody()}",
                ErrorCode::SERVICE_UNKNOWN_ERROR
            );
        }
        //  response as array
        return json_decode($res->getBody(), true);
    }
}