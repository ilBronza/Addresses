<?php

namespace IlBronza\Addresses\Http\Controllers;

use App\Models\Address;
use IlBronza\Addresses\Http\Controllers\CRUDTraits\CRUDAddressParametersTrait;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Traits\CRUDBelongsToManyTrait;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDDestroyTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;


use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\CRUD\Traits\CRUDUpdateEditorTrait;

use Illuminate\Http\Request;

class CrudAddressController extends CRUD
{
    use CRUDAddressParametersTrait;

    use CRUDShowTrait;
    use CRUDEditUpdateTrait;
    use CRUDUpdateEditorTrait;
    use CRUDCreateStoreTrait;

    use CRUDDeleteTrait;
    use CRUDDestroyTrait;

    use CRUDRelationshipTrait;
    use CRUDBelongsToManyTrait;

    /**
     * subject model class full path
     **/
    public $modelClass = Address::class;

    /**
     * http methods allowed. remove non existing methods to get a 403
     **/
    public $allowedMethods = [
        'show',
        'edit',
        'update',
        'create',
        'store',
        'destroy',
        'deleted'
    ];

    /**
     * to override show view use full view name
     **/
    //public $showView = 'products.showPartial';

    // public $guardedEditDBFields = ['id', 'created_at', 'updated_at', 'deleted_at'];
    // public $guardedCreateDBFields = ['id', 'created_at', 'updated_at', 'deleted_at'];
    // public $guardedShowDBFields = ['id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * relations called to be automatically shown on 'show' method
     **/
    //public $showMethodRelationships = ['posts', 'users', 'operations'];

    /**
        protected $relationshipsControllers = [
        'permissions' => '\IlBronza\AccountManager\Http\Controllers\PermissionController'
    ];
    **/


    /**
     * getter method for 'index' method.
     *
     * is declared here to force the developer to rationally choose which elements to be shown
     *
     * @return Collection
     **/
     /*
        public function getIndexElements()
        {
            return Address::all();
        }
    */

    /**
     * parameter that decides which fields to use inside index table
     **/
    //  public $indexFieldsGroups = ['index'];

    /**
     * parameter that decides if create button is available
     **/
    //  public $avoidCreateButton = true;



    /**
     * START base methods declared in extended controller to correctly perform dependency injection
     *
     * these methods are compulsorily needed to execute CRUD base functions
     **/
    public function show(Address $address)
    {
        //$this->addExtraView('top', 'folder.subFolder.viewName', ['some' => $thing]);

        return $this->_show($address);
    }

    public function edit(Address $address)
    {
        return $this->_edit($address);
    }

    public function update(Request $request, Address $address)
    {
        return $this->_update($request, $address);
    }

    public function destroy(Address $address)
    {
        return $this->_destroy($address);
    }

    /**
     * END base methods
     **/





}

