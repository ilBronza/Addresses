<?php

namespace IlBronza\Addresses\Providers\DatatablesFields\Address;

class DatatableFieldFullStreet extends DatatableFieldBaseAddressField
{
	public $property = 'street_string';
	public ? string $forcedStandardName = 'street_string';
}