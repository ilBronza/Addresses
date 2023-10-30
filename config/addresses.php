<?php

use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\City;
use IlBronza\Addresses\Models\Province;

return [
	'default_type' => 'default',

	'models' => [
		'address' => [
			'class' => Address::class,
			'table' => 'addresses'
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