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
        $sql = "SELECT * FROM `Users` WHERE (`id` = 1 OR (`id` < 20 OR `id` > 100)) OR `name` = 'Tester'";
        $query = $this->object->select()->where(
            $this->object->expr()->where('id', 1)->orWhere(
                $this->object->expr()->where('id', '<', 20)->orWhere('id', '>', 100)
            )
        )->orWhere('name', 'Tester');
        //$this->assertEquals($sql, $query->getStatement());
    }

    /**
     * Tests Builder->raw()
     */
    public function testRaw()
    {
    }

    /**
     * Tests Builder->table()
     */
    public function testTable()
    {
        // reset tables in builder
        $sql = 'SELECT * FROM `Orders` AS `o`, `Users`';
        $this->assertEquals(
            $sql,
            $this->object->table(['Orders' => 'o', 'Users'])->select()->getStatement()
        );

        // reset tables in query
        $sales = $this->object->table('Sales', 's');
        $sql = 'SELECT * FROM `Sales` AS `s` WHERE `user_id` = 12';
        $this->assertEquals(
            $sql,
            $sales->select()->where('user_id', 12)->getStatement()
        );
    }

    /**
     * Tests Builder->from()
     */
    public function testFrom()
    {
        // append to table list
        $sql = 'SELECT * FROM `Users`, `Orders` AS `o`';
        $this->assertEquals(
            $sql,
            $this->object->from('Orders', 'o')->select()->getStatement()
        );
    }

    /**
     * Same result
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect0()
    {
        // same cols
        $sql = 'SELECT `user_id`, `user_name` AS `n` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select(['user_id', 'user_name' => 'n'])->getStatement()
        );
        $this->assertEquals(
            $sql,
            $this->object->select('user_id')->col('user_name', 'n')->getStatement()
        );
        $this->assertEquals(
            $sql,
            $this->object->select()->col('user_id')->col('user_name', 'n')->getStatement()
        );
        $this->assertEquals(
            $sql,
            $this->object->select()->col(['user_id', 'user_name' => 'n'])->getStatement()
        );
    }

    /**
     * Tests Builder->select()->col()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect10()
    {
        // empty col, *
        $sql = 'SELECT * FROM `Users` LIMIT 10';
        $this->assertEquals(
            $sql,
            $this->object->select()->limit(10)->getStatement()
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

        // multiple cols1
        $sql = 'SELECT `user_id`, `user_name` AS `n` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->col('user_id')->col('user_name', 'n')
                ->getStatement()
        );

        // multiple cols2
        $this->assertEquals(
            $sql,
            $this->object->select()->col(['user_id', 'user_name' => 'n'])
                ->getStatement()
        );
    }

    /**
     * Tests Builder->select()->distinct()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect11()
    {
        $sql = 'SELECT DISTINCT `user_name` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->distinct()->col('user_name')->getStatement()
        );

        $this->assertEquals(
            $sql,
            $this->object->select()->distinct('user_name')->getStatement()
        );

        $sql = 'SELECT DISTINCT `user_name` AS `n` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->distinct('user_name', 'n')->getStatement()
        );

        $sql = 'SELECT DISTINCT `user_id`, `user_name` AS `n` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->distinct(['user_id', 'user_name' => 'n'])->getStatement()
        );
    }

    /**
     * Tests Builder->select()->count()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect12()
    {
        // functions
        $sql = 'SELECT COUNT(`user_id`) AS `cnt`, MAX(`user_id`) AS `max_id` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->count('user_id', 'cnt')
            ->max('user_id', 'max_id')->getStatement()
        );
    }

    /**
     * Tests Builder->select()->colRaw()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect13()
    {
        // raw col
        $sql = 'SELECT SUM(DISTINCT `score`) AS `s` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->colRaw('SUM(DISTINCT `score`)', 's')
            ->getStatement()
        );
    }

    /**
     * Tests Builder->select()->colTpl()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect14()
    {
        // col template
        $sql = 'SELECT SUM(DISTINCT `score`) AS `s` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->colTpl('SUM(DISTINCT %s)', 'score', 's')
                ->getStatement()
        );

        // template with multiple cols
        $sql = "SELECT CONCAT(`first_name`, ' ', `last_name`) AS `n` FROM `Users`";
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->colTpl("CONCAT(%s, ' ', %s)", ['first_name', 'last_name'], 'n')
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

        // multiple tables as array
        $sql = 'SELECT * FROM `Topics` AS `t`, `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->table(['Topics' => 't', 'Users'])->getStatement()
        );

        // from subquery
        $sql = 'SELECT * FROM (SELECT `user_id` FROM `oldusers`) AS `u`';
        $this->assertEquals(
            $sql,
            $this->object->select()->table(
                $this->object->select('user_id')->table('oldusers'),
                'u'
            )->getStatement()
        );
    }

    /**
     * Tests Builder->select()->groupBy()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect3()
    {
        $sql = 'SELECT `group_id`, COUNT(*) AS `cnt` FROM `Users` GROUP BY `group_id`';
        $this->assertEquals(
            $sql,
            $this->object->select()->col('group_id')->count('*', 'cnt')
                ->groupBy('group_id')->getStatement()
        );

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

        // same as above
        $this->assertEquals(
            $sql,
            $this->object->select()->groupBy(['last_name', 'first_name'])->getStatement()
        );

        // same as above
        $this->assertEquals(
            $sql,
            $this->object->select()->groupBy('last_name')->groupBy('first_name')->getStatement()
        );

        // raw groupby
        $sql = 'SELECT `group_id`, COUNT(*) AS `cnt` FROM `Users` GROUP BY group_id ASC';
        $query = $this->object->select('group_id')->count('*', 'cnt')
            ->groupByRaw('group_id ASC');
        $this->assertEquals($sql, $query->getStatement());

        // groupby template
        $sql = 'SELECT COUNT(*) AS `cnt` FROM `Users` GROUP BY `age`, `group_id`';
        $query = $this->object->select()->count('*', 'cnt')
            ->groupByTpl('%s, %s', ['age', 'group_id']);
        $this->assertEquals($sql, $query->getStatement());
    }

    /**
     * Tests Builder->select()->limit()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect4()
    {
        // limit only
        $sql = 'SELECT * FROM `Users` LIMIT 10';
        $query = $this->object->select()->limit(10);
        $this->assertEquals(
            $sql,
            $query->getStatement()
        );

        // limit & offset
        $sql = 'SELECT * FROM `Users` LIMIT 10 OFFSET 20';
        $query = $this->object->select()->limit(10, 20);
        $this->assertEquals(
            $sql,
            $query->getStatement()
        );

        // offset only
        $sql = 'SELECT * FROM `Users` LIMIT -1 OFFSET 20';
        $query = $this->object->select()->offset(20);
        $this->assertEquals(
            $sql,
            $query->getStatement()
        );

        // limit + offset
        $sql = 'SELECT * FROM `Users` LIMIT 15 OFFSET 30';
        $query = $this->object->select()->limit(15)->offset(30);
        $this->assertEquals(
            $sql,
            $query->getStatement()
        );

        // page
        $sql = 'SELECT * FROM `Users` LIMIT 30 OFFSET 60';
        $query = $this->object->select()->page(3, 30);
        $this->assertEquals(
            $sql,
            $query->getStatement()
        );
    }

    /**
     * Tests Builder->select()->orderBy()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect5()
    {
        // ASC and DESC
        $sql = 'SELECT * FROM `Users` ORDER BY `age` ASC, `score` DESC';
        $query = $this->object->select()->orderBy('age')->orderByDesc('score');
        $this->assertEquals(
            $sql,
            $query->getStatement()
        );

        // multiple cols
        $sql = 'SELECT * FROM `Users` ORDER BY `age` ASC, `score` ASC';
        $query = $this->object->select()->orderBy(['age', 'score']);
        $this->assertEquals(
            $sql,
            $query->getStatement()
        );

        // raw order by
        $sql = 'SELECT * FROM `Users` ORDER BY col NULLS LAST DESC';
        $query = $this->object->select()->orderByRaw('col NULLS LAST DESC');
        $this->assertEquals(
            $sql,
            $query->getStatement()
        );

        // order by template
        $sql = 'SELECT * FROM `Users` ORDER BY `col` NULLS LAST DESC';
        $query = $this->object->select()->orderByTpl('%s NULLS LAST DESC', 'col');
        $this->assertEquals(
            $sql,
            $query->getStatement()
        );
    }

    /**
     * Tests Builder->select()->where()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect61()
    {
        // auto raw
        $sql = 'SELECT * FROM `Users` WHERE age > 18';
        $this->assertEquals(
            $sql,
            $this->object->select()->where('age > 18')->getStatement()
        );

        // auto equal, multiple wheres
        $sql = "SELECT * FROM `Users` WHERE `age` = 18 AND `gender` = 'male'";
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->where('age', 18)->andWhere('gender', 'male')->getStatement()
        );

        // same as above
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->where(['age' => 18, 'gender' => 'male'])->getStatement()
        );

        // operator
        $sql = 'SELECT * FROM `Users` WHERE `age` > 18';
        $this->assertEquals(
            $sql,
            $this->object->select()->where('age', '>', 18)->getStatement()
        );

        // multiple operators
        $sql = "SELECT * FROM `Users` WHERE `age` > 18 AND `gender` <> 'male'";
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->where(['age' => ['>', 18], 'gender' => ['<>', 'male']])->getStatement()
        );
    }

    /**
     * Tests Builder->select()->orWhere()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect62()
    {
        $sql = "SELECT * FROM `Users` WHERE `age` = 18 OR `gender` = 'male'";
        $this->assertEquals(
            $sql,
            $this->object->select()->where('age', 18)
                ->orWhere('gender', 'male')->getStatement()
        );

        // or group
        $sql = "SELECT * FROM `Users` WHERE `age` = 18 OR `age` = 12 OR `gender` = 'male'";
        $this->assertEquals(
            $sql,
            $this->object->select()->where('age', 18)
            ->orWhere(['age' => 12, 'gender' => 'male'])->getStatement()
        );
    }

    /**
     * Tests Builder->select()->whereRaw()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect63()
    {
        $sql = "SELECT * FROM `Users` WHERE age = 18 OR score > 90";
        $query = $this->object->select()
            ->whereRaw('age = 18')->orWhereRaw('score > ?', [90]);
        $this->assertEquals($sql, $query->getStatement());
    }

    /**
     * Tests Builder->select()->whereTpl()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect64()
    {
        // simple tple
        $sql = 'SELECT * FROM `Users` WHERE `age` > 18 AND `gender` = "male"';
        $query = $this->object->select()
            ->where('age', '>', 18)->whereTpl('%s = "male"', 'gender');
        $this->assertEquals($sql, $query->getStatement());

        // multiple cols
        $sql = 'SELECT * FROM `Users` WHERE `age` > 18 AND `gender` = "male"';
        $query = $this->object->select()
            ->whereTpl('%s > 18 AND %s = "male"', ['age', 'gender']);
        $this->assertEquals($sql, $query->getStatement());
    }

    /**
     * Tests Builder->select()->whereNot()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect65()
    {
        // whereNot and orWhereNot
        $sql = "SELECT * FROM `Users` WHERE NOT `age` = 18 OR NOT `gender` = 'male'";
        $query = $this->object->select()
            ->whereNot('age', 18)->orWhereNot('gender', 'male');
        $this->assertEquals($sql, $query->getStatement());

        // array in whereNot
        $sql = "SELECT * FROM `Users` WHERE NOT `age` = 18 AND NOT `gender` = 'male'";
        $query = $this->object->select()
            ->whereNot(['age' => 18, 'gender' => 'male']);
        $this->assertEquals($sql, $query->getStatement());

        // raw in whereNot
        $sql = "SELECT * FROM `Users` WHERE NOT age = 18";
        $query = $this->object->select()->whereNot('age = 18');
        $this->assertEquals($sql, $query->getStatement());
    }

    /**
     * IS NULL, IN, BETWEEN, EXISTS
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect66()
    {
        // IS NULL
        $sql = "SELECT * FROM `Users` WHERE `age` IS NULL";
        $query = $this->object->select()->where('age', 'IS', null);
        $this->assertEquals($sql, $query->getStatement());

        // IS NOT NULL
        $sql = "SELECT * FROM `Users` WHERE `age` IS NOT NULL";
        $query = $this->object->select()->where('age', 'IS NOT', null);
        $this->assertEquals($sql, $query->getStatement());

        // IN (10,11,12)
        $sql = "SELECT * FROM `Users` WHERE `age` IN (10, 11, 12)";
        $query = $this->object->select()->where('age', 'IN', [10,11,12]);
        $this->assertEquals($sql, $query->getStatement());

        // IN subquery
        $sql = "SELECT * FROM `Users` WHERE `age` IN (SELECT `age` FROM `newUsers`)";
        $query = $this->object->select()->where(
            'age', 'IN', $this->object->table('newUsers')->select('age')
        );
        $this->assertEquals($sql, $query->getStatement());

        // BETWEEN
        $sql = "SELECT * FROM `Users` WHERE `age` NOT BETWEEN 10 AND 20";
        $query = $this->object->select()->where('age', 'NOT BETWEEN', [10, 20]);
        $this->assertEquals($sql, $query->getStatement());

        // EXISTS
        $sql = 'SELECT * FROM `Sales` WHERE EXISTS (SELECT `user_id` FROM `Users`)';
        $query = $this->object->table('Sales')->select()->where(
            '', 'EXISTS', $this->object->select('user_id')
        );
        $this->assertEquals($sql, $query->getStatement());
    }

    /**
     * Tests Builder->select()->having()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect7()
    {
        // having
        $sql = "SELECT * FROM `Users` HAVING `age` = 18";
        $query = $this->object->select()->having('age', 18);
        $this->assertEquals($sql, $query->getStatement());

        // having raw
        $sql = "SELECT * FROM `Users` HAVING age = 18";
        $query = $this->object->select()->havingRaw('age = ?', [18]);
        $this->assertEquals($sql, $query->getStatement());

        // having tpl
        $sql = "SELECT * FROM `Users` HAVING `age` = 18";
        $query = $this->object->select()->havingTpl('%s = 18', 'age');
        $this->assertEquals($sql, $query->getStatement());
    }

    /**
     * Tests Builder->select()->union()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect8()
    {
        // union
        $sql = "SELECT * FROM `Users` UNION SELECT * FROM `newUsers`";
        $query = $this->object->select()->union()->select()->table('newUsers');
        $this->assertEquals($sql, $query->getStatement());

        // uinon all
        $sql = "SELECT * FROM `Users` UNION ALL SELECT * FROM `newUsers`";
        $query = $this->object->select()->unionAll()->select()->table('newUsers');
        $this->assertEquals($sql, $query->getStatement());
    }
}
