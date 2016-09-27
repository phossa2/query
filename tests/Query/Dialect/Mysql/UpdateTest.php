<?php

namespace Phossa2\Query;

/**
 * update test case.
 */
class UpdateTest extends \PHPUnit_Framework_TestCase
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
     * Tests Builder->update()->set()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Update::set()
     */
    public function testSet()
    {
        // set subquery
        $sql = "UPDATE `Users` SET `age` = (SELECT MAX(`age`) FROM `oldUsers`)";
        $qry = $this->object->update()
            ->set('age', $this->object->select()->max('age')->table('oldUsers'));
        $this->assertEquals($sql, $qry->getSql());

        // raw set
        $sql = "UPDATE `Users` SET age = age + 1";
        $qry = $this->object->update()->set('age = age + 1');
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->update()->setRaw()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Update::setRaw()
     */
    public function testSetRaw()
    {
        $sql = "UPDATE IGNORE `Users` SET `user_id` = `user_id` + 10, `user_status` = user_status | 2 ORDER BY `user_id` ASC LIMIT 10";
        $qry = $this->object->update()->hint('IGNORE')
            ->setTpl('user_id', '%s + ?', 'user_id', [10])
            ->setRaw('user_status', 'user_status | 2')
            ->order('user_id')->limit(10);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->update()->increment()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Update::increment()
     */
    public function testIncrement()
    {
        $sql = "UPDATE `Users` SET `age` = `age` + 2 WHERE `user_id` = 2";
        $qry = $this->object->update()->increment('age', 2)->where('user_id', 2);
        $this->assertEquals($sql, $qry->getSql());
    }

    /**
     * Tests Builder->update()->decrement()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Update::decrement()
     */
    public function testDecrement()
    {
        $sql = "UPDATE `Users` SET `age` = `age` - 1";
        $qry = $this->object->update()->decrement('age');
        $this->assertEquals($sql, $qry->getSql());
    }
}
