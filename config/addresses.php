<?php

use IlBronza\Addresses\Http\Controllers\Address\AddressCreateStoreController;
use IlBronza\Addresses\Http\Controllers\Address\AddressDestroyController;
use IlBronza\Addresses\Http\Controllers\Address\AddressEditUpdateController;
use IlBronza\Addresses\Http\Controllers\Address\AddressIndexController;
use IlBronza\Addresses\Http\Controllers\Address\AddressShowController;
use IlBronza\Addresses\Http\Controllers\Parameters\Datatables\AddressIndexFieldsGroupParametersFile;
use IlBronza\Addresses\Http\Controllers\Parameters\Fieldsets\AddressesCreateStoreFieldsetsParametersFile;
use IlBronza\Addresses\Http\Controllers\Parameters\RelationshipsManagers\AddressRelationManager;
use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\City;
use IlBronza\Addresses\Models\Province;

return [
	'default_type' => 'default',

	'enabled' => false,

	'models' => [
		'address' => [
			'class' => Address::class,
			'table' => 'addresses',
            'fieldsGroupsFiles' => [
                'index' => AddressIndexFieldsGroupParametersFile::class
            ],
            'relationshipsManagerClasses' => [
                'show' => AddressRelationManager::class
            ],
            'parametersFiles' => [
                'create' => AddressesCreateStoreFieldsetsParametersFile::class,
                'show' => AddressesCreateStoreFieldsetsParametersFile::class,
                'edit' => AddressesCreateStoreFieldsetsParametersFile::class,
            ],
            'controllers' => [
                'index' => AddressIndexController::class,
                'create' => AddressCreateStoreController::class,
                'store' => AddressCreateStoreController::class,
                'show' => AddressShowController::class,
                'edit' => AddressEditUpdateController::class,
                'update' => AddressEditUpdateController::class,
                'destroy' => AddressDestroyController::class,
            ]
		],
		'city' => [
			'class' => City::class,
			'table' => 'addresses__cities'
		],
		'province' => [
			'class' => Province::class,
			'table' => 'addresses__provinces'
		],
		'region' => [
			'table' => 'addresses__regions'
		],
	]
];