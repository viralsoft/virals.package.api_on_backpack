<?php
Route::group([
    'prefix'     => config('backpack.base.route_prefix_api', 'api'),
    'namespace'  => 'App\Http\Controllers\Api',
], function () { // custom admin routes
}); // this should be the absolute last line of this file