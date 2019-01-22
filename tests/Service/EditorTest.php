<?php

namespace App\Tests\Service;


use App\Service\Editor;
use App\Models\Square;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EditorTest extends WebTestCase
{
    /** @var Editor */
    private $editor;


    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->editor = self::$container->get('service.editor');
    }

    public function testAddShapeREturnsTrue()
    {
        $params = $this->getShapes();
        $this->assertTrue($this->editor->addShape($params[0]));
    }

    /**
     * @expectedException App\Exceptions\InvalidShapeTypeException
     * @expectedExceptionMessage There is no shape to add
     */
    public function testAddNullShapeReturnsInvalidShapeTypeException()
    {
        $this->assertTrue($this->editor->addShape(null));
    }

    /**
     * @expectedException App\Exceptions\InvalidShapeTypeException
     * @expectedExceptionMessage Invalid Shape Type
     */
    public function testAddInvalidShapeReturnsInvalidShapeTypeException()
    {
        $params = $this->getShapes();
        $params[0]['type'] = null;
        $this->assertTrue($this->editor->addShape($params[0]));
    }

    public function testAddShapesReturnsTrue()
    {
        $params = $this->getShapes();

        $this->assertTrue($this->editor->addShapes($params));
    }
    /**
     * @expectedException App\Exceptions\BadRequestHttpException
     * @expectedExceptionMessage There is no shape to add
     */
    public function testAddShapesReturnsBadRequestHttpException()
    {
        $this->assertTrue($this->editor->addShapes(null));
    }

    public function testGetShapeList()
    {
        $this->assertInstanceOf('App\Service\ShapeList', $this->editor->getShapeList());
    }

    public function testDrawShapes()
    {
        $params = $this->getShapes();
        $this->editor->addShapes($params);
        $this->assertContains('circle', $this->editor->drawShapes());
    }

    public function testRemoveShape()
    {
        $params = $this->getShapes();
        $this->editor->addShapes($params);
        $shapes = $this->editor->getShapeList()->getShapes();
        $id = current($shapes)->id;
        $this->assertTrue($this->editor->removeShape($id));
    }

    public function testGetShape()
    {
        $params = $this->getShapes();
        $this->editor->addShapes($params);
        $shapes = $this->editor->getShapeList()->getShapes();
        $id = current($shapes)->id;
        $this->assertInstanceOf('App\Models\Circle', $this->editor->getShape($id));
    }

    public function getShapes():array
    {
        return [
            [
                'type' => 'circle',
                'params' => [
                    'radius' => 5,
                    'xPosition' => 100,
                    'yPosition' => 200,
                ]
            ],
            [
                'type' => 'circle',
                'params' => [
                    'radius' => 5,
                    'xPosition' => 100,
                    'yPosition' => 200,
                ]
            ]
        ];
    }
}
