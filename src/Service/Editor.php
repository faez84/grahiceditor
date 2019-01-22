<?php

namespace App\Service;

use App\Exceptions\BadRequestHttpException;
use App\Exceptions\InvalidShapeTypeException;
use App\Interfaces\Shape;
use App\Models\AbstractShape;
use App\Models\Factory;
use App\Models\ShapeFactory;

class Editor
{
    /** @var ShapeList */
    private $shapeList;

    /** @var ShapeFactory */
    private $shapeFactory;
    /** @var  bool */
    private $_enabledValidation = true;

    public function __construct(ShapeFactory $shapeFactory, ShapeList $shapeList)
    {
        $this->shapeFactory = $shapeFactory;
        $this->shapeList = $shapeList;
    }

    /**
     * @param array|null $param
     * @return bool
     * @throws InvalidShapeTypeException
     */
    public function addShape(?array $param):bool
    {
        if (is_null($param)) {
            throw new InvalidShapeTypeException('There is no shape to add');
        }

        if (!isset($param['type']) || !isset($param['params'])) {
            throw new InvalidShapeTypeException('Invalid Shape Type');
        }

        /** @var AbstractShape $shape */
        $shape = $this->shapeFactory->create($param['type']);

        $shape->setParamsFromArray($param['params']);
        if ($this->_enabledValidation) {
            Validator::basicValidation($shape);
        }
        $this->shapeList->addShape($shape);

        return true;
    }

    /**
     * @param array|null $params
     * @return bool
     * @throws BadRequestHttpException
     */
    public function addShapes(?array $params):bool
    {
        if (is_null($params)) {
            throw new BadRequestHttpException('There is no shape to add');
        }
        foreach ($params as $param) {
            $this->addShape($param);
        }
        return true;
    }

    /**
     * @return ShapeList
     */
    public function getShapeList():ShapeList
    {
        return $this->shapeList;
    }

    public function drawShapes():string
    {
        $drawResult = '';
        /** @var Shape $shape */
        foreach ($this->shapeList->getShapes() as $shape) {
            $drawResult .= DrawShape::drawShape($shape);
        }

        return $drawResult;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function removeShape(string $id):bool
    {
        return $this->shapeList->removeShape($id);
    }

    /**
     * @param string $id
     * @return AbstractShape
     */
    public function getShape(string $id)
    {
        return $this->shapeList->getShape($id);
    }

    /**
     * @param bool $enabledValidation
     */
    public function setEnabledValidation(bool $enabledValidation)
    {
        $this->_enabledValidation = $enabledValidation;
    }
}
