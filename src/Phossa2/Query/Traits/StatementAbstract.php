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
    use SettingsTrait, BuilderAwareTrait;

    /**
     * value bindings
     *
     * @var    array
     * @access protected
     */
    protected $bindings;

    /**
     * Statement type, 'SELECT' etc.
     *
     * @var    string
     * @access protected
     */
    protected $type = '';

    /**
     * clause configs,[name => prefix]
     *
     * @var    array
     * @access protected
     */
    protected $configs = [];

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
    public function getStatement(array $settings = [])/*# : string */
    {
        // combine settings
        $settings = $this->combineSettings($settings);

        // build current sql
        $sql = $this->buildSql($settings);

        // replace with ?, :name or real values
        return $this->bindValues($sql, $settings);
    }

    /**
     * {@inheritDoc}
     */
    public function getBindings()/*# : array */
    {
        return $this->bindings;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# : string */
    {
        return $this->getStatement([
            'positionedParam' => false,
            'namedParam' => false,
        ]);
    }

    /**
     * Combine builder/statement and provided settings
     *
     * @param  array $settings statement specific settings
     * @return array
     * @access protected
     */
    protected function combineSettings(array $settings)/*# : array */
    {
        return array_replace(
            $this->getBuilder()->getSettings(), // builder settings
            $this->getBuilder()->getDialect()->dialectSettings(), // dialect
            $settings,  // user settings
            $this->getSettings() // statement settings
        );
    }

    /**
     * Build SQL statement clauses
     *
     * @param  array $settings
     * @param  string
     * @access protected
     */
    protected function buildSql(array $settings)/*# : string */
    {
        $result = $this->type;
        $settings['join'] = $settings['seperator'] . $settings['indent'];
        foreach ($this->configs as $clause => $prefix) {
            $method = 'build' . ucfirst(strtolower($clause));
            $result .= $this->{$method}($prefix, $settings);
        }
        return $result;
    }

    /**
     * Replace placeholders in the sql with '?', ':named' or real value
     *
     * @param  string $sql
     * @param  array $settings
     * @return string
     * @access protected
     */
    protected function bindValues(/*# string */ $sql, array $settings)/*# : string */
    {
        // init bindings
        $this->bindings = [];

        // bind values
        return $this->getBuilder()->getParameter()
            ->bindValues($sql, $this->bindings, $settings);
    }
}
