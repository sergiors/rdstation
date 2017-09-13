<?php

declare(strict_types = 1);

namespace Sergiors\RDStation;

use Respect\Validation\Validator as v;
use function Prelude\{equals, anyPass};

final class Lead implements SignalInterface
{
    /**
     * @var RDStation
     */
    private $rdstation;

    /**
     * @var array
     */
    private $params;

    public function __construct(RDStation $rdstation, string $id, string $email)
    {
        if (!v::email()->validate($email)) {
            throw new \InvalidArgumentException('Email does not valid');
        }

        $this->rdstation = $rdstation;
        $this->params['id'] = $id;
        $this->params['email'] = $email;
    }

    public function addParam(string $key, string $value)
    {
        $anyPass = anyPass([
            equals('name'),
            equals('company'),
            equals('job_title'),
            equals('personal_phone'),
            equals('mobile_phone'),
        ]);

        if (!$anyPass($key)) {
            throw new \InvalidArgumentException();
        }

        $this->params[$key] = $value;
    }

    public function trigger(): bool
    {
        return $this->rdstation->sendRequest($this->params, '/conversions');
    }
}
