<?php

namespace IlBronza\Addresses\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class AddressIndexFieldsGroupParametersFile extends FieldsGroupParametersFile
{
	static function getFieldsGroup() : array
	{
		return [
            'translationPrefix' => 'addresses::fields',
            'fields' => 
            [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',

                'addressable' => '_fn_getName',

                'type' => 'flat',
                'street' => 'flat',
                'number' => 'flat',
                'zip' => 'flat',
                'town' => 'flat',
                'city' => 'flat',
                'province' => 'flat',
                'region' => 'flat',
                'state' => 'flat',
                'latitude' => 'flat',
                'longitude' => 'flat',

                'mySelfDelete' => 'links.delete'
            ]
        ];
	}
}