<?php

namespace ViralsBackpack\BackPackAPI\Http\Controllers\Operations;

use Illuminate\Http\Request as StoreRequest;

trait CreateOperation
{
    public function storeCrud(StoreRequest $request = null)
    {
        $this->crud->hasAccessOrFail('create');
        $this->crud->setOperation('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // insert item in the db
        $item = $this->crud->create($request->all());
        $this->crud->entry = $item;

        //return response
        $this->crud->setMessage(trans('virals_backpack_api.create_success', ['name' => $this->crud->entity_name]));
        $this->crud->setStatus(200);

        return $this->crud->getCreateResponse($item);
    }
}
