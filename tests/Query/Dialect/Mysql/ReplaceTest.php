<?php

namespace Phossa2\Query;

/**
 * replace test case.
 */
class ReplaceTest extends \PHPUnit_Framework_TestCase
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
     * Tests Builder->replace()->set()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Replace::set()
     */
    public function testSet()
    {
        $sql = "REPLACE LOW_PRIORITY INTO `Users` (`uid`, `uname`) VALUES (2, 'phossa')";
        $qry = $this->object->replace()
            ->hint('LOW_PRIORITY')->set('uid', 2)->set('uname', 'phossa');
        $this->assertEquals($sql, $qry->getSql());
    }
}
