<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Http;

class Response
{
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_NOT_FOUND = 404;
    const INTERNAL_SERVER_ERROR = 500;

    const STATUS_TEXTS = [
        self::STATUS_OK => 'Ok',
        self::STATUS_CREATED => 'Created',
        self::STATUS_BAD_REQUEST => 'Bad Request',
        self::STATUS_NOT_FOUND => 'Not Found',
        self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
    ];

    private int $statusCode;
    private string $statusText;
    private string $responseBody;

    public function __construct(string $responseBody = '', int $responseHttpCode = self::STATUS_OK)
    {
        $this->statusCode = $responseHttpCode;
        $this->statusText = self::STATUS_TEXTS[$this->statusCode];

        $this->responseBody = $responseBody;
    }

    /**
     * @return int
     */
    public function getStatusCode():int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusText():string
    {
        return $this->statusText;
    }

    /**
     * @return string
     */
    public function getResponseBody():string
    {
        return $this->responseBody;
    }
}
