<?php

namespace Phossa2\Query;

/**
 * Builder test case.
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Builder
     */
    private $builder;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->object = new Builder('Users');
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->object = null;
        parent::tearDown();
    }

    /**
     * Tests Builder->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated BuilderTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");

        $this->object->__construct(/* parameters */);
    }

    /**
     * Tests Builder->expr()
     */
    public function testExpr()
    {
        // TODO Auto-generated BuilderTest->testExpr()
        $this->markTestIncomplete("expr test not implemented");

        $this->object->expr(/* parameters */);
    }

    /**
     * Tests Builder->raw()
     */
    public function testRaw()
    {
        // TODO Auto-generated BuilderTest->testRaw()
        $this->markTestIncomplete("raw test not implemented");

        $this->object->raw(/* parameters */);
    }

    /**
     * Tests Builder->table()
     */
    public function testTable()
    {
        $sql = 'SELECT * FROM `Orders` AS `o`, `Users`';
        $this->assertEquals(
            $sql,
            $this->object->table(['Orders' => 'o', 'Users'])->select()->getStatement()
        );
    }

    /**
     * Tests Builder->from()
     */
    public function testFrom()
    {
        $sql = 'SELECT * FROM `Users`, `Orders` AS `o`';
        $this->assertEquals(
            $sql,
            $this->object->from('Orders', 'o')->select()->getStatement()
        );
    }

    /**
     * Tests Builder->select()->col()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect1()
    {
        // empty col, *
        $sql = 'SELECT * FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->getStatement()
        );

        // single col
        $sql = 'SELECT `u`.`user_name` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select('u.user_name')->getStatement()
        );

        // distinct
        $sql = 'SELECT DISTINCT `user_name` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->distinct('user_name')->getStatement()
        );

        // col alias
        $sql = 'SELECT `user_name` AS `n` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select('user_name', 'n')->getStatement()
        );

        // multiple cols
        $sql = 'SELECT `user_id`, `user_name` AS `n` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select('user_id')->col('user_name', 'n')->getStatement()
        );

        // multiple cols2
        $this->assertEquals(
            $sql,
            $this->object->select(['user_id', 'user_name' => 'n'])->getStatement()
        );

        // count
        $sql = 'SELECT COUNT(`user_id`) AS `cnt 2` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->count('user_id', 'cnt 2')->getStatement()
        );

        // multiple max
        $sql = 'SELECT MAX(`lang_score`), MAX(`math_score`) FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->max('lang_score')->max('math_score')->getStatement()
        );

        // col template
        $sql = 'SELECT SUM(DISTINCT `score`) AS `s` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->colTpl('SUM(DISTINCT %s)', 'score', 's')
                ->getStatement()
        );

        // raw col
        $this->assertEquals(
            $sql,
            $this->object->select()->colRaw('SUM(DISTINCT `score`)', 's')
                ->getStatement()
        );
    }

    /**
     * Tests Builder->select()->from()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect2()
    {
        // replace table
        $sql = 'SELECT * FROM `Topics` AS `t`';
        $this->assertEquals(
            $sql,
            $this->object->select()->table('Topics', 't')->getStatement()
        );

        // append table
        $sql = 'SELECT * FROM `Users`, `Topics` AS `t`';
        $this->assertEquals(
            $sql,
            $this->object->select()->from('Topics', 't')->getStatement()
        );
    }

    /**
     * Tests Builder->select()->groupBy()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect3()
    {
        // group by
        $sql = 'SELECT * FROM `Users` GROUP BY `last_name`';
        $this->assertEquals(
            $sql,
            $this->object->select()->groupBy('last_name')->getStatement()
        );

        // multiple groupby
        $sql = 'SELECT * FROM `Users` GROUP BY `last_name`, `first_name`';
        $this->assertEquals(
            $sql,
            $this->object->select()->groupBy('last_name', 'first_name')->getStatement()
        );

        $this->assertEquals(
            $sql,
            $this->object->select()->groupBy(['last_name', 'first_name'])->getStatement()
        );

        $this->assertEquals(
            $sql,
            $this->object->select()->groupBy('last_name')->groupBy('first_name')->getStatement()
        );
    }

    /**
     * Tests Builder->select()->where()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect4()
    {
        // where
        $sql = 'SELECT * FROM `Users` WHERE `user_id` = 10';
        $this->assertEquals(
            $sql,
            $this->object->select()->where('user_id', 10)->getStatement()
        );
    }
}
