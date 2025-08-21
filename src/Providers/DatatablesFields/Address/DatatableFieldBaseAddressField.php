<?php

namespace IlBronza\Addresses\Providers\DatatablesFields\Address;

use IlBronza\Datatables\DatatablesFields\DatatableFieldProperty;

class DatatableFieldBaseAddressField extends DatatableFieldProperty
{
	public ? string $translationPrefix = 'addresses::fields';
}