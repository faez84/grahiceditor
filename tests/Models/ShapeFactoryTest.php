<?php

namespace App\Tests\Service;


use App\Models\ShapeFactory;
use App\Service\Editor;
use App\Models\Square;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ShapeFactoryTest extends WebTestCase
{
    /** @var ShapeFactory */
    private $shapeFactory;

    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->shapeFactory = self::$container->get('shape.factory');
    }

    public function testCreateShape()
    {
        $this->shapeFactory->setFactoryNamespace('App\Tests\Models');
        $this->assertInstanceOf('App\Tests\Models\SimpleShape', $this->shapeFactory->create('SimpleShape'));
    }

    public function testGetFactoryNamespace()
    {
        $this->assertEquals('App\Models', $this->shapeFactory->getFactoryNamespace());
        $this->shapeFactory->setFactoryNamespace('App\Tests\Models');
        $this->assertEquals('App\Tests\Models', $this->shapeFactory->getFactoryNamespace());
    }
}