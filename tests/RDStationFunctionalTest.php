<?php

declare(strict_types = 1);

namespace Sergiors\RDStation;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequestFactory;
use Faker\Factory;

final class RDStationFunctionalTest extends TestCase
{
    public function setUp()
    {
        $this->faker = Factory::create();
        $this->request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            ['__utmz' => '34710580.1505400480.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided)'],
            $_FILES
        );
        $this->credentials = new Credentials(getenv('RDSTATION_TOKEN'), getenv('RDSTATION_PRIVATE_TOKEN'));
    }

    public function testSendLead()
    {
        $rdstation = new RDStation($this->credentials, $this->request);
        $lead = new Lead($rdstation, 'RDStation Integration', $this->faker->email);
        $lead
            ->addParam('name', $this->faker->name)
            ->addTag('rd_integration')
            ->addTag('test');

        $lead->trigger();
    }

    public function testThrowInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $rdstation = new RDStation($this->credentials, $this->request);
        $lead = new Lead($rdstation, 'RDStation Integration', $this->faker->email);
        $lead->addParam('nonexists', '');
    }
}
