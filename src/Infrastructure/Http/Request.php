<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Http;

class Request
{
    const HTTP_VERB_GET = 'GET';
    const HTTP_VERB_POST = 'POST';
    const HTTP_VERB_PUT = 'PUT';
    const HTTP_VERB_PATCH = 'PATCH';
    const HTTP_VERB_DELETE = 'DELETE';

    private string $uri;
    private string $httpMethod;
    private ?string $body;

    public static function createRequest(): Request
    {
        $request = new self;
        $request->uri = $_SERVER['REQUEST_URI'];
        $request->httpMethod = $_SERVER['REQUEST_METHOD'];

        if (in_array($request->httpMethod, [self::HTTP_VERB_POST, self::HTTP_VERB_PATCH, self::HTTP_VERB_PUT])) {
            $request->body = file_get_contents('php://input');
        }

        return $request;
    }

    /**
     * @return string
     */
    public function getUri():string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getHttpMethod():string
    {
        return $this->httpMethod;
    }

    /**
     * @return string|null
     */
    public function getBody():?string
    {
        return $this->body;
    }
}
