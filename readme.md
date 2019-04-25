# BackPackAPI

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Quickly build an api interface for your Eloquent models, using Laravel 5. Erect a complete CMS at 10 minutes/model, max. 

Features:
- Crud and search call api
- Back-end validation using Requests
- Easily overwrite functionality (customising how the create/update/delete process works is as easy as creating a new function with the proper name in your EntityCrudAPICrontroller)
## Installation

``` bash
composer require viralsbackpack/backpackapi
```

## Setup

**1. Command**

*_Create controller:* 

```bash
php artisan backpack:crud-api-controller Name

```
This command will create NameAPICrudController in folder app/Http/Api. Controller api must extends ViralsBackpack\BackPackAPI\Http\Controllers\CrudAPIController;

*_Add route for api:*

```bash

php artisan backpack-api:add-custom-route "BackPackAPI::resource('name', 'NameCrudAPIController');"

```
This command will add route api route resource in routes/backpack/api.php

**2. Setup api**

All the settings below can be added to any method in the controller.

*_Add validate request:*
```php
<?php

$this->setRequestStoreApi(StoreRequest::class);
$this->setRequestUpdateApi(UpdateRequest::class);

```

*_Setup structure data in response*
```php
<?php

// Set up structure of data in response
$this->crud->setResponse([
    'id', 'name'  //fields of its model
]);
```
or custom fields
```php
<?php

$this->crud->setResponse([
    'name' => function($entry) {
        return $entry->name . '123';
    },
    'id' => function($entry) {
        return $entry->id . '123';
    }
]);

```
Output:
![alt text](https://raw.githubusercontent.com/viralsoft/virals.package.import_excel/master/export.png)

*_Set up extra data*
```php
<?php

$this->crud->setExtraData([
    'test' => 123
]);

```
Output:
![alt text](https://raw.githubusercontent.com/viralsoft/virals.package.import_excel/master/export.png)

*_Set up return list entries after delete:*
```php
<?php

$this->crud->setDeleteReturnList(true);

```
*_Set message:*
```php
<?php

$this->crud->setMessage('message');

```
*_Set status:*
```php
<?php

$this->crud->setStatus('message');

```

## Usage
| Method    | URI             | Name               | Action                                                | Parameter obligatory  |Form data obligatory    |
| --------- | --------------- |------------------- |------------------------------------------------------ |--------------------   |------------------------|
| GET/HEAD  | api/name        |crud-api.name.index | App\Http\Controllers\Api\NameCrudAPIController@index  |                       |                        |
| POST      | api/name        |crud-api.name.store | App\Http\Controllers\Api\NameCrudAPIController@store  | id                    |                        |
| POST      | api/name/search |crud-api.name.search| App\Http\Controllers\Api\TagCrudAPIController@search  | search[value]         |                        |
| GET/HEAD  | api/tag/{id}    |crud-api.name.show  | App\Http\Controllers\Api\NameCrudAPIController@show   | id                    |                        |
| PUT/PATCH | api/tag/{id}    |crud-api.tag.update | App\Http\Controllers\Api\NameCrudAPIController@update | id                    | _method = PUT ; id     |                    
| DELETE    | api/tag/{id}    |crud-api.tag.destroy| App\Http\Controllers\Api\NameCrudAPIController@destroy| id                    | _method = DELETE       |

## Credits

- [author name][manhhd@viralsoft.vn]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/viralsbackpack/backpackapi.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/viralsbackpack/backpackapi.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/viralsbackpack/backpackapi/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/viralsbackpack/backpackapi
[link-downloads]: https://packagist.org/packages/viralsbackpack/backpackapi
[link-travis]: https://travis-ci.org/viralsbackpack/backpackapi
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/viralsbackpack
[link-contributors]: ../../contributors
