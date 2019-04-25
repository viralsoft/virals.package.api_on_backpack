<?php

namespace ViralsBackpack\BackPackAPI\Http\Controllers\Operations;

trait DeleteOperation
{
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return string
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        $this->crud->setOperation('delete');

        // check exist item
        if (!get_class($this->crud->model)::find($id)) {
            $this->crud->setMessage(trans('virals_backpack_api.item_not_found'));
            $this->crud->setStatus(404);
            return $this->crud->getUpdateResponse(null);
        }
        // get the info for that entry
        $this->crud->delete($id);

        //return response
        $this->crud->setMessage(trans('virals_backpack_api.delete_success', ['name' => $this->crud->entity_name]));
        $this->crud->setStatus(200);

        if ($this->crud->getDeleteReturnList()) {
            return $this->crud->getListResponse();
        }
        return $this->crud->getShowResponse(null);
    }
}
