<?php

namespace IlBronza\Addresses\Http\Controllers\Address;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class AddressDestroyController extends AddressCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($address)
    {
        $address = $this->findModel($address);

        return $this->_destroy($address);
    }
}