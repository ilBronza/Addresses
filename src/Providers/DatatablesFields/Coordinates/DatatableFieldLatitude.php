<?php

namespace IlBronza\Addresses\Providers\DatatablesFields\Coordinates;

use IlBronza\Addresses\Providers\DatatablesFields\Coordinates\DatatableFieldCoordinatesField;

class DatatableFieldLatitude extends DatatableFieldCoordinatesField
{
	public function transformValue($value)
	{
		return $value->getLatitude();
	}	
}


