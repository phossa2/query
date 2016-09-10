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
use Phossa2\Query\Interfaces\Statement\SelectStatementInterface;

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
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereTpl(/*# string */ $template, $col);

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
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereTpl(/*# string */ $template, $col);

    /**
     * Raw mode WHERE
     *
     * ```php
     * // WHERE age > 18 AND gender = "male"
     * ->whereRaw('age > 18 AND gender = "male"')
     * ```
     *
     * @param  string $rawString
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereRaw(/*# string */ $rawString);

    /**
     * Raw mode WHERE with 'OR' logic
     *
     * ```php
     * // OR (age > 18 AND gender = "male")
     * ->orWhereRaw('age > 18 AND gender = "male"')
     * ```
     *
     * @param  string $rawString
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereRaw(/*# string */ $rawString);

    /**
     * AND logic in WHERE
     *
     * ```php
     * // AND `age` > 18
     * ->andWhere('age', '>', 18)
     *
     * // AND (`age` = 18 AND `score` = 100)
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
     * // OR (`age` = 18 AND `score` = 100)
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
     * // WHERE (NOT `age` = 18 AND NOT `gender` = 'male')
     * ->whereNot(['age' => 18, 'gender' => 'male'])
     *
     * // WHERE NOT `id` = 18
     * ->whereNot('id', 18)
     *
     * // WHERE (NOT `id` = 1 AND NOT `gender` = 'male') OR NOT `name` = 'john'
     * ->whereNot(['id' => 1, 'gender' => 'male'])->orWhereNot('name', 'john')
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
     * // WHERE (NOT `id` = 1 AND NOT `gender` = 'male') OR NOT `name` = 'john'
     * ->whereNot(['id' => 1, 'gender' => 'male'])->orWhereNot('name', 'john')
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

    /**
     * WHERE IN
     *
     * ```php
     * // WHERE `age` IN (10,11,12)
     * ->whereIn('age', [10, 11, 12])
     *
     * // WHERE `user_id` IN (SELECT `user_id` FROM `accounts`)
     * ->whereIn('user_id', $subquery)
     * ```
     *
     * @param  string $col
     * @param  array|SelectStatementInterface $value
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereIn(/*# string */ $col, $value);

    /**
     * WHERE IN with 'OR' logic
     *
     * ```php
     * // WHERE `gender` = 'male' OR `age` IN (10,11,12)
     * ->where('gender', 'male')->orWhereIn('age', [10, 11, 12])
     *
     * // WHERE `gender` = 'male OR `user_id` IN (SELECT `user_id` FROM `accounts`)
     * ->where('gender', 'male')->orWhereIn('user_id', $subquery)
     * ```
     *
     * @param  string $col
     * @param  mixed $value
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereIn(/*# string */ $col, $value);

    /**
     * WHERE NOT IN
     *
     * ```php
     * // WHERE `age` NOT IN (10,11,12)
     * ->whereNotIn('age', [10, 11, 12])
     * ```
     *
     * @param  string $col
     * @param  mixed $value
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereNotIn(/*# string */ $col, $value);

    /**
     * WHERE NOT IN with 'OR' logic
     *
     * ```php
     * // WHERE `gender` = 'male' OR `age` NOT IN (10,11,12)
     * ->where('gender', 'male')->orWhereNotIn('age', [10, 11, 12])
     * ```
     *
     * @param  string $col
     * @param  mixed $value
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereNotIn(/*# string */ $col, $value);

    /**
     * WHERE BETWEEN
     *
     * ```php
     * // WHERE `age` BETWEEN 10 AND 20
     * ->whereBetween('age', 10, 20)
     * ```
     *
     * @param  string $col
     * @param  mixed $value1
     * @param  mixed $value2
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereBetween(/*# string */ $col, $value1, $value2);

    /**
     * WHERE BETWEEN with 'OR' logic
     *
     * ```php
     * // WHERE `gender` = 'male' OR `age` BETWEEN 10 AND 20
     * ->where('gender', 'male')->orWhereBetween('age', 10, 20)
     * ```
     *
     * @param  string $col
     * @param  mixed $value1
     * @param  mixed $value2
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereBetween(/*# string */ $col, $value1, $value2);

    /**
     * WHERE NOT BETWEEN
     *
     *
     * ```php
     * // WHERE `age` NOT BETWEEN 10 AND 20
     * ->whereNotBetween('age', 10, 20)
     * ```
     *
     * @param  string $col
     * @param  mixed $value1
     * @param  mixed $value2
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereNotBetween(/*# string */ $col, $value1, $value2);

    /**
     * WHERE NOT BETWEEN with 'OR' logic
     *
     * ```php
     * // WHERE `gender` = 'male' OR `age` NOT BETWEEN 10 AND 20
     * ->where('gender', 'male')->orWhereNotBetween('age', 10, 20)
     * ```
     *
     * @param  string $col
     * @param  mixed $value1
     * @param  mixed $value2
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereNotBetween(/*# string */ $col, $value1, $value2);

    /**
     * WHERE IS NULL
     *
     * ```php
     * // WHERE `gender` IS NULL
     * ->whereNull('gender')
     * ```
     *
     * @param  string $col
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereNull(/*# string */ $col);

    /**
     * WHERE IS NULL with 'OR' logic
     *
     * ```php
     * // WHERE `age` > 18 OR `gender` IS NULL
     * ->where('age', '>', 18)->orWhereNull('gender')
     * ```
     *
     * @param  string $col
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereNull(/*# string */ $col);

    /**
     * WHERE IS NOT NULL
     *
     * ```php
     * // WHERE `gender` IS NOT NULL
     * ->whereNull('gender')
     * ```
     *
     * @param  string $col
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereNotNull(/*# string */ $col);

    /**
     * WHERE IS NOT NULL with 'OR' logic
     *
     * ```php
     * // WHERE `age` > 18 OR `gender` IS NOT NULL
     * ->where('age', '>', 18)->orWhereNotNull('gender')
     * ```
     *
     * @param  string $col
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereNotNull(/*# string */ $col);

    /**
     * WHERE EXISTS
     *
     * ```php
     * // WHERE EXISTS (SELECT `user_id` FROM `users`)
     * ->whereExists($users->select('user_id'))
     * ```
     *
     * @param  SelectStatementInterface $sel
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereExists(SelectStatementInterface $sel);

    /**
     * WHERE EXISTS with 'OR' logic
     *
     * ```php
     * // WHERE `gender` = 'male' OR EXISTS (SELECT `user_id` FROM `users`)
     * ->where('gender', 'male')->orWhereExists($users->select('user_id'))
     * ```
     *
     * @param  SelectStatementInterface $sel
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereExists(SelectStatementInterface $sel);

    /**
     * WHERE NOT EXISTS
     *
     * ```php
     * // WHERE NOT EXISTS (SELECT `user_id` FROM `users`)
     * ->whereNotExists($users->select('user_id'))
     * ```
     *
     * @param  SelectStatementInterface $sel
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereNotExists(SelectStatementInterface $sel);

    /**
     * WHERE NOT EXISTS with 'OR' logic
     *
     * ```php
     * // WHERE `gender` = 'male' OR NOT EXISTS (SELECT `user_id` FROM `users`)
     * ->where('gender', 'male')->orWhereNotExists($users->select('user_id'))
     * ```
     *
     * @param  SelectStatementInterface $sel
     * @return $this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhereNotExists(SelectStatementInterface $sel);
}
