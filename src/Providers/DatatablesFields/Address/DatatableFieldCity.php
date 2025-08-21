<?php

namespace IlBronza\Addresses\Providers\DatatablesFields\Address;

class DatatableFieldCity extends DatatableFieldBaseAddressField
{
	public $property = 'city';
	public ? string $forcedStandardName = 'city';
}