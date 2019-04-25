<?php
namespace ViralsBackpack\BackPackAPI\Http\Controllers;

use Illuminate\Http\Request;
use ViralsBackpack\BackPackAPI\CrudPanelAPI;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use ViralsBackpack\BackPackAPI\Http\Controllers\Operations\ValidatesRequests;
use ViralsBackpack\BackPackAPI\Http\Controllers\Operations\ListOperation;
use ViralsBackpack\BackPackAPI\Http\Controllers\Operations\ShowOperation;
use ViralsBackpack\BackPackAPI\Http\Controllers\Operations\CreateOperation;
use ViralsBackpack\BackPackAPI\Http\Controllers\Operations\DeleteOperation;
use ViralsBackpack\BackPackAPI\Http\Controllers\Operations\UpdateOperation;
use ViralsBackpack\BackPackAPI\Http\Resources\ModelResourceCollection;
use Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;

class CrudAPIController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    use CreateOperation, CloneOperation, DeleteOperation, ListOperation, ShowOperation, UpdateOperation;

    public $data = [];
    public $request;

    /**
     * @var CrudPanelAPI
     */
    public $crud;

    public function __construct()
    {
        if (! $this->crud) {
            $this->crud = app()->make(CrudPanelAPI::class);

            // call the setup function inside this closure to also have the request there
            // this way, developers can use things stored in session (auth variables, etc)
            $this->middleware(function ($request, $next) {
                $this->request = $request;
                $this->crud->request = $request;
                $this->setup();

                return $next($request);
            });
        }
    }

    /**
     * Allow developers to set their configuration options for a CrudPanel.
     */
    public function setup()
    {
    }
}