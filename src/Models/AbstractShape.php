<?php

namespace App\Models;

use App\Interfaces\ShapeInterface;
use Symfony\Component\Validator;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractShape implements ShapeInterface
{
    public $id;
    protected $xPosition;
    protected $yPosition;

    protected $color;
    protected $border;

    public function __construct()
    {
        $this->id = uniqid();
    }

    /**
     * @param int $xPosition
     * @param int $yPosition
     */
    public function setPosition(int $xPosition, int $yPosition)
    {
        $this->xPosition = $xPosition;
        $this->yPosition = $yPosition;
    }

    /**
     * @param array $parameters
     */
    public function setParamsFromArray(array $parameters)
    {
        $this->xPosition = $parameters['xPosition'] ?? null;
        $this->yPosition = $parameters['yPosition'] ?? null;
        $this->border = $parameters['border'] ?? null;
        $this->color = $parameters['color'] ?? null;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [
            'xPosition','yPosition'
        ];
    }

    abstract public function draw();
}