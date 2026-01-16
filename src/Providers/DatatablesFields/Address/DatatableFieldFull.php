<?php

namespace IlBronza\Addresses\Providers\DatatablesFields\Address;

class DatatableFieldFull extends DatatableFieldBaseAddressField
{
	public $property = 'full_string';
	public ? string $forcedStandardName = 'full';
}