# terminal42/webling-api

An API client for the REST API of webling.ch.
This client is currently used for our own projects and is not stable at all.
It thus might be subject to heavy changes.
If you're interested in moving to a stable release (version 1.0.0) so you can be
sure there are no BC breaks until version 2.0.0 (semver), please feel free to
get in touch with us.

## Installation

```bash
$ composer.phar require terminal42/webling-api dev-develop
```

## Usage

```php
$subdomain  = 'meinverein';
$apiKey     = 'foobar';
$apiVersion = '1';

$client = new Client($subdomain, $apiKey, $apiVersion);

// Example call for member list:
$client->get('member');
```

## The EntityManager

If you're looking for a more convenient way to work with the API instead of
calling it directly, you can work with the `EntityManager`.

The main issue with the webling API is the fact that requesting resource lists
(e.g. `/member`) will only return an array of object ID's instead of
additional data like the member last name or first name.

The `EntityList` will take care of this and lazy load the additional details
whenever you need them. That way you can easily iterate over a list of members:

```php
$em = EntityManager::createForAccount($subdomain, $apiKey);

$entityList = $em->findAll('member');

foreach ($entityList as $member) {

    echo $member->getId();
    echo $member->getProperty('Name');
    var_dump($member->getProperties());
    // etc.
}
```


## The QueryBuilder

The QueryBuilder components allows to find entities using complex search queries.
It is highly recommended to use an IDE with code autocompletion for easy usage.


### Example 1: find member by name ###

```php
$qb = new QueryBuilder();
$query = $qb->where('Firstname')->isEqualTo('Max')->andWhere('Lastname')->isEqualTo('Muster')->build();
```

> Result: `Firstname = "Max" AND Lastname = "Muster"`


### Example 2: find member by complex conditions

```php
$qb = new QueryBuilder();

$query = $qb
    ->group(
        $qb->where('Firstname')->isEqualTo('Max')->andWhere('Lastname')->isEqualTo('Muster')
    )
    ->orGroup(
        $qb->where('Firstname')->isEqualTo('Muster')->andWhere('Lastname')->isEqualTo('Max')
    )
    ->build()
;
```

> Result: '(Firstname = "Max" AND Lastname = "Muster") OR (Lastname = "Max" AND "Firstname" = "Muster")'
