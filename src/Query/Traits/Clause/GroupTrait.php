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
use Phossa2\Query\Interfaces\Clause\GroupInterface;

/**
 * GroupTrait
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     GroupInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
trait GroupTrait
{
    use AbstractTrait;

    /**
     * {@inheritDoc}
     */
    public function group($col)
    {
        // support multiple group by
        if (func_num_args() > 1) {
            $col = func_get_args();
        }
        return $this->realGroup($col);
    }

    /**
     * {@inheritDoc}
     */
    public function groupDesc($col)
    {
        return $this->realGroup($col, 'DESC');
    }

    /**
     * {@inheritDoc}
     */
    public function groupTpl(/*# string */ $template, $col, array $params = [])
    {
        $template = $this->positionedParam($template, $params);
        return $this->realGroup(new Template($template, $col), '', true);
    }

    /**
     * {@inheritDoc}
     */
    public function groupRaw(/*# string */ $rawString, array $params = [])
    {
        $rawString = $this->positionedParam($rawString, $params);
        return $this->realGroup($rawString, '', true);
    }

    /**
     * real group by
     * @param  string|string[]|Template $col column[s]
     * @param  string $suffix ''|ASC|DESC
     * @param  bool $rawMode
     * @return $this
     * @access protected
     */
    protected function realGroup(
        $col,
        /*# sting */ $suffix = '',
        /*# bool */ $rawMode = false
    ) {
    
        if (is_array($col)) {
            $this->multipleGroup($col, $suffix);
        } else {
            $clause = &$this->getClause('GROUP BY');
            $part = [$col, $this->isRaw($col, $rawMode)];
            if (!empty($suffix)) {
                $part[] = $suffix;
            }
            $clause[] = $part;
        }
        return $this;
    }

    /**
     * Multitple groupbys
     *
     * @param  array $cols
     * @param  string $suffix
     * @access protected
     */
    protected function multipleGroup(array $cols, /*# string */ $suffix)
    {
        foreach ($cols as $col) {
            $this->realGroup($col, $suffix);
        }
    }

    /**
     * Build GROUP BY
     *
     * @param  string $prefix
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function buildGroup(
        /*# string */ $prefix,
        array $settings
    )/*# : string */ {
        return $this->buildClause('GROUP BY', $prefix, $settings);
    }
}
