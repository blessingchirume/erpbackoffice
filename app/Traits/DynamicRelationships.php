<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

trait DynamicRelationships
{
    public function belongsToDynamic($related, $foreignKey, $ownerKey, $databaseField)
    {

        // Dynamically set the connection for the related model
        $instance = new $related;

        $instance->setConnection($this->getDynamicConnection($databaseField));

        return new BelongsTo(
            $instance->newQuery(),
            $this,
            $foreignKey,
            $ownerKey,
            $instance->getKeyName()
        );
    }

    protected function getDynamicConnection($databaseName)
    {
        // Ensure the database name is passed and not null
        if (!$databaseName) {
            throw new \Exception('Database name is required for dynamic connection.');
        }

        // Set the dynamic connection
        config(['database.connections.dynamic' => array_merge(
            config('database.connections.mysql'), // Base tenant connection
            ['database' => $databaseName]        // Use the tenant's database
        )]);

        // Clear any cached connection for 'dynamic'
        DB::purge('dynamic');

        return 'dynamic'; // Return the connection name
    }
}
