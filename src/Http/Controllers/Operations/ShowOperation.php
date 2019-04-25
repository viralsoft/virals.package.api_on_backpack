<?php

namespace ViralsBackpack\BackPackAPI\Http\Controllers\Operations;

trait ShowOperation
{
    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $this->crud->allowAccess('show');
        $this->crud->setOperation('show');

        // check exist item
        if (!get_class($this->crud->model)::find($id)) {
            $this->crud->setMessage(trans('virals_backpack_api.item_not_found'));
            $this->crud->setStatus(404);
            return $this->crud->getUpdateResponse(null);
        }

        // get the info for that entry
        $item = $this->data['entry'] = $this->crud->getEntry($id);

        //return response
        $this->crud->setMessage(trans('virals_backpack_api.get_detail_success', ['name' => $this->crud->entity_name]));
        $this->crud->setStatus(200);

        return $this->crud->getShowResponse($item);
    }
}
