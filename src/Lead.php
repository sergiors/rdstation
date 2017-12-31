<?php

declare(strict_types=1);

namespace Sergiors\RDStation;

use InvalidArgumentException;
use Respect\Validation\Validator as v;
use GuzzleHttp\Psr7\Request;
use function GuzzleHttp\json_encode;
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
            throw new InvalidArgumentException('Email is not valid');
        }

        $this->rdstation = $rdstation;
        $this->params['identificador'] = $id;
        $this->params['email'] = $email;
    }

    public function addParam(string $key, string $value): self
    {
        $validKeys = anyPass([
            equals('name'),
            equals('company'),
            equals('job_title'),
            equals('personal_phone'),
            equals('mobile_phone'),
        ]);

        if (!$validKeys($key)) {
            throw new InvalidArgumentException('Parameter is not valid');
        }

        $this->params[$key] = $value;

        return $this;
    }

    public function addTag(string $tag): self
    {
        $this->params['tags'][] = $tag;

        return $this;
    }

    public function trigger()
    {
        $headers = ['Content-Type' => 'application/json'];

        $this->rdstation->sendRequest(new Request(
            'POST',
            'conversions',
            $headers,
            json_encode($this->params)
        ));
    }
}
