<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DynamicDatabaseConnection
{
    public function getDynamicConnection($databaseName)
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
