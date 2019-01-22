<?php

namespace App\Tests\Service;

use App\Models\Circle;
use App\Models\ShapeFactory;
use App\Models\Square;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SquareTest extends WebTestCase
{
    /** @var Square */
    private $square;

    /** @var  ShapeFactory */
    private $shapeFactory;

    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->shapeFactory = self::$container->get('shape.factory');
        $this->square = $this->shapeFactory->create('square');
    }

    public function testDraw()
    {
        $this->assertContains('square', $this->square->draw());
    }

    public function testGetParams()
    {
        $params = $this->square->getParams();
        $this->assertContains('xPosition', $params[0]);
        $this->assertContains('yPosition', $params[1]);
        $this->assertContains('border', $params[2]);
        $this->assertContains('color', $params[3]);
        $this->assertContains('size', $params[4]);
        $this->assertContains('length', $params[5]);
    }
}
