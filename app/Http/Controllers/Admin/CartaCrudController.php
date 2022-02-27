<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CartaRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CartaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CartaCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Carta::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/carta');
        CRUD::setEntityNameStrings('carta', 'cartas');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('nombre');
        CRUD::column('descripcion');
        CRUD::column('Colecciones');
        
        $imagen = [
            'name' => 'Image', // The db column name
            'label' => "Imagen", // Table column heading
            'type' => 'image',
            'height' => '250px',
            'width' => '180px',
            'prefix' => 'storage/',
      
            // OPTIONALS
            // 'prefix' => 'folder/subfolder/',
            // image from a different disk (like s3 bucket)
            // 'disk' => 'disk-name', 
      
            // optional width/height if 25px is not ok with you
            // 'height' => '30px',
            // 'width' => '30px',
          ];

        CRUD::addColumn($imagen);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CartaRequest::class);

        //CRUD::field('id');
        CRUD::field('nombre');
        CRUD::field('descripcion');

        $coleccion = [ // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Colecciones",
            'type' => 'select_multiple',
            'name' => 'colecciones', // the method that defines the relationship in your Model
            'entity' => 'colecciones', // the method that defines the relationship in your Model
            'attribute' => 'nombre', // foreign key attribute that is shown to user
            'model' => "App\Models\Coleccion", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ];

        $uploadField = [ // Upload
                'name'      => 'Image',
                'label'     => 'Image',
                'type'      => 'upload',
                'upload'    => true,
                //'disk'      => 'uploads', // if you store files in the /public folder, please omit this; if you store them in /storage or S3, please specify it;
                // optional:
                'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified        
        ];

        CRUD::addField($coleccion);
        CRUD::addField($uploadField);

        /*CRUD::field('created_at');
        CRUD::field('updated_at');*/

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
