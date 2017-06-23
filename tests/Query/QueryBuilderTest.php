<?php

namespace Terminal42\WeblingApi\Test\Query;

use Terminal42\WeblingApi\Query\QueryBuilder;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    public function setUp()
    {
        $this->queryBuilder = new QueryBuilder();
    }

    public function testInstantiation()
    {
        static::assertInstanceOf('\Terminal42\WeblingApi\Query\QueryBuilder', $this->queryBuilder);
    }

    public function testSimpleCondition()
    {
        $result = $this->queryBuilder
            ->where('foo')
            ->isEqualTo('bar')
            ->build()
        ;

        static::assertEquals('foo = "bar"', $result);
    }

    public function testMultipleConditions()
    {
        $result = $this->queryBuilder
            ->where('foo')
            ->isEqualTo('bar')
            ->andWhere('bar')
            ->isNotEqualTo('foo')
            ->build()
        ;

        static::assertEquals('foo = "bar" AND bar != "foo"', $result);
    }

    public function testSimpleGroup()
    {
        $result = $this->queryBuilder->group(
            $this->queryBuilder->where('foo')->isEqualTo('bar')
        )->build();

        static::assertEquals('(foo = "bar")', $result);
    }

    public function testComplexGroup()
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

        static::assertEquals('(foo = "bar" AND bar != "foo") OR (bar = "foo" AND foo != "bar")', $result);
    }
}
