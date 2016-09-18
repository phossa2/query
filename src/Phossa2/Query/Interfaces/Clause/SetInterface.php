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

namespace Phossa2\Query\Interfaces\Clause;

use Phossa2\Query\Interfaces\ClauseInterface;
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

/**
 * SetInterface
 *
 * Used in INSERT
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface SetInterface extends ClauseInterface
{
    /**
     * Insert into table
     *
     * @param  string|array $col
     * @param  mixed $value scalar or SelectStatementInterface
     * @return $this
     * @access public
     * @api
     */
    public function set($col, $value = ClauseInterface::NO_VALUE);

    /**
     * SET, but do NOT quote the value
     *
     * @param  string $col
     * @param  string $value
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function setRaw(
        /*# string */ $col,
        $value = ClauseInterface::NO_VALUE,
        array $params = []
    );

    /**
     * SET with template, used to set with functions
     *
     * @param  string $col
     * @param  string $template
     * @param  string|string[] $field
     * @param  array $params
     * @return $this
     * @access public
     * @api
     */
    public function setTpl(
        /*# string */ $col,
        /*# string */ $template,
        $field,
        array $params = []
    );
}
