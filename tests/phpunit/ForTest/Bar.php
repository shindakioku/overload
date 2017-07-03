<?php

namespace Tests\PhpUnit\ForTest;

class Bar
{
    /**
     * @return int
     */
    public function oneMethod(): int
    {
        return 1;
    }

    /**
     * @param string $a
     * @return string
     */
    public function oneMethodWithArgument(string $a): string
    {
        return $a;
    }

    /**
     * @param string $a
     * @return string
     */
    public function twoMethods1(string $a): string
    {
        return $a;
    }

    /**
     * @param int $a
     * @return int
     */
    public function twoMethods2(int $a): int
    {
        return $a;
    }

    /**
     * @param string $a
     * @param int $b
     * @return string
     */
    public function twoArguments1(string $a, int $b): string
    {
        return $a.(string) $b;
    }

    /**
     * @param array $a
     * @param int $b
     * @return string
     */
    public function twoArguments2(array $a, int $b): string
    {
        return $a['key'].(integer) $b;
    }

    /**
     * @param Foo $foo
     * @return Foo
     */
    public function oneObject(Foo $foo): Foo
    {
        return $foo;
    }

    /**
     * @param string $a
     * @return string
     */
    public function threeArguments1(string $a): string
    {
        return $a;
    }

    /**
     * @param int $a
     * @return int
     */
    public function threeArguments2(int $a): int
    {
        return $a;
    }

    /**
     * @param array $a
     * @return array
     */
    public function threeArguments3(array $a): array
    {
        return $a;
    }
}