<?php

namespace App\Tests\Models;

use App\Models\AbstractShape;
use Symfony\Component\Validator\Constraints\NotBlank;

class SimpleShape extends AbstractShape
{
    public $param;
    /**
     * @return string
     */
    public function draw():string
    {
        return $this->id . ' simple shape';
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParamsFromArray(array $parameters)
    {
        parent::setParamsFromArray($parameters);
        $this->radius = $parameters['param'] ?? null;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return array_merge(parent::getParams(), ['param']);
    }
}
