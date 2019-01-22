<?php

namespace App\Tests\TestCase;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use TestTools\TestCase\FixturePathTrait;

abstract class PantaUnitTestCase extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        // returns the real and unchanged service container
        $container = self::$kernel->getContainer();
    }
}