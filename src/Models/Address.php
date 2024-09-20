<?php

namespace IlBronza\Addresses\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

use function stripos;
use function strlen;

class Address extends BaseModel
{
	use PackagedModelsTrait;
	use CRUDUseUuidTrait;

	static $packageConfigPrefix = 'addresses';
	static $modelConfigPrefix = 'address';
	static $deletingRelationships = [];
	protected $keyType = 'string';

	protected static function boot()
	{
		parent::boot();

		static::creating(function ($model)
		{
			$model->type = config('addresses.default_type');
		});
	}

	public function addressable() : MorphTo
	{
		return $this->morphTo();
	}

	public function isInItaly() : bool
	{
		if ($state = $this->getState())
			return stripos($state, 'ital') !== false;

		$provLength = strlen(Str::slug($this->province));

		return (($provLength > 0) && ($provLength <= 3));
	}

	public function getStreet() : ? string
	{
		return $this->street;
	}

	public function getNumber() : ? string
	{
		return $this->number;
	}

	public function getStreetStringAttribute() : ? string
	{
		return trim("{$this->getStreet()} {$this->getNumber()}");
	}

	public function getState() : ?string
	{
		return $this->state;
	}
}