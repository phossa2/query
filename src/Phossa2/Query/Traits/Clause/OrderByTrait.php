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
        if (func_num_args() > 1) {
            $rawString = $this->getBuilder()
                ->raw($rawString, (array) func_get_arg(1));
        }
        return $this->realOrderBy($rawString, '',  true);
    }

    /**
     * Real orderby
     *
     * @param  string|string[]|Template $col
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
            $part = [$col, $this->isRaw($col, $rawMode)];
            if (!empty($suffix)) {
                $part[] = $suffix;
            }
            $clause[] = $part;
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
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildOrderby(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        return $this->buildClause('ORDER BY', $prefix, $settings);
    }

    abstract public function getBuilder()/*# : BuilderInterface */;
    abstract protected function isRaw($str, /*# bool */ $rawMode)/*# : bool */;
    abstract protected function &getClause(/*# string */ $clauseName)/*# : array */;
    abstract protected function buildClause(
        /*# string */ $clauseName,
        /*# string */ $clausePrefix,
        array $settings,
        array $clauseParts = []
    )/*# string */;
}
