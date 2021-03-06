<?php

namespace App\Tests\Service;

use App\Models\Circle;
use App\Models\ShapeFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CircleTest extends WebTestCase
{
    /** @var Circle */
    private $circle;

    /** @var  ShapeFactory */
    private $shapeFactory;

    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->shapeFactory = self::$container->get('shape.factory');
        $this->circle = $this->shapeFactory->create('circle');
    }

    public function testDraw()
    {
        $this->assertContains('circle', $this->circle->draw());
    }

    public function testGetParams()
    {
        $params = $this->circle->getParams();
        $this->assertContains('xPosition', $params[0]);
        $this->assertContains('yPosition', $params[1]);
        $this->assertContains('border', $params[2]);
        $this->assertContains('color', $params[3]);
        $this->assertContains('size', $params[4]);
        $this->assertContains('radius', $params[5]);
    }
}
