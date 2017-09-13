<?php

declare(strict_types = 1);

namespace Sergiors\RDStation;

use PHPUnit\Framework\TestCase;
use Monolog\Logger;
use Monolog\Handler\NullHandler;
use Zend\Diactoros\ServerRequestFactory;
use Faker\Factory;

final class RDStationFunctionalTest extends TestCase
{
    public function testSendLead()
    {
        $faker = Factory::create();
        $logger = new Logger('');
        $logger->pushHandler(new NullHandler());
        $request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );

        $rdstation = new RDStation(getenv('RDSTATION_TOKEN'), $request, $logger);
        $lead = new Lead($rdstation, 'RDStation Integration', $faker->email);
        $lead->addParam('name', $faker->name);

        $this->assertTrue($lead->trigger());
    }
}
