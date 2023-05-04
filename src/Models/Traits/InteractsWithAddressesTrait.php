<?php

namespace IlBronza\Addresses\Models\Traits;

use IlBronza\Addresses\Models\Address;

trait InteractsWithAddressesTrait
{
	abstract function getAddressModelClassName() : string;

	public function addresses()
	{
		return $this->morphMany(
			$this->getAddressModelClassName(),
			'addressable'
		);
	}

	public function address(string $type = null)
	{
		if(! $type)
			$type = config('addresses.default_type');

		return $this->morphOne(
			$this->getAddressModelClassName(),
			'addressable'
		)->where('type', $type);
	}

	public function scopeByTypes($query, array $type)
	{
		return $query->whereIn('type', $type);
	}

	public function addAddress(Address $address)
	{
		$this->addresses()->save($address);
	}

	public function removeAddress(Address $address)
	{
		$address->delete();
	}


}