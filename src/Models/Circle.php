<?php

namespace App\Models;

use Symfony\Component\Validator\Constraints\NotBlank;

class Circle extends AbstractShape
{
    /**
     * @var $radius
     * @NotBlank()
     */
    public $radius;

    /**
     * @return string
     */
    public function draw():string
    {
        return $this->id . ' circle ' . '<br/>';
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParamsFromArray(array $parameters)
    {
        parent::setParamsFromArray($parameters);
        $this->radius = $parameters['radius'] ?? null;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return array_merge(parent::getParams(), ['radius']);
    }
}
