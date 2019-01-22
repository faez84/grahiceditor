<?php

namespace App\Tests\Service;

use App\Controller\EditorController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

class EditorControllerTest extends WebTestCase
{
    /** @var EditorController */
    private $editorController;

    /** @var  Client */
    private $client;

    private $fakeClient;
    private $fakeResponse;

    public function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->editor = self::$container->get('controller.editor');
        $this->client = self::createClient();
        $this->fakeResponse = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode'])
            ->getMock();
        $this->fakeClient = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['request', 'getResponse'])
            ->getMock();
    }

    public function testAddShapesActionReturnCreated()
    {
        $shapes = $this->getShapes();

        $this->client->request(
            'POST',
            '/addshapes',
            ['shapes' => $shapes],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testAddInvalidShapeTypesActionReturnsBadRequest()
    {
        $shapes = $this->getShapes();
        $shapes[0]['type'] = 'invalidshape';
        $this->client->request(
            'POST',
            '/addshapes',
            ['shapes' => $shapes],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testAddNullShapesActionReturnsBadRequest()
    {
        $shapes = $this->getShapes();
        $shapes[0] = null;
        $this->client->request(
            'POST',
            '/addshapes',
            ['shapes' => $shapes],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testAddInvalidShapeParamActionReturnsBadRequest()
    {
        $shapes = $this->getShapes();
        $shapes[0]['params']['radius'] = null;
        $this->client->request(
            'POST',
            '/addshapes',
            ['shapes' => $shapes],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testDrawAction()
    {
        $shapes = $this->getShapes();

        $this->client->request(
            'GET',
            '/draw',
            ['shapes' => $shapes],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testGetAllAction()
    {
        $shapes = $this->getShapes();

        $this->client->request(
            'GET',
            '/get',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteActionReturnsNoContent()
    {
        $this->fakeClient
            ->expects($this->once())
            ->method('request')
            ->with('DELETE', '/delete', ['id' => '5c4705016ec64'], [], ['CONTENT_TYPE' => 'application/json']);

        $this->fakeClient
            ->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->fakeResponse));
        $this->fakeResponse
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(Response::HTTP_NO_CONTENT));
        $this->fakeClient->request(
            'DELETE',
            '/delete',
            ['id' => '5c4705016ec64'],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $this->assertEquals(Response::HTTP_NO_CONTENT, $this->fakeClient->getResponse()->getStatusCode());
    }


    public function testDeleteActionReturnsBadRequest()
    {
        $this->fakeClient
            ->expects($this->once())
            ->method('request')
            ->with('DELETE', '/delete', ['id' => '5c4705016ec64'], [], ['CONTENT_TYPE' => 'application/json']);

        $this->fakeClient
            ->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->fakeResponse));
        $this->fakeResponse
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(Response::HTTP_BAD_REQUEST));
        $this->fakeClient->request(
            'DELETE',
            '/delete',
            ['id' => '5c4705016ec64'],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->fakeClient->getResponse()->getStatusCode());
    }

    public function getShapes():array
    {
        return [
            [
                'type' => 'circle',
                'params' => [
                    'radius' => 5,
                    'xPosition' => 123,
                    'yPosition' => 234,
                ]
            ],
            [
                'type' => 'circle',
                'params' => [
                    'radius' => 12,
                    'xPosition' => 100,
                    'yPosition' => 200,
                ]
            ]
        ];
    }
}
