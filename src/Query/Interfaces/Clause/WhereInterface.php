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
use Phossa2\Query\Interfaces\ExpressionInterface;

/**
 * WhereInterface
 *
 * @package Phossa2\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 2.0.0
 * @since   2.0.0 added
 */
interface WhereInterface extends ClauseInterface
{
    /**
     * Generic WHERE clause
     *
     * ```php
     * // WHERE `age` > 18
     * ->where('age > 18')
     *
     * // WHERE `age` = 18 AND `gender` = 'male'
     * ->where('age', 18)->where('gender', 'male')
     *
     * // WHERE `age` > 18
     * ->where('age', '>', 18)
     *
     * // WHERE `age` = 18 AND `score` = 100
     * ->where(['age' => 18, 'score' => 100])
     *
     * // WHERE `age` > 18 AND `score` <= 100
     * ->where(['age' => [ '>', 18 ], 'score' => [ '<=', 100 ])
     * ```
     *
     * @param  string|string[]|ExpressionInterface $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return $this
     * @access public
     * @api
     */
    public function where($col, $operator = self::NO_OPERATOR, $value = self::NO_VALUE);

    /**
     * WHERE template
     *
     * ```php
     * // WHERE `age` > 18 AND `gender` = "male"
     * ->where('age', '>', 18)->whereTpl('%s = "male"', 'gender')
     *
     * // WHERE (`age` > 18 AND `gender` = "male")
     * ->whereTpl('%s > 18 AND %s = "male"', ['age', 'gender'])
     * ```
     *
     * @param  string $template
     * @param  string|string[] $col
     * @param  array $params
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereTpl(/*# string */ $template, $col, array $params = []);

    /**
     * WHERE template with 'OR' logic
     *
     * ```php
     * // WHERE `age` > 18 OR `gender` = "male"
     * ->where('age', '>', 18)->orWhereTpl('%s = "male"', 'gender')
     * ```
     *
     * @param  string $template
     * @param  string|string[] $col
     * @param  array $params
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereTpl(/*# string */ $template, $col, array $params = []);

    /**
     * Raw mode WHERE
     *
     * ```php
     * // WHERE age > 18 AND gender = 'male'
     * ->whereRaw("age > 18 AND gender = 'male'")
     *
     * // same as above
     * ->whereRaw('age > ? AND gender = ?', [18, 'male'])
     * ```
     *
     * @param  string $rawString
     * @param  array $params
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereRaw(/*# string */ $rawString, array $params = []);

    /**
     * Raw mode WHERE with 'OR' logic
     *
     * ```php
     * // OR (age > 18 AND gender = 'male')
     * ->orWhereRaw("(age > 18 AND gender = 'male')")
     *
     * // same as above
     * ->orWhereRaw('(age > ? AND gender = ?)', [18, 'male'])
     * ```
     *
     * @param  string $rawString
     * @param  array $params
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereRaw(/*# string */ $rawString, array $params = []);

    /**
     * AND logic in WHERE
     *
     * ```php
     * // AND `age` > 18
     * ->andWhere('age', '>', 18)
     *
     * // AND `age` = 18 AND `score` = 100
     * ->andWhere(['age' => 18, 'score' => 100])
     * ```
     *
     * @param  string|string[]|ExpressionInterface $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function andWhere($col, $operator = self::NO_OPERATOR, $value = self::NO_VALUE);

    /**
     * 'OR' logic in WHERE
     *
     * ```php
     * // OR `age` > 18
     * ->orWhere('age', '>', 18)
     *
     * // OR `age` = 18 OR `score` = 100
     * ->orWhere(['age' => 18, 'score' => 100])
     * ```
     *
     * @param  string|string[]|ExpressionInterface $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhere($col, $operator = self::NO_OPERATOR, $value = self::NO_VALUE);

    /**
     * WHERE NOT
     *
     * ```php
     * // WHERE NOT `id` = 18
     * ->whereNot('id', 18)
     *
     * // WHERE NOT `age` = 18 AND NOT `gender` = 'male'
     * ->whereNot(['age' => 18, 'gender' => 'male'])
     * ```
     *
     * @param  string|string[] $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereNot($col, $operator = self::NO_OPERATOR, $value = self::NO_VALUE);

    /**
     * WHERE NOT 'OR' Logic
     *
     * ```php
     * // WHERE NOT `id` = 1 OR NOT `gender` = 'male'
     * ->whereNot(['id' => 1, 'gender' => 'male'])
     * ```
     *
     * @param  string|string[] $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereNot($col, $operator = self::NO_OPERATOR, $value = self::NO_VALUE);
}
