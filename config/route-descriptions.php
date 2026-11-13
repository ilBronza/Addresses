<?php

$prefix = (string) config('addresses.routePrefix');

return [
    $prefix . 'coordinates.calculateMissing' => 'Calcola e salva le coordinate mancanti per un massimo di 300 indirizzi.',
    $prefix . 'addresses.index' => 'Mostra l’elenco degli indirizzi.',
    $prefix . 'addresses.create' => 'Mostra il modulo per creare un indirizzo.',
    $prefix . 'addresses.store' => 'Salva un nuovo indirizzo.',
    $prefix . 'addresses.show' => 'Mostra i dettagli dell’indirizzo.',
    $prefix . 'addresses.edit' => 'Mostra il modulo di modifica dell’indirizzo.',
    $prefix . 'addresses.update' => 'Salva le modifiche dell’indirizzo.',
    $prefix . 'addresses.destroy' => 'Elimina un indirizzo.',
];
