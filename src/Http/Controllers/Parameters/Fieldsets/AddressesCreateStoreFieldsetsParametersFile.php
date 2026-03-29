<?php

namespace IlBronza\Addresses\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Addresses\Helpers\Coordinates;
use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class AddressesCreateStoreFieldsetsParametersFile extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        $point = null;
        if ($model = $this->getModel()) {
            $coordinates = Coordinates::createByAddress($model);
            if ($coordinates) {
                $point = [
                    'lat' => $coordinates->getLat(),
                    'lng' => $coordinates->getLong(),
                    'label' => $model->getFullString(),
                ];
            }
        }

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
            ],
            'map' => [
                'translatedLegend' => __('addresses::maps.map'),
                'showLegend' => true,
                'fields' => [],
                'view' => [
                    'name' => 'addresses::maps.point',
                    'parameters' => [
                        'point' => $point,
                        'addressEditUrl' => null,
                        'draggable' => true,
                        'latFieldName' => 'latitude',
                        'lngFieldName' => 'longitude',
                    ]
                ],
                'width' => ['xlarge@m']
            ]
        ];
    }
}



