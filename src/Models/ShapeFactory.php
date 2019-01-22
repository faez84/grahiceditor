<?php
/**
 * Created by PhpStorm.
 * User: Benutzer
 * Date: 1/18/2019
 * Time: 12:25 AM
 */

namespace App\Models;


use App\Exceptions\FactoryException;
use App\Interfaces\Shape;

class ShapeFactory
{
    /**
     * Namespace used by instance factory method
     *
     * @var string
     */
    protected $_factoryNamespace = '';

    public function __construct()
    {
        $this->_factoryNamespace = 'App\Models';
    }

    /**
     * Sets namespace used by the DAO factory method
     *
     * @param string $namespace
     */
    public function setFactoryNamespace(string $namespace)
    {
        $this->_factoryNamespace = $namespace;
    }

    /**
     * Returns absolute namespace used by the factory method
     *
     * @return string
     */
    public function getFactoryNamespace()
    {
        $result = $this->_factoryNamespace;


        return $result;
    }
    /**
     * @param $name
     * @return mixed
     * @throws FactoryException
     */
    public function create(string $name)
    {
        $className = $this->getClassName($name);
        $result = $this->createShape($className);

        return $result;
    }

    /**
     * @param $name
     * @return string
     * @throws FactoryException
     */
    protected function getClassName($name) {
        if (empty($name)) {
            throw new FactoryException('$name must not be empty');
        }
        $result = $this->getFactoryNamespace() . '\\' . ucfirst($name) ;

        if (!class_exists($result)) {
            throw new FactoryException ('Class "' . $result . '" does not exist.');
        }

        return $result;
    }

    /**
     * Returns new model instance of $className
     *
     * @param string $className
     * @return AbstractShape
     */
    protected function createShape($className): AbstractShape
    {
        $result = new $className($this);
        return $result;
    }
}