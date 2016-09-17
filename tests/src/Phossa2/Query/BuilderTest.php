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
     * Tests Builder->__construct()
     */
    public function test__construct()
    {
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
        $this->assertEquals($sql, $query->getStatement());
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
     * Tests Builder->select()
     *
     * @covers Phossa2\Query\Builder::select()
     */
    public function testSelect()
    {
        $sql = 'SELECT `user_id`, `user_name` FROM `Users`';
        $this->assertEquals(
            $sql,
            $this->object->select('user_id', 'user_name')->getStatement()
        );
    }

    /**
     * Tests Builder->insert()
     *
     * @covers Phossa2\Query\Builder::insert()
     */
    public function testInsert()
    {
        // simple insert
        $sql = "INSERT INTO `Users` (`uid`, `uname`) VALUES (2, 'phossa')";
        $qry = $this->object->insert(['uid' => 2, 'uname' => 'phossa']);
        $this->assertEquals($sql, $qry->getStatement());
    }

    /**
     * Tests Builder->update()
     *
     * @covers Phossa2\Query\Builder::update()
     */
    public function testUpdate()
    {
        $sql = "UPDATE `Users` SET `user_name` = 'phossa', `user_addr` = FALSE WHERE `user_id` = 3";
        $qry = $this->object->update()
            ->set('user_name','phossa')
            ->set('user_addr', false)
            ->where('user_id', 3);
        $this->assertEquals($sql, $qry->getStatement());
    }

    /**
     * Tests Builder->replace()
     *
     * @covers Phossa2\Query\Builder::replace()
     */
    public function testReplace()
    {
        $sql = "REPLACE INTO `Users` (`uid`, `uname`) VALUES (2, 'phossa')";
        $qry = $this->object->replace(['uid' => 2, 'uname' => 'phossa']);
        $this->assertEquals($sql, $qry->getStatement());
    }

    /**
     * Tests Builder->delete()
     *
     * @covers Phossa2\Query\Builder::delete()
     */
    public function testDelete()
    {
        // default table
        $sql = "DELETE FROM `Users`";
        $qry = $this->object->delete();
        $this->assertEquals($sql, $qry->getStatement());

        // no default table
        $sql = "DELETE FROM `Accounts`";
        $obj = new Builder();
        $qry = $obj->delete()->from('Accounts');
        $this->assertEquals($sql, $qry->getStatement());
    }

    /**
     * Tests Builder->union()
     *
     * @covers Phossa2\Query\Builder::union()
     */
    public function testUnion()
    {
        $sel1 = $this->object->select();
        $sel2 = $this->object->select()->table('oldUsers');

        $sql = "(SELECT * FROM `Users`) UNION (SELECT * FROM `oldUsers`) ORDER BY `user_id` ASC LIMIT 10";

        // second union is a CLAUSE !!
        $qry = $this->object->union($sel1)->union($sel2)
            ->order('user_id')->limit(10);

        $this->assertEquals($sql, $qry->getStatement());

        // variable argument
        $qry = $this->object->union($sel1, $sel2)
            ->order('user_id')->limit(10);
        $this->assertEquals($sql, $qry->getStatement());
    }
}
