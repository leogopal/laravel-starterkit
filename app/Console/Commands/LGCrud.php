<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;
use Artisan;
use Illuminate\Console\Command;

class LGCrud extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'lg:crud {name} {--m|migrate} {--f|field=title}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Create a complete CRUD structure for Laravel 5 Boilerplate Backend';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        // Transform lg:crud command parameter to singular lowercase
        $name = strtolower(Str::snake(Str::singular($this->argument('name'))));

        // Create Model "Name.php"
        $this->model( $name, ucfirst(Str::camel($name)), 'make-model.stub' );

        // Create Attribute Trait "NameAttribute.php"
        $this->attribute( $name, ucfirst(Str::camel($name)) . "Attribute", 'make-attribute.stub' );

        // Create Controller "NameController.php"
        $this->controller( $name, ucfirst(Str::camel($name)) . "Controller", 'make-controller.stub' );

        // Create Repository "NameRepository.php"
        $this->repository( $name, ucfirst(Str::camel($name)) . "Repository", 'make-repository.stub' );

        // Create Validation Request "ManageNameRequest.php"
        // Create Validation Request "StoreNameRequest.php"
        // Create Validation Request "UpdateNameRequest.php"
        $this->request( $name, "Manage" . ucfirst(Str::camel($name)) . "Request", 'make-manage-request.stub' );
        $this->request( $name, "Store"  . ucfirst(Str::camel($name)) . "Request", 'make-store-request.stub' );
        $this->request( $name, "Update" . ucfirst(Str::camel($name)) . "Request", 'make-update-request.stub' );

        // Create Event "Events/Backend/Example/ExampleCreated.php"
        // Create Event "Events/Backend/Example/ExampleUpdated.php"
        // Create Event "Events/Backend/Example/ExampleDeleted.php"
        $this->event( $name, ucfirst(Str::camel($name)) . "Created", 'make-event-created.stub' );
        $this->event( $name, ucfirst(Str::camel($name)) . "Updated", 'make-event-updated.stub' );
        $this->event( $name, ucfirst(Str::camel($name)) . "Deleted", 'make-event-deleted.stub' );

        // Create Listener "Listeners/Backend/Example/ExampleEventListener.php"
        $this->listener( $name, ucfirst(Str::camel($name)) . "EventListener", 'make-listener.stub' );

        // Create Migraton "YYYY_MM_DD_HHMMSS_create_names_table.php"
        $this->migration( $name, date('Y_m_d_His_') . "create_" . Str::plural($name)."_table", 'make-migration.stub' );

        // Create Routes "names.php"
        $this->routes( $name, Str::plural($name), 'make-routes.stub' );

        // Create Breadcrumbs "names.php"
        $this->breadcrumbs( $name, $name, 'make-breadcrumbs.stub' );

        // Create View "name/index.blade.php"
        // Create View "example/create.blade.php"
        // Create View "example/edit.blade.php"
        // Create View "example/show.blade.php"
        // Create View "example/deleted.blade.php"
        // Create View "example/includes/breadcrumb-links.blade.php"
        // Create View "example/includes/header-buttons.blade.php"
        // Create View "example/includes/sidebar-examples.blade.php"
        $this->view( $name, 'index', 'make-views-index.stub' );
        $this->view( $name, 'create', 'make-views-create.stub' );
        $this->view( $name, 'edit', 'make-views-edit.stub' );
        $this->view( $name, 'show', 'make-views-show.stub' );
        $this->view( $name, 'deleted', 'make-views-deleted.stub' );
        $this->view( $name, '/includes/breadcrumb-links', 'make-views-breadcrumb-links.stub' );
        $this->view( $name, '/includes/header-buttons', 'make-views-header-buttons.stub' );
        $this->view( $name, '/includes/sidebar-'. Str::plural($name), 'make-views-sidebar.stub' );
    }

    protected function model($key, $name, $stub)
    {
        $stubParams = [
            'name'              => $name,
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Models',
            'attribute'         => ucfirst(Str::camel($key)) . "Attribute",
            'field'             => $this->option('field'),
            'model'             => ucfirst(Str::camel($key)),
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('Model ' . $stubParams['name'] . Artisan::output());
    }

    protected function event($key, $name, $stub)
    {
        $stubParams = [
            'name'              => $name,
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Events\Backend\\' . ucfirst(Str::camel($key)),
            'event'             => ucfirst(Str::camel($key)),
            'model'             => ucfirst(Str::camel($key)),
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('Event ' . $stubParams['name'] . Artisan::output());
    }

    protected function listener($key, $name, $stub)
    {
        $stubParams = [
            'name'              => $name,
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Listeners\Backend\\' . ucfirst(Str::camel($key)),
            'event'             => ucfirst(Str::camel($key)),
            'field'             => $this->option('field'),
            'model'             => ucfirst(Str::camel($key)),
            'table'             => $key,
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('Listener ' . $stubParams['name'] . Artisan::output());
    }

    protected function attribute($key, $name, $stub)
    {
        $stubParams = [
            'name'              => $name,
            'stub'              => __DIR__ . '/Stubs/' . $stub,
            'namespace'         => '\Models\Traits\Attribute',
            'attribute'         => ucfirst(Str::camel($key)) . "Attribute",
            'route'             => Str::plural($key),
            'label'             => Str::plural($key),
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('Attribute ' . $stubParams['name'] . Artisan::output());
    }

    protected function controller($key, $name, $stub)
    {
        $stubParams = [
            'name'                  => $name,
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\Http\Controllers\Backend',
            'array'                 => Str::camel(Str::plural($key)),
            'controller'            => ucfirst(Str::camel($key)) . "Controller",
            'field'                 => $this->option('field'),
            'label'                 => Str::plural($key),
            'model'                 => ucfirst(Str::camel($key)),
            'repository'            => ucfirst(Str::camel($key)) . "Repository",
            'repositoryVariable'    => $key . "Repository",
            'request'               => ucfirst(Str::camel($key)) . "Request",
            'route'                 => Str::plural($key),
            'variable'              => Str::camel($key),
            'view'                  => $key,
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('Controller ' . $stubParams['name'] . Artisan::output());
    }

    protected function repository($key, $name, $stub)
    {
        $stubParams = [
            'name'                  => $name,
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'field'                 => $this->option('field'),
            'namespace'             => '\Repositories\Backend',
            'model'                 => ucfirst(Str::camel($key)),
            'repository'            => ucfirst(Str::camel($key)) . "Repository",
            'variable'              => $key,
            'label'                 => Str::plural($key),
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('Repository ' . $stubParams['name'] . Artisan::output());
    }

    protected function request($key, $name, $stub)
    {
        $stubParams = [
            'name'                  => $name,
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'field'                 => $this->option('field'),
            'namespace'             => '\Http\Requests\Backend',
            'model'                 => ucfirst(Str::camel($key)),
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('Request ' . $stubParams['name'] . Artisan::output());
    }

    protected function migration($key, $name, $stub)
    {
        $stubParams = [
            'name'                  => $name,
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'field'                 => $this->option('field'),
            'namespace'             => '\..\database\migrations',
            'class'                 => "Create" . ucfirst(Str::plural(Str::camel($key))) . "Table",
            'table'                 => Str::plural($key),
        ];

        // If no migration with name "*create_names_table.php" exists then create it
        if (!glob(database_path() . "/migrations/*create_" . Str::plural($key) . "_table.php")) {
            Artisan::call('lg:stub', $stubParams);
            $this->line('Migration ' . $stubParams['name'] . Artisan::output());
        } else {
            $this->line('A migration file for the table ' . Str::plural($key) . " already exists!\n");
        }

        // If option -m|--migrate is true then migrate the table
        if ($this->option('migrate')) {
            Artisan::call('migrate');
            $this->line('Migrating table ' . $stubParams['name'] . "\n");
        }
    }

    protected function routes($key, $name, $stub)
    {
        $stubParams = [
            'name'                  => $name,
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\..\routes\backend',
            'controller'            => ucfirst(Str::camel($key)) . "Controller",
            'model'                 => ucfirst(Str::camel($key)),
            'route'                 => Str::plural($key),
            'variable'              => $key,
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('Routes ' . $stubParams['name'] . Artisan::output());
    }

    protected function breadcrumbs($key, $name, $stub)
    {
        $stubParams = [
            'name'                  => $name,
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\..\routes\breadcrumbs\backend',
            'route'                 => Str::plural($key),
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('Breadcrumbs ' . $stubParams['name'] . Artisan::output());

        // Include breadcrumb file in backend.php
        $require_breadcrumb = "require __DIR__.'/$name.php';";

        $backend_path = base_path("routes/breadcrumbs/backend/backend.php");

        $breadcrumbs = explode("\n", file_get_contents($backend_path));

        if(!in_array($require_breadcrumb, $breadcrumbs)){
            $myfile = file_put_contents($backend_path, PHP_EOL . $require_breadcrumb, FILE_APPEND | LOCK_EX);
        }
    }

    protected function view($key, $name, $stub)
    {
        $stubParams = [
            'name'                  => $name . ".blade",
            'stub'                  => __DIR__ . '/Stubs/' . $stub,
            'namespace'             => '\..\resources\views\backend' . '\\' . $key,
            'label'                 => Str::plural($key),
            'array'                 => Str::camel(Str::plural($key)),
            'field'                 => $this->option('field'),
            'route'                 => Str::plural($key),
            'variable'              => Str::camel($key),
            'view'                  => $key,
        ];

        Artisan::call('lg:stub', $stubParams);
        $this->line('View ' . $stubParams['name'] . Artisan::output());
    }

}
