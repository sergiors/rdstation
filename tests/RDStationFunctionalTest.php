<?php

declare(strict_types = 1);

namespace Sergiors\RDStation;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequestFactory;
use Faker\Factory;

final class RDStationFunctionalTest extends TestCase
{
    public function testSendLead()
    {
        $faker = Factory::create();
        $request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            ['__utmz' => '34710580.1505400480.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided)'],
            $_FILES
        );

        $apiKey = new ApiKey(getenv('RDSTATION_TOKEN'), getenv('RDSTATION_PRIVATE_TOKEN'));
        $rdstation = new RDStation($apiKey, $request);
        $lead = new Lead($rdstation, 'RDStation Integration', $faker->email);
        $lead
            ->addParam('name', $faker->name)
            ->addTag('rd_integration')
            ->addTag('test');

        $this->assertTrue($lead->trigger());
    }
}
