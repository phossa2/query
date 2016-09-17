<?php

namespace Phossa2\Query;

/**
 * delete test case.
 */
class DeleteTest extends \PHPUnit_Framework_TestCase
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
     * Tests Builder->delete()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Delete::from()
     */
    public function testFrom()
    {
        // single table deletion
        $sql = "DELETE IGNORE FROM `Users` PARTITION (p1) WHERE `user_id` > 10 ORDER BY `user_id` ASC LIMIT 10";
        $qry = $this->object->delete()->hint('IGNORE')->partition('p1')
            ->where('user_id', '>', 10)->order('user_id')->limit(10);
        $this->assertEquals($sql, $qry->getStatement());
    }

    /**
     * Tests Builder->delete()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Delete::col()
     */
    public function testCol()
    {
        // multiple table deletion
        $sql = "DELETE `u`, `a` FROM `Users` AS `u` LEFT JOIN `Accounts` AS `a` ON `u`.`user_id` = `a`.`user_id` WHERE `a`.`money` IS NULL";
        $qry = $this->object->delete('u', 'a')->table('Users', 'u')
            ->leftJoin(['Accounts', 'a'], 'user_id')
            ->where('a.money', 'IS', null);
        $this->assertEquals($sql, $qry->getStatement());
    }
}
