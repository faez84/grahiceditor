<?php


namespace App\Service;

use App\Models\AbstractShape;

class DrawShape
{
    public static function drawShape(AbstractShape $shape):string
    {
        return $shape->draw();
    }
}
