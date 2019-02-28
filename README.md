# yii2-mongodb

MongoClient exposes official MongoDB support as provided by mongodb.org in the form of a Yii2 component. This component provides a MongoDB\Client object, and as such may be used exactly as documented in
[the official MongoDB referece](https://docs.mongodb.com/php-library/).

The reason behind the existence of this component is that the standard Yii2 component caters to the AR approach, and this shields a lot of the powerful core functionality provided by the MongoDB PHP Library provided by mongodb.org.

This component requires the newer mongodb PHP extension, the old mongo PHP extension is untested and unsupported.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
php composer.phar require joorloohuis/yii2-mongodb
```

or add

```json
"joorloohuis/yii2-mongodb": "^1.0.0"
```

to the require section of your `composer.json` file.

## Configuration

Add the following section to the `components` part of your configuration:

```php
<?php
    'mongoclient' => [
        'class' => \joorloohuis\mongodb\components\MongoClient::class,
        'dsn' => 'mongodb://mongouser:mongopw@localhost:27017/database?args',
        // alternatively, provide separate parameters
        // 'host' => 'localhost',
        // 'port' => 27017,
        // 'user' => 'mongouser',
        // 'password' => 'mongopw',
        // 'db' => 'mongodatabase',
        // 'args' => 'args',
    ];
```

## Usage

The MongoClient can be used for any operations the MongoDB PHP Library supports, for example:

```php
$collection = \Yii::$app->mongoclient->database->selectCollection('mycollection');
$cursor = $collection->aggregate([
    // aggregation pipeline parts go here
]);
$result = $cursor->toArray();
```
