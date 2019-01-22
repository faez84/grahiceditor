<?php

namespace App\Tests\Service;


use App\Models\Circle;
use App\Models\ShapeFactory;
use App\Service\Editor;
use App\Models\Square;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
       $this->assertContains('radius', $this->circle->getParams()[2]);
    }
}