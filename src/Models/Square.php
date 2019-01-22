<?php

namespace App\Models;

use Symfony\Component\Validator\Constraints\NotBlank;

class Square extends AbstractShape
{
    /**
     * @var $length
     * @NotBlank()
     */
    public $length;

    /**
     * @return string
     */
    public function draw():string
    {
        return $this->id . ' square ' . '<br/>';
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParamsFromArray(array $parameters)
    {
        parent::setParamsFromArray($parameters);
        $this->length = $parameters['length'] ?? null;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return array_merge(parent::getParams(), ['length']);
    }
}
