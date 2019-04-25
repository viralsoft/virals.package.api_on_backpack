<?php

namespace ViralsBackpack\BackPackAPI\Http\Controllers\Operations;

use Illuminate\Http\Request as UpdateRequest;

trait UpdateOperation
{
    public function updateCrud(UpdateRequest $request = null)
    {
        $this->crud->hasAccessOrFail('update');
        $this->crud->setOperation('update');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // check exist item
        if (!get_class($this->crud->model)::find($request->get($this->crud->model->getKeyName()))) {
            $this->crud->setMessage(trans('virals_backpack_api.item_not_found'));
            $this->crud->setStatus(404);
            return $this->crud->getUpdateResponse(null);
        }

        // update the row in the db
        // request must have id
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()), $request->all());
        $this->data['entry'] = $this->crud->entry = $item;

        //return response
        $this->crud->setMessage(trans('virals_backpack_api.update_success', ['name' => $this->crud->entity_name]));
        $this->crud->setStatus(200);

        return $this->crud->getUpdateResponse($item);
    }
}
