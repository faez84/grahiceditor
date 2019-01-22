<?php

namespace App\Controller;

use App\Exceptions\BadRequestHttpException;
use App\Exceptions\FactoryException;
use App\Models\Factory;
use App\Service\Editor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditorController extends AbstractController
{
    /** @var Editor $_editor */
    private $_editor;

    public function __construct(Editor $editor)
    {
        $this->_editor = $editor;
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('editor.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addShapesAction(Request $request)
    {
        $shapes = $request->request->all();
        try {
            $this->_editor->addShapes($shapes['shapes']);
            $codeStatus = Response::HTTP_CREATED;
            $drawResult = 'New shape(s) has(have) been added ';
        } catch (\Exception $exception) {
            $drawResult = $exception->getMessage();
            $codeStatus = Response::HTTP_BAD_REQUEST;
        }
        $response = new Response(json_encode($drawResult), $codeStatus);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function drawAction(Request $request)
    {
        $shapes = $request->query->all();
        try {
            $this->_editor->addShapes($shapes['shapes']);
            $drawResult = $this->_editor->drawShapes();
            $codeStatus = Response::HTTP_OK;
        } catch (BadRequestHttpException $badRequestHttpException) {
            $drawResult = $badRequestHttpException->getMessage();
            $codeStatus = Response::HTTP_BAD_REQUEST;
        }
        $response = new Response(json_encode($drawResult), $codeStatus);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param string $id
     * @return Response
     */
    public function getAction(string $id)
    {
        $shape = $this->_editor->getShape($id);
        $response = new Response(json_encode($shape), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @return Response
     */
    public function getAllAction()
    {
        $shapes = $this->_editor->getShapeList();
        $response = new Response(json_encode($shapes), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param string $id
     * @return Response
     */
    public function deleteAction(string $id)
    {
        try {
            $this->_editor->removeShape($id);
            $codeStatus = Response::HTTP_NO_CONTENT;
            $deleteResult = 'Done';
        } catch (\Exception $badRequestHttpException) {
            $codeStatus = Response::HTTP_BAD_REQUEST;
            $deleteResult = 'Error';
        }
        $response = new Response(json_encode($deleteResult), $codeStatus);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
