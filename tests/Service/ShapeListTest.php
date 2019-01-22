<?php

namespace App\Tests\Service;

use App\Exceptions\NotFoundShapeException;
use App\Models\Factory;
use App\Service\ShapeList;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShapeListTest extends WebTestCase
{
    /** @var ShapeList */
    private $shapeList;

    /** @var  Factory */
    private $factory;

    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->shapeList = self::$container->get('service.shaplist');
        /** @var Factory $factory */
        $this->factory  = self::$container->get('shape.factory');
    }

    public function testAddShape()
    {
        $circle = $this->factory->create('circle');
        $this->assertTrue($this->shapeList->addShape($circle));
    }
    /**
     * @expectedException App\Exceptions\NotFoundShapeException
     * @expectedExceptionMessage This shape -5 does not exist
     */
    public function testGetShapeReturnsNotFoundShapeException()
    {
        $this->assertNull($this->shapeList->getShape(-5));
    }

    public function testGetShapeReturnsShape()
    {
        $circle = $this->factory->create('circle');
        $this->shapeList->addShape($circle);
        $shapes = $this->shapeList->getShapes();

        $this->assertNotNull($this->shapeList->getShape(current($shapes)->id));
    }
}
