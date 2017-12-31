<?php

declare(strict_types=1);

namespace Sergiors\RDStation;

final class Credentials
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $privateToken;

    public function __construct(string $token, string $privateToken)
    {
        $this->token = $token;
        $this->privateToken = $privateToken;
    }
}
