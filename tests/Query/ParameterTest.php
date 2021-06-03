<?php

namespace Terminal42\WeblingApi\Test\Query;

use PHPUnit\Framework\TestCase;
use Terminal42\WeblingApi\Query\Parameter;
use Terminal42\WeblingApi\Query\Query;

class ParameterTest extends TestCase
{

    public function testInstantiation(): void
    {
        $parameter = new Parameter('foo');

        static::assertInstanceOf('\Terminal42\WeblingApi\Query\Parameter', $parameter);
        static::assertInstanceOf('\Terminal42\WeblingApi\Query\BuildableInterface', $parameter);
    }

    public function testReturnsParent(): void
    {
        $parameter = new Parameter('foo');
        $this->assertNull($parameter->getParent());

        $parameter = new Parameter('foo', new Query(new Parameter('bar')));
        $this->assertInstanceOf('Terminal42\WeblingApi\Query\Query', $parameter->getParent());
    }

    /**
     * @dataProvider valueOperatorsProvider
     */
    public function testValueOperators($method, $operator): void
    {
        $parameter = new Parameter('foo');

        $parameter->{$method}('bar');

        $this->assertSame(sprintf('foo %s "bar"', $operator), $parameter->build());
    }

    public function testSpecialOperators(): void
    {
        $parameter = new Parameter('foo');
        $parameter->isEmpty();
        $this->assertSame('foo IS EMPTY', $parameter->build());

        $parameter = new Parameter('foo');
        $parameter->isNotEmpty();
        $this->assertSame('NOT (foo IS EMPTY)', $parameter->build());

        $parameter = new Parameter('foo');
        $parameter->in(['bar', 'baz']);
        $this->assertSame('foo IN ("bar", "baz")', $parameter->build());

        $parameter = new Parameter('foo');
        $parameter->notIn(['bar', 'baz']);
        $this->assertSame('NOT (foo IN ("bar", "baz"))', $parameter->build());

        $parameter = new Parameter('foo');
        $parameter->notLike('bar');
        $this->assertSame('NOT (foo LIKE "bar")', $parameter->build());
    }

    public function testEscapesPropertyIfNecessary(): void
    {
        $parameter = new Parameter('foo bar');
        $parameter->isEmpty();

        $this->assertSame('`foo bar` IS EMPTY', $parameter->build());
    }

    public function testCanSearchForProperty(): void
    {
        $p1 = new Parameter('foo');
        $p2 = new Parameter('bar baz');

        $p1->isEqualTo($p2);

        $this->assertSame('foo = `bar baz`', $p1->build());
    }

    public function testBuildThrowsExceptionWhenQueryIsNotSet(): void
    {
        $this->expectException(\RuntimeException::class);

        $parameter = new Parameter('foo');
        $parameter->build();
    }

    public function testThrowsExceptionIfQueryConditionIsSetTwice(): void
    {
        $this->expectException(\RuntimeException::class);

        $parameter = new Parameter('foo');
        $parameter->isEqualTo('bar');
        $parameter->isEmpty();
    }

    public function valueOperatorsProvider(): array
    {
        return [
            ['isLessThan', '<'],
            ['isLessOrEqualThan', '<='],
            ['isGreaterThan', '>'],
            ['isGreaterOrEqualThan', '>='],
            ['isEqualTo', '='],
            ['isNotEqualTo', '!='],
            ['like', 'LIKE'],
            ['filter', 'FILTER'],
        ];
    }
}
