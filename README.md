# Slug plugin for CakePHP 3.x

Plugin CakePHP to generate friendly URLs. Based on the database allows you to generate simple URL for any data model:<br/>
Product Link: http://domain.com/slugged-product-name</br>
Category Link: http://domain.com/slugged-category-name

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require sylwesterkowal/plugin.cakephp-slug
```

## Install Table

```
cake Migrations migrate -p Slug
```

## Configurations

Configuring the plugin is to add the relationship between table Slug and tables in which to use the generated URL slug.

### ModelTable

For example in plugin "Product" for table "ProductsTable.php" add

```
    public function initialize(array $config)
    {

        ...
        ...

        $this->hasOne('Slug.Slugs', [
            'className' => 'Slugs',
            'foreignKey' => 'pass',
            'conditions' => [
                'plugin' => 'Product',  // Set plugin name
                'controller' => 'Products', // Set controller name
                'action' => 'view'  // Set action name
            ]
        ]);


        $this->addBehavior('Slug.Sluggable', [
            'field' => 'name', // enter the field, which will be generated slug
            'plugin' => 'Product', // set plugin name
            'controller' => 'Products', // set controller name
            'action' => 'view', // set action name
            'pass' => 'id',  // set the field, which will by ID Key
        ]);

    }
```

### Routes configuration

```
    $routes->connect(
        '/:slug',
        [],
        ['routeClass' => 'Slug.SlugRoute']
    );
```

### Controller

```
public $helpers = ['Slug.Slug'];
```

### View

```
<?php
echo $this->Slug->link($productEntity, $productEntity->name,
[
    'controller'=>'Products',
    'action'=>'view',
    $productEntity->id,
    'plugin'=>'Product'
]);
?>
```
