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

use Phossa2\Query\Misc\Template;
use Phossa2\Query\Interfaces\Clause\OrderByInterface;

/**
 * OrderByTrait
 *
 * Implementation of OrderByInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     OrderByInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait OrderByTrait
{
    /**
     * {@inheritDoc}
     */
    public function orderBy($col)
    {
        return $this->realOrderBy($col, 'ASC');
    }

    /**
     * {@inheritDoc}
     */
    public function orderByDesc($col)
    {
        return $this->realOrderBy($col, 'DESC');
    }

    /**
     * {@inheritDoc}
     */
    public function orderByTpl(/*# string */ $template, $col)
    {
        return $this->realOrderBy(new Template($template, $col), '', true);
    }

    /**
     * {@inheritDoc}
     */
    public function orderByRaw(/*# string */ $rawString)
    {
        return $this->realOrderBy($rawString, '',  true);
    }

    /**
     * @param  string|string[] $col
     * @param  string $suffix 'ASC' or 'DESC'
     * @param  bool $rawMode
     * @return $this
     * @access protected
     */
    protected function realOrderBy(
        $col,
        /*# sting */ $suffix = 'ASC',
        /*# bool */ $rawMode = false
    ) {
        if (is_array($col)) {
            $this->multipleOrderBy($col, $suffix);
        } else {
            $clause = &$this->getClause('ORDER BY');
            $clause[] = [$col, $suffix, $this->isRaw($col, $rawMode)];
        }
        return $this;
    }

    /**
     * Multitple orderbys
     *
     * @param  array $cols
     * @param  string $suffix 'ASC' or 'DESC'
     * @access protected
     */
    protected function multipleOrderBy(array $cols, /*# sting */ $suffix)
    {
        foreach ($cols as $col) {
            $this->realOrderBy($col, $suffix);
        }
    }

    /**
     * Build ORDER BY
     *
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildOrderby(array $settings)/*# : string */
    {
        $result = [];
        $clause = &$this->getClause('ORDER BY');
        foreach ($clause as $ord) {
            $item = $this->quoteItem($ord[0], $settings, $ord[2]);
            $ordr = $ord[1] ? (' ' . $ord[1]) : '';
            $result[] =  $item . $ordr;
        }
        return $this->joinClause('ORDRE BY', ',', $result, $settings);
    }

    abstract protected function isRaw($str, /*# bool */ $rawMode)/*# : bool */;
    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract protected function quoteItem($item, array $settings, /*# bool */ $rawMode = false)/*# : string */;
    abstract protected function joinClause(
        /*# : string */ $prefix,
        /*# : string */ $seperator,
        array $clause,
        array $settings
    )/*# : string */;
}
