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

	public function address()
	{
		return $this->morphOne(
			$this->getAddressModelClassName(),
			'addressable'
		)->where('type', config('addresses.default_type'));
	}

	public function createDefaultAddress() : Address
	{
		$address = Address::getProjectClassName()::make();
		$address->type = config('addresses.default_type');

		$this->addAddress($address);

		return $address;
	}

	public function getAddress(string $type = null) : Address
	{
		if(! $type)
		{
			if($this->address)
				return $this->address;

			return $this->createDefaultAddress();
		}

		if($address = $this->addresses()->where('type', $type)->first())
			return $address;

		return $this->createAddressByType($type);
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