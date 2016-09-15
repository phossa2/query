<?php

namespace Phossa2\Query;

/**
 * insert test case.
 */
class InsertTest extends \PHPUnit_Framework_TestCase
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
     * Tests Builder->insert()->set()
     *
     * @covers Phossa2\Query\Dialect\Mysql\Insert::set()
     */
    public function testSet()
    {
        // multiple set()
        $sql = "INSERT INTO `Users` (`uid`, `uname`) VALUES (2, 'phossa')";
        $qry = $this->object->insert()->set('uid', 2)->set('uname', 'phossa');
        $this->assertEquals($sql, $qry->getStatement());

        // set() with data array
        $qry = $this->object->insert()->set(['uid' => 2, 'uname' => 'phossa']);
        $this->assertEquals($sql, $qry->getStatement());

        // mulitple data rows
        $sql = "INSERT INTO `Users` (`uid`, `uname`) VALUES (2, 'phossa'), (3, 'test')";
        $qry = $this->object->insert()
            ->set(['uid' => 2, 'uname' => 'phossa'])
            ->set(['uid' => 3, 'uname' => 'test']);
        $this->assertEquals($sql, $qry->getStatement());

        // default values
        $sql = "INSERT INTO `Users` (`uid`, `uname`, `phone`) VALUES (2, 'phossa', DEFAULT), (3, 'test', '1234')";
        $qry = $this->object->insert([
            ['uid' => 2, 'uname' => 'phossa'],
            ['uid' => 3, 'uname' => 'test', 'phone' => '1234']
        ]);
        $this->assertEquals($sql, $qry->getStatement());

        // insert NULL instead of default
        $sql = "INSERT INTO `Users` (`uid`, `uname`, `phone`) VALUES (2, 'phossa', NULL), (3, 'test', '1234')";
        $qry = $this->object->insert([
            ['uid' => 2, 'uname' => 'phossa'],
            ['uid' => 3, 'uname' => 'test', 'phone' => '1234']
        ]);
        $this->assertEquals($sql, $qry->getStatement([
            'useNullAsDefault' => true
        ]));

        // insert ... select ...
        $sql = "INSERT INTO `Users` (`uid`, `uname`) SELECT `user_id`, `user_name` FROM `oldUsers`";
        $qry = $this->object->insert()->set(['uid', 'uname'])
                ->select(['user_id', 'user_name'])
                ->table('oldUsers');

        // auto positionedParam => true
        $sql = "INSERT INTO `Users` (`uid`, `uname`) VALUES (?, ?)";
        $qry = $this->object->insert()->set(['uid', 'uname']);
        $this->assertEquals($sql, $qry->getStatement());
    }
}
