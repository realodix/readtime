<?php

namespace Realodix\ReadTime\Test;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Testing private/protected PHP methods using the Reflection API.
     *
     * @param object $object     Instantiated object that we will run method on.
     * @param string $method     Method name to call.
     * @param array  $parameters Array of parameters to pass into method.
     * @return mixed Method return.
     *
     * @throws \Exception
     */
    protected function getReflection($object, string $method, array $parameters = [])
    {
        try {
            $className = get_class($object);
            $reflection = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
