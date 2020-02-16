Kid module for Evolun
=======

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist polgarz/evolun-kid "@dev"
```

or add

```
"polgarz/evolun-kid": "@dev"
```

to the require section of your `composer.json` file.

Migration
-----
```
php yii migrate/up --migrationPath=@vendor/polgarz/evolun-kid/migrations
```

Configuration
-----

```php
'modules' => [
    'kid' => [
        'class' => 'evolun\kid\Module',
        'modules' => [
            'gallery' => [
                'class' => 'evolun\kid\modules\gallery\Module',
            ],
            'documents' => [
                'class' => 'evolun\kid\modules\documents\Module',
            ],
            'notes' => [
                'class' => 'evolun\kid\modules\notes\Module',
            ],
        ]
    ],
],
```

Available submodules (tabs)
-----
- Gallery
- Documents
- Notes
