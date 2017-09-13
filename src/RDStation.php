<?php

declare(strict_types = 1);

namespace Sergiors\RDStation;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RDStation
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    public function __construct(
        string $token,
        ServerRequestInterface $request,
        LoggerInterface $logger,
        ClientInterface $httpClient = null
    ) {
        $this->token = $token;
        $this->request = $request;
        $this->httpClient = $httpClient ?: new HttpClient();
        $this->logger = $logger;
    }

    public function sendRequest(array $data, string $endpoint): bool
    {
        $uri = 'https://www.rdstation.com.br/api/1.3'.$endpoint;

        try {
            $this->httpClient->request('POST', $uri, [
                'json' => array_merge([
                    'token_rdstation' => $this->token,
                    'c_utmz' => $this->request->getCookieParams()['__utmz'] ?? '',
                    'traffic_source' => $this->request->getServerParams()['HTTP_HOST'] ?? '',
                ], $data)
            ]);

            $this->logger->debug('Everything was sent', $data);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Something are wrong', $e->getCode(), $e);
        }

        return true;
    }
}
