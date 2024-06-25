<?php

namespace IlBronza\Addresses\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class AddressesCreateStoreFieldsetsParametersFile extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'package' => [
                'translationPrefix' => 'addresses::fields',
                'fields' => [
                    'type' => ['text' => 'string|nullable|max:255'],
                    'street' => ['text' => 'string|nullable|max:255'],
                    'number' => ['text' => 'string|nullable|max:255'],
                    'zip' => ['text' => 'string|nullable|max:255'],
                    'town' => ['text' => 'string|nullable|max:255'],
                    'city' => ['text' => 'string|nullable|max:255'],
                    'province' => ['text' => 'string|nullable|max:255'],
                    'region' => ['text' => 'string|nullable|max:255'],
                    'state' => ['text' => 'string|nullable|max:255'],
                    'latitude' => ['text' => 'string|nullable|max:255'],
                    'longitude' => ['text' => 'string|nullable|max:255'],
                ],
                'width' => ["1-3@l", '1-2@m']
            ]
        ];
    }
}



