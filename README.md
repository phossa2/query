# phossa2/query
[![Build Status](https://travis-ci.org/phossa2/query.svg?branch=master)](https://travis-ci.org/phossa2/query)
[![Code Quality](https://scrutinizer-ci.com/g/phossa2/query/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phossa2/query/)
[![PHP 7 ready](http://php7ready.timesplinter.ch/phossa2/query/master/badge.svg)](https://travis-ci.org/phossa2/query)
[![HHVM](https://img.shields.io/hhvm/phossa2/query.svg?style=flat)](http://hhvm.h4cc.de/package/phossa2/query)
[![Latest Stable Version](https://img.shields.io/packagist/vpre/phossa2/query.svg?style=flat)](https://packagist.org/packages/phossa2/query)
[![License](https://poser.pugx.org/phossa2/query/license)](http://mit-license.org/)

**phossa2/query** is a SQL query builder library with concise syntax for PHP. It
supports Mysql, SQLite, Postgres and more dialects.

It requires PHP 5.4, supports PHP 7.0+ and HHVM. It is compliant with [PSR-1][PSR-1],
[PSR-2][PSR-2], [PSR-3][PSR-3], [PSR-4][PSR-4], and the proposed [PSR-5][PSR-5].

[PSR-1]: http://www.php-fig.org/psr/psr-1/ "PSR-1: Basic Coding Standard"
[PSR-2]: http://www.php-fig.org/psr/psr-2/ "PSR-2: Coding Style Guide"
[PSR-3]: http://www.php-fig.org/psr/psr-3/ "PSR-3: Logger Interface"
[PSR-4]: http://www.php-fig.org/psr/psr-4/ "PSR-4: Autoloader"
[PSR-5]: https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md "PSR-5: PHPDoc"

Features
--

- Support [SELECT](#select), [INSERT](#insert), [UPDATE](#update),
  [REPLACE](#replace), [DELETE](#delete).

- Complex sql building with [expr()](#expr), [raw()](#raw).

- Statement with positioned or named [parameters](#param).

- Beautiful output with different [settings](#settings).

- Ongoing support for different dialects like [`Mysql`](#mysql) and more.

Installation
---
Install via the `composer` utility.

```bash
composer require "phossa2/query"
```

or add the following lines to your `composer.json`

```json
{
    "require": {
       "phossa2/query": "^2.0.0"
    }
}
```

Usage
---

- Getting started

  Start with a query builder first, then query.

  ```php
  use Phossa2\Query\Builder;

  // a builder default to 'Users' table and Mysql as default dialect
  $users = new Builder('Users');

  // SELECT * FROM `Users` LIMIT 10
  $sql = $users->select()->limit(10)->getStatement();

  // INSERT INTO `Users` (`usr_name`) VALUES ('phossa')
  $sql = $users->insert(['usr_name' => 'phossa'])->getStatement();

  // reset builder to table 'Sales'
  $sales = $users->table(['Sales' => 's']);

  // SELECT * FROM `Sales` AS `s` WHERE `user_id` = 12
  $query = $sales->select()->where('user_id', 12);

  // SELECT * FROM `Sales` AS `s` WHERE `user_id` = ?
  $sql = $query->getStatement(['positionedParam' => true]);

  // [12]
  var_dump($query->getBindings());
  ```

- <a name="select"></a>`SELECT`

  - Columns/fields

    Columns can be specified in the `select()` or in `col()`

    ```php
    // SELECT `user_id`, `user_name` AS `n` FROM `Users`
    $query = $users->select('user_id')->col('user_name', 'n');

    // same as above
    $query = $users->select(['user_id', 'user_name' => 'n']);

    // same as above
    $query = $users->select()->col('user_id')->col('user_name', 'n');

    // same as above
    $query = $users->select()->col(['user_id', 'user_name' => 'n']);
    ```

    Multiple columns either with multiple `col()` or using array,

    ```php
    // SELECT `user_id`, `user_name` AS `n` FROM `Users`
    $query = $users->select()->col('user_id')->col('user_name', 'n');

    // same as above
    $query = $users->select()->col(['user_id', 'user_name' => 'n']);
    ```

    Raw string can be provided as column,

    ```php
    // SELECT COUNT(user_id) AS `cnt` FROM `Users`
    $query = $users->select()->colRaw(['COUNT(user_id)' => 'cnt']);
    ```

    Common functions like `count()`, `min()`, `max()`, `avg()`, `sum()` can be
    used directly in the columns.

    ```php
    // SELECT COUNT(`user_id`) AS `cnt`, MAX(`user_id`) AS `max_id` FROM `Users`
    $query = $users->select()->count('user_id', 'cnt')->max('user_id', 'max_id');
    ```

    Generic functions by using `colTpl($template, $cols, $alias)`,

    ```php
    // SELECT SUM(DISTINCT `score`) AS `s` FROM `Users`
    $query = $users->select()->colTpl('SUM(DISTINCT %s)', 'score', 's');

    // more cols used in template
    // SELECT CONCAT(`first_name`, ' ', `last_name`) AS `n` FROM `Users`
    $query = $users->select()
        ->colTpl("CONCAT(%s, ' ', %s)", ['first_name', 'last_name'], 'n');
    ```

  - Distinct

    `DISTINCT` can be specified with `distinct($col, $alias)`,

    ```php
    // SELECT DISTINCT `user_alias` AS `a` FROM `Users`
    $query = $users->select()->distinct()->col('user_alias', 'a');

    // same as above
    $query = $users->select()->distinct('user_alias', 'a');
    ```

  - From

    `from()` or `table()` can used with `$builder` object or `$select` query
    object.

    Using `table()` to replace current tables,

    ```php
    // $sales is a clone of $users builder with table replaced
    $sales = $users->table('Sales');

    // table replaced in the query $select
    $select = $users->select()->table('Sales');

    // SELECT * FROM `Users` AS `u`, `Accounts` AS `a`
    $query = $users->select()->table(['Users' => 'u', 'Accounts' => 'a']);
    ```

    Using `from()` to append to current tables,

    ```php
    // builder has default to both tables now, $usersAndSales === $users
    $usersAndSales = $users->from('Sales', 's');

    // SELECT * FROM `Users`, `Sales` AS `s`
    $select = $users->select()->from('Sales', 's');
    ```

    Subqueries can be used in `from()` or `table()`,

    ```php
    // SELECT * FROM (SELECT `user_id` FROM `oldusers`) AS `u`
    $query = $users->select()->table(
        $users->select('user_id')->table('oldusers'), 'u'
    );
    ```

  - Group by

    ```php
    // SELECT `group_id`, COUNT(*) AS `cnt` FROM `Users` GROUP BY `group_id`
    $query = $users->select()->col('group_id')->count('*', 'cnt')->group('group_id');
    ```

    Multiple `group()` and `groupRaw()`,

    ```php
    // SELECT `group_id`, `age`, COUNT(*) AS `cnt` FROM `Users` GROUP BY `group_id`, age ASC
    $query = $users->select()->col('group_id')->col('age')->count('*', 'cnt')
        ->group('group_id')->groupRaw('age ASC');
    ```

  - Join

    Join with another table with same column name

    ```php
    // SELECT * FROM `Users` INNER JOIN `accounts` ON `Users`.`id` = `accounts`.`id`
    $query = $users->select()->join('accounts', 'id');
    ```

    Specify alias for the join table,

    ```php
    // SELECT * FROM `Users` INNER JOIN `accounts` AS `a` ON `Users`.`id` = `a`.`id`
    $query = $users->select()->join('accounts a', 'id');
    ```

    Join table with different column name,

    ```php
    // SELECT * FROM `Users` INNER JOIN `accounts` AS `a` ON `Users`.`id` = `a`.`user_id`
    $query = $users->select()->join('accounts a', 'id', 'user_id');
    ```

    Join with operator specified,

    ```php
    // SELECT * FROM `Users` INNER JOIN `accounts` AS `a` ON `Users`.`id` <> `a`.`user_id`
    $query = $users->select()->join('accounts a', 'id', '<>', 'user_id');
    ```

    Multiple joins,

    ```php
    // SELECT * FROM `Users`
    // INNER JOIN `sales` AS `s` ON `Users`.`uid` = `s`.`uid`
    // INNER JOIN `order` AS `o` ON `Users`.`uid` = `o`.`o_uid`
    $query = $users->select()
                ->join('sales s', 'uid', '=', 'uid')
                ->join('order o', 'uid', 'o_uid')
                ->getStatement();
    ```

    Subqueries in join,

    ```php
    // SELECT * FROM `Users` INNER JOIN (SELECT `uid` FROM `oldusers`) AS `x`
    // ON `Users`.`uid` = `x`.`uid`
    $query = $users->select()->join(
        $builder->select('uid')->from('oldusers')->alias('x'),
        'uid'
    );
    ```

    Other joins `outerJoin()`, `leftJoin()`, `leftOuterJoin()`, `rightJoin()`,
    `rightOuterJoin()`, `fullOuterJoin()`, `crossJoin()` are supported. If want
    to use your own join, `realJoin()` is handy.

    ```php
    // SELECT * FROM `Users` OUTER JOIN `accounts` AS `a` ON `Users`.`id` = `a`.`id`
    $query = $users->select()->outerJoin('accounts a', 'id');

    // SELECT * FROM `Users` NATURAL JOIN `accounts` AS `a` ON `Users`.`id` = `a`.`id`
    $query = $users->select()->realJoin('NATURAL', 'accounts a', 'id');
    ```

  - Limit

    `LIMIT` and `OFFSET` are supported,

    ```php
    // SELECT * FROM `Users` LIMIT 30 OFFSET 10
    $query = $users->select()->limit(30, 10);

    // SELECT * FROM `Users` LIMIT 20 OFFSET 15
    $query = $users->select()->limit(20)->offset(15);
    ```

    Or use `page($pageNum, $pageLength)` where `$pageNum` starts from `1`,

    ```php
    // SELECT * FROM `Users` LIMIT 30 OFFSET 60
    $query = $users->select()->page(3, 30);
    ```

  - Order by

    Order by ASC or DESC

    ```php
    // SELECT * FROM `Users` ORDER BY `age` ASC, `score` DESC
    $query = $users->select()->order('age')->orderDesc('score');
    ```

    Or raw mode

    ```php
    // SELECT * FROM `Users` ORDER BY age ASC, score DESC
    $query = $users->select()->orderRaw('age ASC, score DESC');
    ```

  - Where

    Simple wheres,

    ```php
    // SELECT * FROM `Users` WHERE age > 18
    $query = $users->select()->where('age > 18');

    // SELECT * FROM `Users` WHERE `age` = 18
    $query = $users->select()->where('age', 18);

    // SELECT * FROM `Users` WHERE `age` < 18
    $query = $users->select()->where('age', '<', 18);
    ```

    Multiple wheres,

    ```php
    // SELECT * FROM `Users` WHERE `age` > 18 AND `gender` = 'male'
    $query = $users->select()->where(['age' => ['>', 18], 'gender' => 'male']);

    // same as above
    $query = $users->select()->where('age', '>', 18)->andWhere('gender','male');
    ```

    Complex where,

    ```php
    // SELECT * FROM `Users` WHERE (`id` = 1 OR (`id` < 20 OR `id` > 100))
    // OR `name` = 'Tester'
    $query = $users->select()->where(
                $builder->expr()->where('id', 1)->orWhere(
                    $builder->expr()->where('id', '<', 20)->orWhere('id', '>', 100)
                )
             )->orWhere('name', 'Tester');
    ```

    Raw mode,

    ```php
    // SELECT * FROM `Users` WHERE age = 18 OR score > 90
    $query = $users->select()->whereRaw('age = 18')->orWhereRaw('score > 90');
    ```

    with `NOT`,

    ```php
    // SELECT * FROM `Users` WHERE NOT `age` = 18 OR NOT `score` > 90
    $query = $users->select()->whereNot('age', 18)->orWhereNot('score', '>', 90);
    ```

    Where `IN` and `BETWEEN`

    ```php
    // SELECT * FROM `Users` WHERE `age` IN (10,12,15,18,20)
    $query = $users->select()->where('age', 'IN', [10,12,15,18,20]);

    // SELECT * FROM `Users` WHERE `age` NOT BETWEEN 10 AND 20
    $query = $users->select()->where('age', 'NOT BETWEEN', [10,20]);
    ```

    `IS NULL`,

    ```php
    // SELECT * FROM `Users` WHERE `age` IS NULL
    $query = $users->select()->where('age', 'IS', NULL);
    ```

    `EXISTS`,

    ```php
    // SELECT * FROM `Sales` WHERE EXISTS (SELECT `user_id` FROM `Users`)
    $sql = $sales->select()->where('', 'EXISTS', $users->select('user_id'))->getStatement();
    ```

  - Having

    Similar to `WHERE` clause,

    ```php
    // SELECT * FROM `Users` HAVING `age` = 10 OR `level` > 20
    $query = $users->select()->having('age', 10)->orHaving('level', '>', 20);
    ```

  - Union

    ```php
    // SELECT * FROM `Users` UNION SELECT * FROM `oldusers1`
    // UNION ALL SELECT `user_id` FROM `oldusers2`
    $sql = $users->select()
            ->union()
                ->select()->table('oldusers1')
            ->unionAll()
                ->select('user_id')->table('oldusers2')
                ->getStatement()
    ```

Features
---

- <a name="anchor"></a>**Feature One**


APIs
---

- <a name="api"></a>`LoggerInterface` related

Change log
---

Please see [CHANGELOG](CHANGELOG.md) from more information.

Testing
---

```bash
$ composer test
```

Contributing
---

Please see [CONTRIBUTE](CONTRIBUTE.md) for more information.

Dependencies
---

- PHP >= 5.4.0

- phossa2/shared >= 2.0.21

License
---

[MIT License](http://mit-license.org/)
