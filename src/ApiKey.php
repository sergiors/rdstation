<?php

declare(strict_types = 1);

namespace Sergiors\RDStation;

final class ApiKey
{
    /**
     * @var string
     */
    private $publicToken;

    /**
     * @var string
     */
    private $privateToken;

    public function __construct(string $publicToken, string $privateToken)
    {
        $this->publicToken  = $publicToken;
        $this->privateToken = $privateToken;
    }

    public function getPublicToken(): string
    {
        return $this->publicToken;
    }

    public function getPrivateToken(): string
    {
        return $this->privateToken;
    }
}
