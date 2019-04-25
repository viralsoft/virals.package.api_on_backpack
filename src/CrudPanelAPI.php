<?php

namespace ViralsBackpack\BackPackAPI;

use Backpack\CRUD\CrudPanel;
use ViralsBackpack\BackPackAPI\PanelTraits\Resources;


class CrudPanelAPI extends CrudPanel
{
    use Resources;

    public $dataAPIs = []; // Define the data for the response;
}