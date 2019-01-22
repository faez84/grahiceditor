<?php

namespace App\Service;

use App\Exceptions\NotFoundShapeException;
use App\Interfaces\Shape;
use App\Models\AbstractShape;

class ShapeList
{
    private $_shapeList = [];

    /**
     * @param AbstractShape $shape
     * @return int
     */
    public function addShape(AbstractShape $shape):bool
    {
        $this->_shapeList[$shape->id] = $shape;

        return true;
    }

    /**
     * @param int $shapeNumber
     * @return AbstractShape
     */
    public function getShape(string $id): AbstractShape
    {
        if (is_null($this->_shapeList) || !isset($this->_shapeList[$id])) {
            throw new NotFoundShapeException(sprintf('This shape %s does not exist', $id));
        }

        return $this->_shapeList[$id];
    }

    /**
     * @param string $id
     * @return bool
     * @throws NotFoundShapeException
     */
    public function removeShape(string $id): bool
    {
        if (is_null($this->_shapeList) || !isset($this->_shapeList[$id])) {
            throw new NotFoundShapeException(sprintf('This shape %s does not exist', $id));
        }
        unset($this->_shapeList[$id]);

        return true;
    }

    /**
     * @return array
     */
    public function getShapes():array
    {
        return $this->_shapeList;
    }
}
