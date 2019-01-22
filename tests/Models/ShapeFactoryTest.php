<?php

namespace App\Tests\Service;

use App\Models\ShapeFactory;
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
        $this->shapeFactory->setFactoryNamespace('App\Models');
        $this->assertInstanceOf('App\Models\Circle', $this->shapeFactory->create('circle'));
    }

    public function testGetFactoryNamespace()
    {
        $this->assertEquals('App\Models', $this->shapeFactory->getFactoryNamespace());
        $this->shapeFactory->setFactoryNamespace('App\Tests\Models');
        $this->assertEquals('App\Tests\Models', $this->shapeFactory->getFactoryNamespace());
    }
}
