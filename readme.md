### Класс который делает немного магии

Класс позволяет Вам использовать перегрузку методов (Параметрический полиморфизм) на 40%.

Почему 40? В пхп не разрешено объявлять методы с одинаковыми именами.

Использование класса:

```php
    class Bar {}

    class Foo
    {
        public function withoutArguments(): string
        {
            return 'string';
        }

        public function argument1(string $name): string
        {
            return $name;
        }

        public function argument2(int $number): int
        {
            return $number;
        }

        public function withObject(Bar $bar): Bar
        {
            return $bar;
        }
    }

    $overload = new Overload\Overload(
        new Overload\OverloadClass(Foo::class), 'argument1', 'argument2'
    );

    $overload->call('shinda'); // argument1
    $overload->call(2); // argument2

    $bar = (new Overload\Overload(
        new Overload\OverloadClass(Foo::class), 'withObject'
    ))->call(new Bar); // $bar = Bar object;

    (new Overload\Overload(
            new Overload\OverloadClass(Foo::class), 'withoutArguments'
        ))->call(); // 'string'
```