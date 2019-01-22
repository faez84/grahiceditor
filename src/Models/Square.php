<?php

namespace App\Models;




class Square extends AbstractShape
{
    /**
     * @var $side
     * @Assert\NotBlank()
     */
    public $side;

    /**
     * @return string
     */
    public function draw()
    {
        return 'square';
    }

    public function setParamsFromArray(array $parameters)
    {
        parent::setParamsFromArray($parameters);
        $this->side = $parameters['side'] ?? null;

        return $this;
    }
}