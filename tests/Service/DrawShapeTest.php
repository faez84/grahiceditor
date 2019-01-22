<?php

namespace App\Tests\Service;

use App\Models\AbstractShape;
use App\Service\DrawShape;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DrawShapeTest extends WebTestCase
{
    /** @var DrawShape */
    private $drawShape;
    /** @var  AbstractShape */
    private $circle;
    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->drawShape = self::$container->get('service.drawshape');

        $this->circle = $this->getMockBuilder(AbstractShape::class)
            ->disableOriginalConstructor()
            ->setMethods(['draw'])
            ->getMock();
    }

    public function testDrawShape()
    {
        $this->circle
            ->expects($this->once())
            ->method('draw')
            ->will($this->returnValue('circle'));

        $this->assertContains('circle', $this->drawShape->drawShape($this->circle));
    }
}
