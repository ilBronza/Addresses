<?php

namespace IlBronza\Addresses\Providers\DatatablesFields\Coordinates;

use IlBronza\Datatables\Datatables;

class DatatableFieldLongitude extends DatatableFieldCoordinatesField
{
	public function transformValue($value)
	{
		return $value->getLongitude();
	}	
}


