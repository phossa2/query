# phossa2/query
[![Build Status](https://travis-ci.org/phossa2/query.svg?branch=master)](https://travis-ci.org/phossa2/query)
[![Code Quality](https://scrutinizer-ci.com/g/phossa2/query/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phossa2/query/)
[![Code Climate](https://codeclimate.com/github/phossa2/query/badges/gpa.svg)](https://codeclimate.com/github/phossa2/query)
[![PHP 7 ready](http://php7ready.timesplinter.ch/phossa2/query/master/badge.svg)](https://travis-ci.org/phossa2/query)
[![HHVM](https://img.shields.io/hhvm/phossa2/query.svg?style=flat)](http://hhvm.h4cc.de/package/phossa2/query)
[![Latest Stable Version](https://img.shields.io/packagist/vpre/phossa2/query.svg?style=flat)](https://packagist.org/packages/phossa2/query)
[![License](https://img.shields.io/:license-mit-blue.svg)](http://mit-license.org/)

**phossa2/query** is a SQL query builder library with concise syntax for PHP. It
supports Mysql dialect and more coming.

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

- Complex sql building with [`expr()`](#expr), [`raw()`](#raw),
  [`before()`](#before) etc.

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
       "phossa2/query": "2.*"
    }
}
```

Usage
---

- Getting started

  Start with a query builder first, then query.

  ```php
  use Phossa2\Query\Builder;

  // a builder default to table 'Users' and Mysql as default dialect
  $builder = new Builder();
  $users = $builder->table('Users');

  // SELECT * FROM `Users` LIMIT 10
  $sql = $users->select()->limit(10)->getSql();

  // INSERT INTO `Users` (`usr_name`) VALUES ('phossa')
  $sql = $users->insert(['usr_name' => 'phossa'])->getSql();

  // reset builder to table 'Sales' as 's'
  $sales = $users->table('Sales', 's');

  // SELECT * FROM `Sales` AS `s` WHERE `user_id` = 12
  $qry = $sales->select()->where('user_id', 12);

  // SELECT * FROM `Sales` AS `s` WHERE `user_id` = ?
  $sql = $qry->getStatement(); // with positioned parameters

  // [12]
  var_dump($qry->getBindings());
  ```

- <a name="select"></a>`SELECT`

  - Columns/fields

    Columns can be specified in the `select($col, ...)`, `col($col, $alias)` or
    `col(array $cols)`.

    ```php
    // SELECT * FROM `Users`
    $qry = $users->select();

    // SELECT `user_id`, `user_name` FROM `Users`
    $qry = $users->select('user_id', 'user_name');

    // SELECT `user_id`, `user_name` AS `n` FROM `Users`
    $qry = $users->select()->col('user_id')->col('user_name', 'n');

    // same as above
    $qry = $users->select()->col(['user_id', 'user_name' => 'n']);
    ```

    Raw string can be provided using `colRaw($string, array $parameters)`

    ```php
    // SELECT COUNT(user_id) AS cnt FROM `Users`
    $qry = $users->select()->colRaw('COUNT(user_id) AS cnt');

    // SELECT CONCAT(user_name, 'x') AS con FROM `Users`
    $qry = $users->select()->colRaw('CONCAT(user_name, ?) AS con', ['x']);
    ```

    Common functions like `cnt($col, $alias)`, `min($col, $alias)`,
    `max($col, $alias)`, `avg($col, $alias)`, `sum($col, $alias)` can also be
    used directly.

    ```php
    // SELECT MAX(`user_id`) AS `maxId` FROM `Users`
    $qry = $users->select()->max('user_id', 'maxId');
    ```

    Generic column template by using `colTpl($template, $cols, $alias)`,

    ```php
    // SELECT SUM(DISTINCT `score`) AS `s` FROM `Users`
    $qry = $users->select()->colTpl('SUM(DISTINCT %s)', 'score', 's');

    // SELECT CONCAT(`fname`, ' ', `lname`) AS `fullName` FROM `Users`
    $qry = $users->select()->colTpl("CONCAT(%s, ' ', %s)", ['fname', 'lname'], 'fullName');
    ```

    Subquery can also be use in `col()`,

    ```php
    // SELECT (SELECT MAX(`user_id`) FROM `oldUsers`) AS `maxId` FROM `Users`
    $qry = $users->select()->col(
        $users->select()->max('user_id')->table('oldUsers'),
        'maxId'
    );
    ```

  - Distinct

    `DISTINCT` can be specified with `distinct(...)`,

    ```php
    // SELECT DISTINCT `user_alias` FROM `Users`
    $qry = $users->select()->distinct('user_alias');

    // SELECT DISTINCT `user_alias` AS `a` FROM `Users`
    $qry = $users->select()->distinct()->col('user_alias', 'a');
    ```

  - From

    `from($table, $alias)` or `table($table, $alias)` can be used with
    `$builder` object or query object such as `$builder->select()`.

    Using `table()` to replace any existing tables,

    ```php
    // $sales is a clone of builder $users with table replaced
    $sales = $users->table('Sales');

    // or replace table in the select query object
    $select = $users->select()->table('Sales', 's');

    // SELECT * FROM `Users` AS `u`, `Accounts` AS `a`
    $qry = $users->select()->table(['Users' => 'u', 'Accounts' => 'a']);
    ```

    Using `from()` to append to any existing tables,

    ```php
    // SELECT * FROM `Users`, `Sales` AS `s`
    $select = $users->select()->from('Sales', 's');

    // builder has two tables now
    $usersAndSales = $users->from('Sales', 's');
    ```

    Subqueries can be used in `from()` or `table()`,

    ```php
    // SELECT * FROM (SELECT `user_id` FROM `oldUsers`) AS `u`
    $qry = $users->select()->table(
        $users->select('user_id')->table('oldUsers'),
        'u'
    );
    ```

  - Group

    Group result with `group($col, ...)`,

    ```php
    // SELECT `grp_id`, COUNT(*) AS `cnt` FROM `Users` GROUP BY `grp_id`
    $qry = $users->select()->col('grp_id')->cnt('*', 'cnt')->group('grp_id');
    ```

    Multiple `group()` and `groupRaw($str, array $params)`,

    ```php
    // SELECT `grp_id`, `age`, COUNT(*) AS `cnt` FROM `Users` GROUP BY `grp_id`, age ASC
    $qry = $users->select('grp_id', 'age')->cnt('*', 'cnt')
        ->group('grp_id')->groupRaw('age ASC');
    ```

    Template can also be used with `groupTpl($template, $cols)`,

    ```php
    // GROUP BY `year` WITH ROLLUP
    $users->select()->groupTpl('%s WITH ROLLUP', 'year')
    ```

  - Join

    Join using `join($table, $col)`,

    ```php
    // SELECT * FROM `Users` INNER JOIN `Accounts`
    $qry = $users->select()->join('Accounts');

    // SELECT * FROM `Users` INNER JOIN `Accounts` ON `Users`.`id` = `Accounts`.`id`
    $qry = $users->select()->join('Accounts', 'id');
    ```

    Specify alias for the joined table,

    ```php
    // SELECT * FROM `Users` INNER JOIN `Accounts` AS `a` ON `Users`.`id` = `a`.`id`
    $qry = $users->select()->join(['Accounts', 'a'], 'id');
    ```

    Join table with different column name,

    ```php
    // SELECT * FROM `Users` INNER JOIN `Accounts` AS `a` ON `Users`.`id` = `a`.`user_id`
    $qry = $users->select()->join(['Accounts'], 'a'], ['id', 'user_id']);

    // same as above
    $qry = $users->select()->join(['Accounts'], 'a'], ['Users.id', 'a.user_id']);
    ```

    Join with operator specified,

    ```php
    // SELECT * FROM `Users` INNER JOIN `Accounts` AS `a` ON `Users`.`id` <> `a`.`user_id`
    $qry = $users->select()->join(['Accounts', 'a'], ['id', '<>', 'user_id']);
    ```

    Multiple joins,

    ```php
    // SELECT * FROM `Users`
    // INNER JOIN `Sales` AS `s` ON `Users`.`uid` = `s`.`uid`
    // INNER JOIN `Orders` AS `o` ON `Users`.`uid` = `o`.`oid`
    $qry = $users->select()
                ->join(['Sales', 's'], ['uid', '=', 'uid'])
                ->join(['Orders', 'o'], ['uid', 'o.oid']);
    ```

    Subqueries in join,

    ```php
    // SELECT * FROM `Users` INNER JOIN (SELECT `uid` FROM `oldUsers`) AS `x` ON `Users`.`uid` = `x`.`uid`
    $qry = $users->select()->join(
        [$builder->select('uid')->from('oldUsers'), 'x'],
        'uid'
    );
    ```

    Other joins `leftJoin()`, `rightJoin()`, `outerJoin()`, `leftOuterJoin()`,
    `rightOuterJoin()`, `crossJoin()` are supported. If want to use your own
    join, `joinRaw()` is handy.

    ```php
    // SELECT * FROM `Users` OUTER JOIN `Accounts` AS `a` ON `Users`.`id` = `a`.`id`
    $qry = $users->select()->outerJoin(['Accounts', 'a'], 'id');

    // SELECT * FROM `Users` NATURAL JOIN Accounts AS a ON Users.id = a.id
    $qry = $users->select()->joinRaw('NATURAL JOIN', 'Accounts AS a ON Users.id = a.id');
    ```

  - Limit

    `LIMIT` and `OFFSET` are supported,

    ```php
    // SELECT * FROM `Users` LIMIT 30 OFFSET 10
    $qry = $users->select()->limit(30, 10);

    // SELECT * FROM `Users` LIMIT 20 OFFSET 15
    $qry = $users->select()->limit(20)->offset(15);
    ```

    Or use `page($pageNum, $pageLength)` where `$pageNum` starts from `1`,

    ```php
    // SELECT * FROM `Users` LIMIT 30 OFFSET 60
    $qry = $users->select()->page(3, 30);
    ```

  - Order

    Order by ASC or DESC

    ```php
    // SELECT * FROM `Users` ORDER BY `age` ASC, `score` DESC
    $qry = $users->select()->order('age')->orderDesc('score');
    ```

    Or raw mode

    ```php
    // SELECT * FROM `Users` ORDER BY age ASC, score DESC
    $qry = $users->select()->orderRaw('age ASC, score DESC');
    ```

  - Where

    Simple where clauses,

    ```php
    // SELECT * FROM `Users` WHERE age > 18
    $qry = $users->select()->where('age > 18');

    // SELECT * FROM `Users` WHERE `age` = 18
    $qry = $users->select()->where('age', 18);

    // SELECT * FROM `Users` WHERE `age` < 18
    $qry = $users->select()->where('age', '<', 18);
    ```

    Multiple wheres,

    ```php
    // SELECT * FROM `Users` WHERE `age` > 18 AND `gender` = 'male'
    $qry = $users->select()->where(['age' => ['>', 18], 'gender' => 'male']);

    // same as above
    $qry = $users->select()->where('age', '>', 18)->andWhere('gender','male');
    ```

    Complex where,

    ```php
    // SELECT * FROM `Users` WHERE (`id` = 1 OR (`id` < 20 OR `id` > 100)) OR `name` = 'Tester'
    $qry = $users->select()->where(
                $users->expr()->where('id', 1)->orWhere(
                    $users->expr()->where('id', '<', 20)->orWhere('id', '>', 100)
                )
             )->orWhere('name', 'Tester');
    ```

    Raw mode,

    ```php
    // SELECT * FROM `Users` WHERE age = 18 OR score > 90
    $qry = $users->select()->whereRaw('age = 18')->orWhereRaw('score > 90');
    ```

    with `NOT`,

    ```php
    // SELECT * FROM `Users` WHERE NOT `age` = 18 OR NOT `score` > 90
    $qry = $users->select()->whereNot('age', 18)->orWhereNot('score', '>', 90);
    ```

    Where `IN` and `BETWEEN`

    ```php
    // SELECT * FROM `Users` WHERE `age` IN (10,12,15,18,20)
    $qry = $users->select()->where('age', 'IN', [10,12,15,18,20]);

    // SELECT * FROM `Users` WHERE `age` NOT BETWEEN 10 AND 20
    $qry = $users->select()->where('age', 'NOT BETWEEN', [10,20]);
    ```

    `IS NULL`,

    ```php
    // SELECT * FROM `Users` WHERE `age` IS NULL
    $qry = $users->select()->where('age', 'IS', NULL);
    ```

    `EXISTS`,

    ```php
    // SELECT * FROM `Sales` WHERE EXISTS (SELECT `user_id` FROM `Users`)
    $sql = $sales->select()->where('', 'EXISTS', $users->select('user_id'))->getSql();
    ```

  - Having

    Similar to `WHERE` clause,

    ```php
    // SELECT * FROM `Users` HAVING `age` = 10 OR `level` > 20
    $qry = $users->select()->having('age', 10)->orHaving('level', '>', 20);
    ```

  - Union

    `union()` or `unionAll()` can be used with builder or query object,

    ```php
    // SELECT * FROM `Users`
    // UNION
    //     SELECT * FROM `oldUsers1`
    // UNION ALL
    //     SELECT `user_id` FROM `oldUsers2`
    $sql = $users->select()
            ->union()
                ->select()->table('oldUsers1')
            ->unionAll()
                ->select('user_id')->table('oldUsers2')
            ->getSql()

    // (SELECT * FROM `Users`) UNION (SELECT * FROM `oldUesrs`) ORDER BY `user_id` ASC LIMIT 10
    $sql = $builder->union(
        $builder->select()->table('Users'),
        $builder->select()->table('oldUsers')
    )->order('user_id')->limit(10)->getSql();
    ```
- <a name="insert"></a>`INSERT`

  Single insert statement,

  ```php
  // INSERT INTO `users` (`uid`, `uname`) VALUES (2, 'phossa')
  $sql = $users->insert(['uid' => 2, 'uname' => 'phossa'])->getSql();

  // same as above
  $sql = $users->insert()->set('uid', 2)->set('uname', 'phossa')->getSql();

  // same as above
  $sql = $users->insert()->set(['uid' => 2, 'uname' => 'phossa'])->getSql();
  ```

  Multiple data rows,

  ```php
  // INSERT INTO `Users` (`uid`, `uname`) VALUES (2, 'phossa'), (3, 'test')
  $qry = $users->insert()
            ->set(['uid' => 2, 'uname' => 'phossa'])
            ->set(['uid' => 3, 'uname' => 'test']);
  ```

  Insert with `DEFAULT` values

  ```php
  // INSERT INTO `Users` (`uid`, `uname`, `phone`) VALUES (2, 'phossa', DEFAULT), (3, 'test', '1234')
  $qry = $users->insert([
      ['uid' => 2, 'uname' => 'phossa'],
      ['uid' => 3, 'uname' => 'test', 'phone' => '1234']
  ]);
  ```

  Insert `NULL` instead of default values,

  ```php
  // INSERT INTO `Users` (`uid`, `uname`, `phone`) VALUES (2, 'phossa', NULL), (3, 'test', '1234')
  $sql = $qry->getSql(['useNullAsDefault' => true]);
  ```

  Insert with `SELECT` subquery,

  ```php
  // INSERT INTO `Users` (`uid`, `uname`) SELECT `user_id`, `user_name` FROM `oldUsers`
  $qry = $users->insert()->set(['uid', 'uname'])
      ->select('user_id', 'user_name')->table('oldUsers');
  ```

- <a name="update"></a>`UPDATE`

  Common update statement,

  ```php
  // UPDATE `Users` SET age = age + 1
  $qry = $users->update()->set('age = age + 1');

  // UPDATE `Users` SET `user_name` = 'phossa' WHERE `user_id` = 3
  $qry = $users->update(['user_name' => 'phossa'])->where('user_id', 3);

  // UPDATE `Users` SET `user_name` = 'phossa', `user_addr` = 'xxx' WHERE `user_id` = 3
  $qry = $users->update()->set('user_name','phossa')
      ->set('user_addr', 'xxx')->where('user_id', 3);
  ```

  `increment($col, $step)` and `decrement($col, $step)`,

  ```php
  // UPDATE `Users` SET `age` = `age` + 2 WHERE `user_id` = 2
  $qry = $users->update()->increment('age', 2)->where('user_id', 2);
  ```

  With `Mysql` extensions,

  ```php
  // UPDATE IGNORE `Users` SET `user_id` = `user_id` + 10, `user_status` = user_status | 2 ORDER BY `user_id` ASC LIMIT 10
  $qry = $users->update()->hint('IGNORE')
      ->setTpl('user_id', '%s + ?', 'user_id', [10])
      ->setRaw('user_status', 'user_status | 2')
      ->order('user_id')->limit(10);
  ```

- <a name="replace"></a>`REPLACE`

  Mysql version of replace,

  ```php
  // REPLACE INTO `Users` (`user_id`, `user_name`) VALUES (3, 'phossa')
  $qry = $users->replace(['user_id' => 3, 'user_name' => 'phossa']);
  ```

- <a name="delete"></a>`DELETE`

  Single table deletion,

  ```php
  // DELETE FROM `Users` WHERE `user_id` > 10 ORDER BY `user_id` ASC LIMIT 10
  $qry = $users->delete()->where('user_id', '>', 10)
      ->order('user_id')->limit(10);
  ```

  Multiple tables deletion

  ```php
  // DELETE `u`, `a` FROM `Users` AS `u` INNER JOIN `Accounts` AS `a`
  // ON `u`.`user_id` = `a`.`user_id` WHERE `a`.`total_amount` < 10
  $qry = $builder->delete('u', 'a')->table('Users', 'u')
      ->join(['Accounts', 'a'], 'user_id')->where('a.total_amount', '<', 10);
  ```

Advanced topics
---
- <a name="expr"></a>`expr()`

  Expression can be used to construct complex `WHERE`

  ```php
  // SELECT
  //     *
  // FROM
  //     "Users"
  // WHERE
  //    ("age" < 18 OR "gender" = 'female')
  //    OR ("age" > 60 OR ("age" > 55 AND "gender" = 'female'))
  $qry = $builder->select()->table('Users')->where(
      $builder->expr()->where('age', '<', 18)->orWhere('gender', 'female')
  )->orWhere(
      $builder->expr()->where('age', '>' , 60)->orWhere(
          $builder->expr()->where('age', '>', 55)->where('gender', 'female')
      )
  );
  ```

  Join with complex `ON`,

  ```php
  // SELECT * FROM `Users` INNER JOIN `Sales`
  // (ON `Users`.`uid` = `Sales`.`s_uid` OR `Users`.`uid` = `Sales`.`puid`)
  $sql = $users->select()->join('Sales',
      $builder->expr()->on('Users.uid', 'Sales.s_uid')->orOn('Users.uid', 'Sales.puid')
  )->getSql();
  ```

- <a name="raw"></a>`raw()`

  Raw string to bypass the quoting and escaping,

  ```php
  // SELECT score + 10 FROM `Students` WHERE `time` < NOW()
  $qry = $builder->select()->colRaw('score + 10')
      ->from("Students")->where('time', '<', $builder->raw('NOW()'));

  // SELECT `grp_id`, COUNT(*) AS `cnt` FROM `Users` GROUP BY grp_id ASC
  $qry = $users->select()->col('grp_id')->cnt('*', 'cnt')->groupRaw('grp_id ASC');
  ```

  Raw string with positioned parameters,

  ```php
  // SELECT * FROM `Students` WHERE `age` IN RANGE(1, 1.2)
  $qry = $builder->select()->from("Students")->where("age", "IN",
      $builder->raw('RANGE(?, ?)', [1, 1.2]));

  // same as above
  $qry = $builder->select()->from("Students")
    ->whereRaw("`age` IN RANGE(?, ?)", [1, 1.2]);
  ```

- <a name="template"></a>Template with `colTpl()`, `groupTpl()` etc.

  Using template will make quotation of db names possible,

  ```php
  // SELECT MAX(`score`) AS max FROM `Users`
  $sql = $users->select()->colTpl('MAX(%s)', 'score', 'max')->getSql();
  ```

- <a name="before"></a>`before()`, `after()`, `hint()` and `option()`

  Sometimes, non-standard SQL wanted and no methods found. `before()` and
  `after()` will come to rescue.

  ```php
  // INSERT INTO "users" ("id", "name") VALUES (3, 'phossa') ON DUPLICATE KEY UPDATE id=id+10
  $qry = $users->insert()->set('id', 3)->set('name', 'phossa')
      ->after('VALUES', 'ON DUPLICATE KEY UPDATE id=id+?', [10]);
  ```

  `hint()` add hints right after the statement word, and `option()` will append
  to the end of sql,

  ```php
  // INSERT IGNORE INTO "users" ("id", "name") VALUES (3, 'phossa') ON DUPLICATE KEY UPDATE id=id+10
  $qry = $users->insert()->hint('IGNORE')
      ->set('id', 3)->set('name', 'phossa')
      ->option('ON DUPLICATE KEY UPDATE id=id+?', [10]);
  ```

- <a name="param"></a>Parameters

  *phossa2/query* can return statement for driver to prepare and use the
  `getBindings()` to get the values to bind.

  ```php
  $qry = $users->select()->where("user_id", 10);

  // SELECT * FROM `Users` WHERE `user_id` = ?
  $sql = $qry->getStatement();

  // values to bind: [10]
  $val = $qry->getBindings();
  ```

  Or named parameters,

  ```php
  $qry = $users->select()->where("user_name", ':name');

  // SELECT * FROM `Users` WHERE `user_name` = :name
  $sql = $query->getNamedStatement();
  ```

  Parameters can be applied to raw or template methods,

  ```php
  // SELECT * FROM `Users` GROUP BY `year` + 10
  $sql = $users->select()->groupRaw('`year` + ?', [10])->getSql();

  // same as above
  $sql = $users->select()->groupTpl('%s + ?', 'year', [10])->getSql();
  ```

- <a name="settings"></a>Settings

  Settings can be applied to `$builder` during instantiation or using
  `setSettings()`,

  ```php
  // builder instantiation
  $users = new Builder('Users', new Mysql(), ['autoQuote' => false]);

  // adjust settings
  $users->setSettings(['autoQuote' => true]);
  ```

  Or applied when output with `getSql()` or `getStatement()`,

  ```php
  $sql = $users->select()->getSql(['autoQuote' => false]);
  ```

  Indented sql,

  ```php
  // SELECT
  //     *
  // FROM
  //     `Users`
  $sql = $users->select()->getSql(['seperator' => "\n", 'indent' => "    "]);
  ```

  List of settings,

  - `autoQuote`: boolean. Quote db identifier or not.

  - `positionedParam`: boolean. Output with positioned parameter or not.

  - `namedParam`: boolean. Output with named parameter or not.

  - `seperator`: string, default to ' '. Seperator between clauses.

  - `indent`: string, default to ''. Indent prefix for clauses.

  - `escapeFunction`: callabel, default to `null`. Function used to quote and
    escape values.

  - `useNullAsDefault`: boolean.

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
