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

namespace Phossa2\Query\Traits\Clause;

use Phossa2\Query\Interfaces\Clause\PartitionInterface;

/**
 * PartitionTrait
 *
 * Implementation of PartitionInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     PartitionInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait PartitionTrait
{
    use AbstractTrait;

    /**
     * {@inheritDoc}
     */
    public function partition($partitionNames)
    {
        $clause = &$this->getClause('PARTITION');
        if (is_array($partitionNames)) {
            $clause = array_merge($clause, $partitionNames);
        } elseif (func_num_args() > 1) {
            $clause = array_merge($clause, func_get_args());
        } else {
            $clause[] = $partitionNames;
        }
        return $this;
    }

    /**
     * Build PARTITION
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildPartition(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        $sepr = $settings['seperator'];
        $clause = &$this->getClause('PARTITION');
        if (empty($clause)) {
            return '';
        } else {
            return $sepr . $prefix . ' (' . join(', ', $clause) . ')';
        }
    }
}
