<?php

namespace ViralsBackpack\BackPackAPI\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class CrudBackpackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack:crud-api {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CRUD Api interface: Controller, Route';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = ucfirst($this->argument('name'));

        // Create the CRUD Controller and show output
        Artisan::call('backpack:crud-api-controller', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Route
        Artisan::call('backpack-api:add-custom-route', ['code' => "BackPackAPI::resource('" . lcfirst($name) ."', '" . $name . "CrudAPIController');"]);
        echo Artisan::output();
    }
}
