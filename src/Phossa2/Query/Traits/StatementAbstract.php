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

namespace Phossa2\Query\Traits;

use Phossa2\Shared\Base\ObjectAbstract;
use Phossa2\Query\Interfaces\BuilderInterface;
use Phossa2\Query\Interfaces\StatementInterface;

/**
 * StatementAbstract
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ObjectAbstract
 * @see     StatementInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
abstract class StatementAbstract extends ObjectAbstract implements StatementInterface
{
    use DialectAwareTrait, SettingsTrait, BuilderAwareTrait;

    /**
     * Constructor
     *
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->setBuilder($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function getDialect()/*# : DialectInterface */
    {
        if ($this->hasDialect()) {
            return $this->getDialect();
        } else {
            return $this->getBuilder()->getDialect();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getStatement(array $settings = [])/*# : string */
    {
        // combine settings
        $settings = $this->combineSettings(
            $this->getDialect()->dialectSettings(), // dialect specific
            $settings // user provided settings
        );

        // build sql
        $sql = $this->build($settings);

        return $sql;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# : string */
    {
        return $this->getStatement();
    }

    /**
     * Combine builder/statement and provided settings
     *
     * @param  array $settings1 dialect specific
     * @param  array $settings2 user provided
     * @access protected
     */
    protected function combineSettings(
        array $settings1,
        array $settings2
    )/*# : array */ {
        return array_merge(
            $this->getBuilder()->getSettings(), // from builder
            $this->getSettings(), // current statement
            $settings1, // dialect specific
            $settings2  // user settings
        );
    }

    /**
     * Build SQL statement clauses
     *
     * @param  array $settings
     * @param  string
     * @access protected
     */
    protected function build(array $settings)/*# : string */
    {
        $result = $this->getType();
        $settings['join'] = $settings['seperator'] . $settings['indent'];
        foreach ($this->getConfigs() as $clause) {
            $method = 'build' . ucfirst(strtolower($clause));
            $result .= $this->{$method}($settings);
        }
        return $result;
    }

    /**
     * Get the statement type, such as 'SELECT'
     *
     * @return string
     * @access protected
     */
    protected function getType()/*# : string */
    {
        return '';
    }

    /**
     * Get clause configurations
     *
     * @return array
     * @access protected
     */
    abstract protected function getConfigs()/*# : array */;
}
