<?php

namespace IlBronza\Addresses\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GoogleAddress extends BaseModel
{
	use PackagedModelsTrait;

	/**
	 * Prefisso per la configurazione del pacchetto.
	 *
	 * @var string
	 */
	static $packageConfigPrefix = 'addresses';

	/**
	 * Prefisso per la configurazione del modello.
	 *
	 * @var string
	 */
	static $modelConfigPrefix = 'googleAddress';

	/**
	 * Relazioni da eliminare durante la cancellazione.
	 *
	 * @var array
	 */
	static $deletingRelationships = [];

	/**
	 * Tipo di chiave primaria.
	 *
	 * @var string
	 */
	protected $keyType = 'string';
}