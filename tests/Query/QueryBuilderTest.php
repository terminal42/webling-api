<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Test\Query;

use PHPUnit\Framework\TestCase;
use Terminal42\WeblingApi\Query\QueryBuilder;

class QueryBuilderTest extends TestCase
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    protected function setUp(): void
    {
        $this->queryBuilder = new QueryBuilder();
    }

    public function testInstantiation(): void
    {
        $this->assertInstanceOf(QueryBuilder::class, $this->queryBuilder);
    }

    public function testSimpleCondition(): void
    {
        $result = $this->queryBuilder
            ->where('foo')
            ->isEqualTo('bar')
            ->build()
        ;

        $this->assertSame('foo = "bar"', $result);
    }

    public function testMultipleConditions(): void
    {
        $result = $this->queryBuilder
            ->where('foo')
            ->isEqualTo('bar')
            ->andWhere('bar')
            ->isNotEqualTo('foo')
            ->build()
        ;

        $this->assertSame('foo = "bar" AND bar != "foo"', $result);
    }

    public function testSimpleGroup(): void
    {
        $result = $this->queryBuilder->group(
            $this->queryBuilder->where('foo')->isEqualTo('bar')
        )->build();

        $this->assertSame('(foo = "bar")', $result);
    }

    public function testComplexGroup(): void
    {
        $result = $this->queryBuilder
            ->group(
                $this->queryBuilder
                    ->where('foo')->isEqualTo('bar')
                    ->andWhere('bar')->isNotEqualTo('foo')
            )->orGroup(
                $this->queryBuilder
                    ->where('bar')->isEqualTo('foo')
                    ->andWhere('foo')->isNotEqualTo('bar')
            )->build()
        ;

        $this->assertSame('(foo = "bar" AND bar != "foo") OR (bar = "foo" AND foo != "bar")', $result);
    }
}
