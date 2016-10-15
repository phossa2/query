<?php

namespace Phossa2\Query;

/**
 * select test case.
 */
class SelectTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Builder
     */
    private $object;

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
     * Test Builder->select()->col()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::col()
     */
    public function testCol()
    {
        // mix cols using select() & col()
        $sql = 'SELECT `user_id`, `user_name` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select('user_id')->col('user_name')->getSql()
        );

        // Test *, Users.*
        $sql = 'SELECT * FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->getSql()
        );
        $this->assertEquals(
            $sql,
            $this->object->select()->col()->getSql()
        );
        $this->assertEquals(
            $sql,
            $this->object->select()->col('*')->getSql()
        );
        $sql = 'SELECT Users.* FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select('Users.*')->getSql()
        );

        // col with table name
        $sql = 'SELECT `u`.`user_name` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->col('u.user_name')->getSql()
        );

        // col alias
        $sql = 'SELECT `user_name` AS `n` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->col('user_name', 'n')->getSql()
        );

        // multiple col()
        $sql = 'SELECT `user_id`, `user_name` AS `n` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->col('user_id')->col('user_name', 'n')
                ->getSql()
        );

        // multiple cols with array notation
        $this->assertEquals(
            $sql,
            $this->object->select()->col(['user_id', 'user_name' => 'n'])
                ->getSql()
        );

        // space in alias
        $sql = 'SELECT `user_name` AS `first name` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->col('user_name', 'first name')
            ->getSql()
        );

        // subquery in col
        $sql = 'SELECT (SELECT MAX(`user_id`) FROM `oldUsers`) AS `maxId` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->col(
                $this->object->select()->max('user_id')->table('oldUsers'),
                'maxId'
            )->getSql()
        );
    }

    /**
     * Tests Builder->select()->distinct()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::distinct()
     */
    public function testDistinct()
    {
        $sql = 'SELECT DISTINCT `user_name` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->distinct()->col('user_name')->getSql()
        );

        $this->assertEquals(
            $sql,
            $this->object->select()->distinct('user_name')->getSql()
        );

        $sql = 'SELECT DISTINCT `user_id`, `user_name` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->distinct('user_id', 'user_name')
            ->getSql()
        );
    }

    /**
     * Tests Builder->select()->cnt()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::cnt()
     */
    public function testCnt()
    {
        // functions
        $sql = 'SELECT COUNT(`user_id`) AS `cnt`, MAX(`user_id`) AS `max_id` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->cnt('user_id', 'cnt')
                ->max('user_id', 'max_id')->getSql()
        );
    }

    /**
     * Tests Builder->select()->colRaw()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::colRaw()
     */
    public function testColRaw()
    {
        // raw col
        $sql = 'SELECT SUM(DISTINCT `score`) AS `s` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->colRaw('SUM(DISTINCT `score`) AS `s`')
            ->getSql()
        );

        // positioned param
        $sql = 'SELECT SUM(DISTINCT `score`) + 10 AS `s` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->colRaw('SUM(DISTINCT `score`) + ? AS `s`', [10])
            ->getSql()
        );
    }

    /**
     * Tests Builder->select()->colTpl()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::colTpl()
     */
    public function testColTpl()
    {
        // col template
        $sql = 'SELECT SUM(DISTINCT `score`) AS `s` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->colTpl('SUM(DISTINCT %s)', 'score', 's')
                ->getSql()
        );

        // template with multiple cols
        $sql = "SELECT CONCAT(`first_name`, ' ', `last_name`) AS `n` FROM `Users`";
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->colTpl("CONCAT(%s, ' ', %s)", ['first_name', 'last_name'], 'n')
                ->getSql()
        );
    }

    /**
     * Tests Builder->select()->table()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::table()
     */
    public function testTable()
    {
        // replace using table()
        $sql = 'SELECT * FROM `Topics` AS `t`';
        $this->assertEquals(
            $sql,
            $this->object->select()->table('Topics', 't')->getSql()
        );

        // multiple tables as array
        $sql = 'SELECT * FROM `Topics` AS `t`, `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select()->table(['Topics' => 't', 'Users'])->getSql()
        );

        // from subquery alias
        $sql = 'SELECT * FROM (SELECT `user_id` FROM `oldusers`) AS `u`';
        $this->assertEquals(
            $sql,
            $this->object->select()->table(
                $this->object->select('user_id')->table('oldusers'),
                'u'
            )->getSql()
        );
    }

    /**
     * Tests Builder->select()->from()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::from()
     */
    public function testFrom()
    {
        // append using from()
        $sql = 'SELECT * FROM `Users`, `Topics` AS `t`';
        $this->assertEquals(
            $sql,
            $this->object->select()->from('Topics', 't')->getSql()
        );

        // multiple tables as array
        $sql = 'SELECT * FROM `Users`, `Topics` AS `t`';
        $this->assertEquals(
            $sql,
            $this->object->select()->from(['Topics' => 't'])->getSql()
        );
    }

    /**
     * Tests Builder->select()->group()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::group()
     */
    public function testGroup()
    {
        // group by
        $sql = 'SELECT * FROM `Users` GROUP BY `last_name`';
        $this->assertEquals(
            $sql,
            $this->object->select()->group('last_name')->getSql()
        );

        // group by desc
        $sql = 'SELECT * FROM `Users` GROUP BY `last_name` DESC';
        $this->assertEquals(
            $sql,
            $this->object->select()->groupDesc('last_name')->getSql()
        );

        // multiple groupby
        $sql = 'SELECT * FROM `Users` GROUP BY `last_name`, `first_name`';
        $this->assertEquals(
            $sql,
            $this->object->select()->group('last_name')->group('first_name')
                ->getSql()
        );
        $this->assertEquals(
            $sql,
            $this->object->select()->group('last_name', 'first_name')->getSql()
        );
        $this->assertEquals(
            $sql,
            $this->object->select()->group(['last_name', 'first_name'])->getSql()
        );
    }

    /**
     * Tests Builder->select()->groupRaw()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::groupRaw()
     */
    public function testGroupRaw()
    {
        // raw groupby
        $sql = 'SELECT `group_id` FROM `Users` GROUP BY `group_id`, group_name ASC';
        $qry = $this->object->select('group_id')
            ->group('group_id')->groupRaw('group_name ASC');
        $this->assertEquals($sql, $qry->getSql());

        // positioned param
        $sql = 'SELECT * FROM `Users` GROUP BY group_id + 10';
        $qry = $this->object->select()->groupRaw('group_id + ?', [10]);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->groupTpl()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::groupTpl()
     */
    public function testGroupTpl()
    {
        // single
        $sql = 'SELECT COUNT(*) AS `cnt` FROM `Users` GROUP BY `age` DESC';
        $qry = $this->object->select()->cnt('*', 'cnt')
            ->groupTpl('%s DESC', 'age');
        $this->assertEquals($sql, $qry->getSql());

        // multiple
        $sql = 'SELECT COUNT(*) AS `cnt` FROM `Users` GROUP BY `age`, `group_id`';
        $qry = $this->object->select()->cnt('*', 'cnt')
            ->groupTpl('%s, %s', ['age', 'group_id']);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->limit()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::limit()
     */
    public function testLimit()
    {
        // limit only
        $sql = 'SELECT * FROM `Users` LIMIT 10';
        $qry = $this->object->select()->limit(10);
        $this->assertEquals($sql, $qry->getSql());

        // limit & offset
        $sql = 'SELECT * FROM `Users` LIMIT 10 OFFSET 20';
        $qry = $this->object->select()->limit(10, 20);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->offset()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::offset()
     */
    public function testOffset()
    {
        // offset only
        $sql = 'SELECT * FROM `Users` LIMIT -1 OFFSET 20';
        $qry = $this->object->select()->offset(20);
        $this->assertEquals($sql, $qry->getSql());

        // limit + offset
        $sql = 'SELECT * FROM `Users` LIMIT 15 OFFSET 30';
        $qry = $this->object->select()->limit(15)->offset(30);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->page()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::page()
     */
    public function testPage()
    {
        // page
        $sql = 'SELECT * FROM `Users` LIMIT 30 OFFSET 60';
        $qry = $this->object->select()->page(3, 30);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->order()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::order()
     */
    public function testOrder()
    {
        // ASC and DESC
        $sql = 'SELECT * FROM `Users` ORDER BY `age` ASC, `score` DESC';
        $qry = $this->object->select()->order('age')->orderDesc('score');
        $this->assertEquals($sql, $qry->getSql());

        // multiple
        $sql = 'SELECT * FROM `Users` ORDER BY `age` ASC, `score` ASC';
        $qry = $this->object->select()->order(['age', 'score']);
        $this->assertEquals($sql, $qry->getSql());

        $qry = $this->object->select()->order('age', 'score');
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->orderRaw()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::orderRaw()
     */
    public function testOrderRaw()
    {
        // raw order by
        $sql = 'SELECT * FROM `Users` ORDER BY col NULLS LAST DESC';
        $qry = $this->object->select()->orderRaw('col NULLS LAST DESC');
        $this->assertEquals($sql, $qry->getSql());

        // positioned param
        $sql = 'SELECT * FROM `Users` ORDER BY age + 10';
        $qry = $this->object->select()->orderRaw('age + ?', [10]);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->orderTpl()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::orderTpl()
     */
    public function testOrderTpl()
    {
        // order by template
        $sql = 'SELECT * FROM `Users` ORDER BY `col` NULLS LAST DESC';
        $qry = $this->object->select()->orderTpl('%s NULLS LAST DESC', 'col');
        $this->assertEquals($sql, $qry->getSql());

        // multiple
        $sql = 'SELECT * FROM `Users` ORDER BY `col` NULLS LAST DESC, `uid` ASC';
        $qry = $this->object->select()->orderTpl('%s NULLS LAST DESC, %s ASC', ['col', 'uid']);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->where()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::where()
     */
    public function testWhere()
    {
        // auto raw
        $sql = 'SELECT * FROM `Users` WHERE age > 18';
        $this->assertEquals(
            $sql,
            $this->object->select()->where('age > 18')->getSql()
        );

        // auto equal, multiple wheres
        $sql = "SELECT * FROM `Users` WHERE `age` = 18 AND `gender` = 'male'";
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->where('age', 18)->andWhere('gender', 'male')->getSql()
        );

        // same as above
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->where(['age' => 18, 'gender' => 'male'])->getSql()
        );

        // operator
        $sql = 'SELECT * FROM `Users` WHERE `age` > 18';
        $this->assertEquals(
            $sql,
            $this->object->select()->where('age', '>', 18)->getSql()
        );

        // multiple operators
        $sql = "SELECT * FROM `Users` WHERE `age` > 18 AND `gender` <> 'male'";
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->where(['age' => ['>', 18], 'gender' => ['<>', 'male']])->getSql()
        );

        // subquery as value
        $sql = "SELECT * FROM `Users` WHERE `age` = (SELECT MAX(`age`) FROM `oldUsers`)";
        $this->assertEquals(
            $sql,
            $this->object->select()
                ->where('age', $this->object->select()->max('age')->table('oldUsers'))
                ->getSql()
        );
    }

    /**
     * Tests Builder->select()->orWhere()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::orWhere()
     */
    public function testOrWhere()
    {
        $sql = "SELECT * FROM `Users` WHERE age > 18";
        $this->assertEquals(
            $sql,
            $this->object->select()->where('age > 18')->getSql()
        );

        $sql = "SELECT * FROM `Users` WHERE `age` = 18 OR `gender` = 'male'";
        $this->assertEquals(
            $sql,
            $this->object->select()->where('age', 18)
                ->orWhere('gender', 'male')->getSql()
        );

        // multiple Ors
        $sql = "SELECT * FROM `Users` WHERE `age` = 18 OR `age` = 12 OR `gender` = 'male'";
        $this->assertEquals(
            $sql,
            $this->object->select()->where('age', 18)
            ->orWhere(['age' => 12, 'gender' => 'male'])->getSql()
        );
    }

    /**
     * Tests Builder->select()->whereRaw()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::whereRaw()
     */
    public function testWhereRaw()
    {
        // question mark
        $sql = "SELECT * FROM `Users` WHERE age = 18 OR score > 90";
        $qry = $this->object->select()
            ->whereRaw('age = 18')->orWhereRaw('score > ?', [90]);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->whereTpl()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::whereTpl()
     */
    public function testWhereTpl()
    {
        // simple tple
        $sql = 'SELECT * FROM `Users` WHERE `age` > 18 AND `gender` = "male"';
        $query = $this->object->select()
            ->where('age', '>', 18)->whereTpl('%s = "male"', 'gender');
        $this->assertEquals($sql, $query->getSql());

        // multiple cols
        $sql = 'SELECT * FROM `Users` WHERE `age` > 18 AND `gender` = "male"';
        $query = $this->object->select()
            ->whereTpl('%s > 18 AND %s = "male"', ['age', 'gender']);
        $this->assertEquals($sql, $query->getSql());
    }

    /**
     * Tests Builder->select()->whereNot()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::whereNot()
     */
    public function testWhereNot()
    {
        // whereNot and orWhereNot
        $sql = "SELECT * FROM `Users` WHERE NOT `age` = 18 OR NOT `gender` = 'male'";
        $qry = $this->object->select()
            ->whereNot('age', 18)->orWhereNot('gender', 'male');
        $this->assertEquals($sql, $qry->getSql());

        // array in whereNot
        $sql = "SELECT * FROM `Users` WHERE NOT `age` = 18 AND NOT `gender` = 'male'";
        $qry = $this->object->select()
            ->whereNot(['age' => 18, 'gender' => 'male']);
        $this->assertEquals($sql, $qry->getSql());

        // raw in whereNot
        $sql = "SELECT * FROM `Users` WHERE NOT age = 18";
        $qry = $this->object->select()->whereNot('age = 18');
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * WHERE IS NULL, IN, BETWEEN, EXISTS
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::where()
     */
    public function testWhere2()
    {
        // IS NULL
        $sql = "SELECT * FROM `Users` WHERE `age` IS NULL";
        $qry = $this->object->select()->where('age', 'IS', null);
        $this->assertEquals($sql, $qry->getSql());

        // IS NOT NULL
        $sql = "SELECT * FROM `Users` WHERE `age` IS NOT NULL";
        $qry = $this->object->select()->where('age', 'IS NOT', null);
        $this->assertEquals($sql, $qry->getSql());

        // IN (10,11,12)
        $sql = "SELECT * FROM `Users` WHERE `age` IN (10, 11, 12)";
        $qry = $this->object->select()->where('age', 'IN', [10,11,12]);
        $this->assertEquals($sql, $qry->getSql());

        // IN subquery
        $sql = "SELECT * FROM `Users` WHERE `age` IN (SELECT `age` FROM `newUsers`)";
        $qry = $this->object->select()->where(
            'age', 'IN', $this->object->table('newUsers')->select('age')
        );
        $this->assertEquals($sql, $qry->getSql());

        // BETWEEN
        $sql = "SELECT * FROM `Users` WHERE `age` NOT BETWEEN 10 AND 20";
        $qry = $this->object->select()->where('age', 'NOT BETWEEN', [10, 20]);
        $this->assertEquals($sql, $qry->getSql());

        // EXISTS
        $sql = 'SELECT * FROM `Sales` WHERE EXISTS (SELECT `user_id` FROM `Users`)';
        $qry = $this->object->table('Sales')->select()->where(
            '', 'EXISTS', $this->object->select('user_id')
        );
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->having()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::having()
     */
    public function testHaving()
    {
        // having
        $sql = "SELECT * FROM `Users` HAVING `age` = 18";
        $qry = $this->object->select()->having('age', 18);
        $this->assertEquals($sql, $qry->getSql());

        // having raw with positioned param
        $sql = "SELECT * FROM `Users` HAVING age = 18";
        $qry = $this->object->select()->havingRaw('age = ?', [18]);
        $this->assertEquals($sql, $qry->getSql());

        // having tpl
        $sql = "SELECT * FROM `Users` HAVING `age` = 18";
        $qry = $this->object->select()->havingTpl('%s = 18', 'age');
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->union()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::union()
     */
    public function testUnion()
    {
        // union
        $sql = "SELECT * FROM `Users` UNION SELECT * FROM `newUsers`";
        $qry = $this->object->select()->union()->table('newUsers');
        $this->assertEquals($sql, $qry->getSql());

        // uinon all
        $sql = "SELECT * FROM `Users` UNION ALL SELECT * FROM `newUsers`";
        $qry = $this->object->select()->unionAll()->table('newUsers');
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->join()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::join()
     */
    public function testJoin()
    {
        // same col name
        $sql = 'SELECT * FROM `Users` INNER JOIN `Sales` ON `Users`.`uid` = `Sales`.`uid`';
        $qry = $this->object->select()->join('Sales', 'uid');
        $this->assertEquals($sql, $qry->getSql());

        // table alias
        $sql = 'SELECT * FROM `Users` INNER JOIN `Sales` AS `s` ON `Users`.`uid` = `s`.`uid`';
        $qry = $this->object->select()->join(['Sales', 's'], 'uid');
        $this->assertEquals($sql, $qry->getSql());

        // different col
        $sql = 'SELECT * FROM `Users` INNER JOIN `Sales` AS `s` ON `Users`.`id` = `s`.`uid`';
        $qry = $this->object->select()->join(['Sales', 's'], ['id', 'uid']);
        $this->assertEquals($sql, $qry->getSql());

        // use operator
        $sql = 'SELECT * FROM `Users` INNER JOIN `Sales` AS `s` ON `Users`.`id` <> `s`.`uid`';
        $qry = $this->object->select()->join(['Sales', 's'], ['id', '<>', 'uid']);
        $this->assertEquals($sql, $qry->getSql());

        // multiple joins
        $sql = 'SELECT * FROM `Users` INNER JOIN `Sales` AS `s` ON `Users`.`uid` = `s`.`uid` INNER JOIN `Orders` AS `o` ON `s`.`oid` <> `o`.`oid`';
        $qry = $this->object->select()
            ->join(['Sales', 's'], 'uid')
            ->join(['Orders', 'o'], ['s.oid', '<>', 'o.oid']);
        $this->assertEquals($sql, $qry->getSql());

        // subquery in join
        $sql = 'SELECT * FROM `Users` LEFT JOIN (SELECT `uid` FROM `oldUsers`) AS `x` ON `Users`.`uid` = `x`.`uid`';
        $qry = $this->object->select()->leftJoin(
            [$this->object->select('uid')->table('oldUsers'), 'x'], 'uid'
        );
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->joinRaw()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::joinRaw()
     */
    public function testJoinRaw()
    {
        // positioned param
        $sql = 'SELECT * FROM `Users` INNER JOIN Sales ON Users.uid = 10';
        $qry = $this->object->select()->joinRaw('INNER JOIN', 'Sales ON Users.uid = ?', [10]);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->before()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::before()
     */
    public function testBefore()
    {
        // before
        $sql = 'SELECT SQL_CACHE * FROM `Users`';
        $qry = $this->object->select()->before('col', 'SQL_CACHE');
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->after()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::after()
     */
    public function testAfter()
    {
        // after
        $sql = "SELECT * FROM `Users` INTO OUTFILE 'test.txt'";
        $qry = $this->object->select()
            ->after('table', "INTO OUTFILE 'test.txt'");
        $this->assertEquals($sql, $qry->getSql());

        // positioned param
        $qry = $this->object->select()
            ->after('table', "INTO OUTFILE ?", ['test.txt']);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->hint()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::hint()
     */
    public function testHint()
    {
        // before
        $sql = 'SELECT SQL_CACHE * FROM `Users`';
        $qry = $this->object->select()->hint('SQL_CACHE');
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->option()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::option()
     */
    public function testOption()
    {
        // before
        $sql = 'SELECT * FROM `Users` FOR UPDATE';
        $qry = $this->object->select()->option('FOR UPDATE');
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->select()->partition()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Select::partition()
     */
    public function testPartition()
    {
        // after
        $sql = 'SELECT * FROM `Users` PARTITION (p0, p1, p2, p3) WHERE uid > 10';
        $qry = $this->object->select()
            ->partition('p0')->partition(['p1'])
            ->partition('p2', 'p3')
            ->whereRaw('uid > ?', [10]);
        $this->assertEquals($sql, $qry->getSql());
    }
}
