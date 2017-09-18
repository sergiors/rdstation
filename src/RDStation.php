<?php

declare(strict_types = 1);

namespace Sergiors\RDStation;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Client as HttpClient;
use function GuzzleHttp\{json_encode, json_decode};
use function GuzzleHttp\Psr7\{copy_to_string, stream_for};
use function Prelude\pipe;

final class RDStation
{
    /**
     * @var Sergiors\RDStation\Credentials
     */
    private $credentials;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    public function __construct(Credentials $credentials, ServerRequestInterface $request)
    {
        $this->credentials = $credentials;
        $this->request     = $request;
        $this->httpClient  = new HttpClient([
            'base_uri' => 'https://www.rdstation.com.br/api/1.3/'
        ]);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            $body = pipe(
                function (StreamInterface $stream) {
                    return copy_to_string($stream);
                },
                function (string $str) {
                    return json_decode($str, true);
                },
                function (array $params) {
                    return array_merge($params, [
                        'token_rdstation' => $this->credentials->token,
                        'c_utmz' => $this->request->getCookieParams()['__utmz'] ?? '',
                    ]);
                },
                function (array $params) {
                    return stream_for(json_encode($params));
                }
            )($request->getBody());

            return $this->httpClient->send(
                $request->withBody($body)
            );
        } catch (\Throwable $e) {
            throw new \RuntimeException('Something is wrong', $e->getCode(), $e);
        }
    }
}
