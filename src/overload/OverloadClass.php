<?php

namespace Overload;

use Overload\Exceptions\IncorrectMethod;

final class OverloadClass
{
    /**
     * @var \ReflectionMethod[]
     */
    private $methods;

    /**
     * OverloadClass constructor.
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->methods = (new \ReflectionClass($class))->getMethods();
    }

    /**
     * @param array $arguments
     * @param array $methodsCall
     * @return mixed
     * @throws IncorrectMethod
     */
    public function callWithArguments(array $arguments, array $methodsCall)
    {
        $this->cleanMethods($methodsCall);
        $methodsForCall = [];

        foreach ($this->methods as $k) {
            if (($argumentsCount = count($arguments)) === count($k->getParameters())) {
                $methodsForCall[] = $k;
            }
        }

        if (1 < count($methodsForCall)) {
            return $this->callWithOverload($methodsForCall, $arguments);
        } elseif (1 == count($methodsForCall)) {
            $method = array_shift($methodsForCall);

            foreach ($method->getParameters() as $k => $v) {
                $typeUserArgument = $this->getTypeWithInteger($arguments[$k]);

                if (!$this->checkType($typeUserArgument, $v)) {
                    $nameForClass = $v->getClass()->getName();
                    $classObject = new $nameForClass();
                    if ($arguments[$k] != $classObject) {
                        throw new IncorrectMethod(
                            sprintf('Class %s have no method with with argument type %s', $v->class, $typeUserArgument)
                        );
                    }
                    unset($nameForClass);
                    unset($classObject);
                }
            }

            return $method->invokeArgs(new $method->class(), $arguments);
        }

        throw new IncorrectMethod(
            sprintf('Class %s have no method with length %d arguments', $k->class, $argumentsCount)
        );
    }

    /**
     * @param array $methods
     * @param array $arguments
     * @return mixed
     */
    private function callWithOverload(array $methods, array $arguments)
    {
        $correctMethods = [];
        $allArguments = [];
        $forCorrect = [];

        foreach ($arguments as $argument) {
            foreach ($methods as $k) {
                if (count($arguments) === count($k->getParameters())) {
                    $allArguments[] = [
                        'parameter' => $argument,
                        'type' => $this->getTypeWithInteger($argument),
                    ];
                    $correctMethods[] = $k;
                }
            }
        }

        foreach ($arguments as $index => $key) {
            foreach ($correctMethods as $value) {
                if ($this->checkType($this->getTypeWithInteger($key), $value->getParameters()[$index])) {
                    $forCorrect[$value->name]['class'] = $value->class;
                    $forCorrect[$value->name]['method'] = $value->name;
                    $forCorrect[$value->name]['correct'] += 1;
                }
            }
        }

        $methodForCall = $this->getMethodForCall($forCorrect);

        $class = new $methodForCall['class']();
        $parameterClass = new \ReflectionMethod(
            $class, $methodForCall['method']
        );


        return $parameterClass->invokeArgs($class, $arguments);
    }

    /**
     * @param array $methodsCall
     * @return mixed
     * @throws IncorrectMethod
     */
    public function callWithoutArguments(array $methodsCall)
    {
        $this->cleanMethods($methodsCall);

        foreach ($this->methods as $k) {
            if (!$k->getParameters()) {
                return $k->invoke(new $k->class(), $k->name);
            }
        }

        throw new IncorrectMethod('Class have no methods without arguments');
    }

    /**
     * @param array $methodsCall
     */
    private function cleanMethods(array $methodsCall): void
    {
        foreach ($this->methods as $k => $v) {
            if (!in_array($v->name, $methodsCall)) {
                unset($this->methods[$k]);
            }
        }
    }

    /**
     * @param string|array|int|float $argument
     * @return string
     */
    private function getTypeWithInteger($argument): string
    {
        return ($type = gettype($argument)) !== 'integer' ? $type : 'int';
    }

    /**
     * @param string $typeArgument
     * @param \ReflectionParameter $parameter
     * @return bool
     */
    private function checkType(string $typeArgument, \ReflectionParameter $parameter): bool
    {
        if ($typeArgument !== $parameter->getType()->getName()) {
            return false;
        }

        return true;
    }

    /**
     * @param array $data
     * @return array
     */
    private function getMethodForCall(array $data): array
    {
        $methodForCall = [];
        $current = 0;

        foreach ($data as $k => $v) {
            if ($v['correct'] > $current) {
                $current = $v['correct'];
                $methodForCall = $v;
            }
        }

        return $methodForCall;
    }
}