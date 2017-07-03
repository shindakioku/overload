<?php

namespace Overload;

class Overload
{
    /**
     * @var OverloadClass
     */
    protected $class;

    /**
     * @var \string[]
     */
    protected $methods;

    /**
     * Overload constructor.
     * @param OverloadClass $class
     * @param \string[] ...$methods
     */
    public function __construct(OverloadClass $class, string ...$methods)
    {
        $this->class = $class;
        $this->methods = $methods;
    }

    /**
     * @param array ...$params
     * @return null|string
     */
    public function call(...$params)
    {
        if (0 === count($params)) {
            return $this->class->callWithoutArguments(
                $this->methods
            );
        }

        return $this->class->callWithArguments($params, $this->methods);
    }
}