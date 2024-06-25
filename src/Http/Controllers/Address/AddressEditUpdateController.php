<?php

namespace IlBronza\Addresses\Http\Controllers\Address;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class AddressEditUpdateController extends AddressCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile() : ? string
    {
        return config('addresses.models.address.parametersFiles.create');
    }

    public function edit(string $address)
    {
        $address = $this->findModel($address);

        return $this->_edit($address);
    }

    public function update(Request $request, $address)
    {
        $address = $this->findModel($address);

        return $this->_update($request, $address);
    }
}
