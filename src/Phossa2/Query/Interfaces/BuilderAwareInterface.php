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

namespace Phossa2\Query\Interfaces;

/**
 * BuilderAwareInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface BuilderAwareInterface
{
    /**
     * Set the builder
     *
     * @param  BuilderInterface $builder
     * @return $this
     * @access public
     */
    public function setBuilder(BuilderInterface $builder);

    /**
     * Return the builder
     *
     * @return BuilderInterface
     * @access public
     */
    public function getBuilder()/*# : BuilderInterface */;
}
