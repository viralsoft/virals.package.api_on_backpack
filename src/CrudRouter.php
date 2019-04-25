<?php

namespace ViralsBackpack\BackPackAPI;

use Route;

class CrudRouter
{
    protected $extraRoutes = [];

    protected $name = null;
    protected $options = null;
    protected $controller = null;

    public function __construct($name, $controller, $options)
    {
        $this->name = $name;
        $this->controller = $controller;
        $this->options = $options;

        // CRUD routes for core features
        Route::post($this->name.'/search', [
            'as' => 'crud-api.'.$this->name.'.search',
            'uses' => $this->controller.'@search',
        ]);
    }

    /**
     * The CRUD resource needs to be registered after all the other routes.
     */
    public function __destruct()
    {
        $options_with_default_route_names = array_merge([
            'names' => [
                'index'     => 'crud-api.'.$this->name.'.index',
                'create'    => 'crud-api.'.$this->name.'.create',
                'store'     => 'crud-api.'.$this->name.'.store',
                'edit'      => 'crud-api.'.$this->name.'.edit',
                'update'    => 'crud-api.'.$this->name.'.update',
                'show'      => 'crud-api.'.$this->name.'.show',
                'destroy'   => 'crud-api.'.$this->name.'.destroy',
            ],
        ], $this->options);

        Route::resource($this->name, $this->controller, $options_with_default_route_names);
    }

    /**
     * Call other methods in this class, that register extra routes.
     *
     * @param  [type] $injectables [description]
     * @return [type]              [description]
     */
    public function with($injectables)
    {
        if (is_string($injectables)) {
            $this->extraRoutes[] = 'with'.ucwords($injectables);
        } elseif (is_array($injectables)) {
            foreach ($injectables as $injectable) {
                $this->extraRoutes[] = 'with'.ucwords($injectable);
            }
        } else {
            $reflection = new \ReflectionFunction($injectables);

            if ($reflection->isClosure()) {
                $this->extraRoutes[] = $injectables;
            }
        }

        return $this->registerExtraRoutes();
    }

    /**
     * TODO
     * Give developers the ability to unregister a route.
     */
    // public function without($injectables) {}

    /**
     * Register the routes that were passed using the "with" syntax.
     */
    private function registerExtraRoutes()
    {
        foreach ($this->extraRoutes as $route) {
            if (is_string($route)) {
                $this->{$route}();
            } else {
                $route();
            }
        }
    }

    public function __call($method, $parameters = null)
    {
        if (method_exists($this, $method)) {
            $this->{$method}($parameters);
        }
    }
}
