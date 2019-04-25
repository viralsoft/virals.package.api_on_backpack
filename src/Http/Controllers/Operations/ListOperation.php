<?php

namespace ViralsBackpack\BackPackAPI\Http\Controllers\Operations;

use phpDocumentor\Reflection\Types\Integer;

trait ListOperation
{
    /**
     * Display all rows in the database for this entity.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->crud->hasAccessOrFail('list');
        $this->crud->setOperation('list');

        //set num perpage list
        if ($this->request->has('numPerPage')) {
            $this->crud->setNumEntriesPerPage((int)$this->request->numPerPage);
        }

        //set page list
        if ($this->request->has('page')) {
            $this->crud->setListPage((int)$this->request->page);
        }
        //return response
        $this->crud->setMessage(trans('virals_backpack_api.get_list_success', ['name' => $this->crud->entity_name]));
        $this->crud->setStatus(200);

        return $this->crud->getListResponse();
    }

    /**
     * The search function that is called by the data table.
     *
     * @return array JSON Array of cells in HTML form.
     */
    public function search()
    {
        $this->crud->hasAccessOrFail('list');
        $this->crud->setOperation('list');

        $totalRows = $this->crud->model->count();
        $filteredRows = $this->crud->count();
        $startIndex = $this->request->input('start') ?: 0;
        // if a search term was present
        if ($this->request->input('search') && $this->request->input('search')['value']) {
            // filter the results accordingly
            $this->crud->applySearchTerm($this->request->input('search')['value']);
            // recalculate the number of filtered rows
            $filteredRows = $this->crud->count();
        }
        // start the results according to the datatables pagination
        if ($this->request->input('start')) {
            $this->crud->skip($this->request->input('start'));
        }
        // limit the number of results according to the datatables pagination
        if ($this->request->input('length')) {
            $this->crud->take($this->request->input('length'));
        }
        // overwrite any order set in the setup() method with the datatables order
        if ($this->request->input('order')) {
            $column_number = $this->request->input('order')[0]['column'];
            $column_direction = $this->request->input('order')[0]['dir'];
            $column = $this->crud->findColumnById($column_number);
            if ($column['tableColumn']) {
                // clear any past orderBy rules
                $this->crud->query->getQuery()->orders = null;
                // apply the current orderBy rules
                $this->crud->query->orderBy($column['name'], $column_direction);
            }

            // check for custom order logic in the column definition
            if (isset($column['orderLogic'])) {
                $this->crud->customOrderBy($column, $column_direction);
            }
        }
        $entries = $this->crud->getEntries();
        return $this->crud->getShowResponse($entries, true);

    }
}
