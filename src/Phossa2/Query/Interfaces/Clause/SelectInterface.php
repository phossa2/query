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
use Phossa2\Query\Interfaces\SelectInterface as BuilderSelectInterface;

/**
 * SelectInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     BuilderSelectInterface
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface SelectInterface extends BuilderSelectInterface, ClauseInterface
{
}
