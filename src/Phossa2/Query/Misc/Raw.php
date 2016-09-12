<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Library
 * @package   Phossa2\Query
 * @copyright Copyright (c) 2016 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa2\Query\Misc;

use Phossa2\Query\Interfaces\RawInterface;
use Phossa2\Query\Traits\StatementAbstract;
use Phossa2\Query\Interfaces\BuilderInterface;

/**
 * Raw
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementAbstract
 * @see     RawInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
class Raw extends StatementAbstract implements RawInterface
{
    /**
     * raw string
     *
     * @var    string
     * @access protected
     */
    protected $raw_string;

    /**
     * Constructor
     *
     * @param  string $rawSql
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(
        /*# string */ $rawSql,
        BuilderInterface $builder
    ) {
        parent::__construct($builder);
        $this->raw_string = (string) $rawSql;
    }

    /**
     * {@inheritDoc}
     */
    protected function buildSql(array $settings)/*# : string */
    {
        return $this->raw_string;
    }
}
