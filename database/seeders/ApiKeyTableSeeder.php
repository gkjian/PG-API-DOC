<?php

namespace Database\Seeders;
use App\Models\ApiKey;
use Illuminate\Database\Seeder;

class ApiKeyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ApiKey = [
            [
                'id'          => 1,
                'api_key'     => '96w8c7ddwqczv88f',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 1,
            ],
            [
                'id'          => 2,
                'api_key'     => 'vme4rzrm5zmv4py796w8c7ddwqczv88f',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 1,
            ],
            [
                'id'          => 3,
                'api_key'     => '1Y760jjRupWCbf2Q',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 2,
            ],
            [
                'id'          => 4,
                'api_key'     => 'U6cvkayjXdOoMNYOou8006vj7XQFkUXq',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 2,
            ],
            [
                'id'          => 5,
                'api_key'     => 'ONWqgO4hJ2smw9Me',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 3,
            ],
            [
                'id'          => 6,
                'api_key'     => 'VxQ2QxhOOR00rf2DXly5GSpDoPzpS5Tj',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 3,
            ],
            [
                'id'          => 7,
                'api_key'     => 'nRxgaPfSp8mpJytn',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 4,
            ],
            [
                'id'          => 8,
                'api_key'     => 'KLV4qZS76bbCEZjgTMzGyqO8VtOFzGjQ',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 4,
            ],
            [
                'id'          => 9,
                'api_key'     => 'pC7dp9QrJbjveFMw',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 5,
            ],
            [
                'id'          => 10,
                'api_key'     => 'YUOLQyWP58TVbYmTelE76CncEO9cAKB7',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 5,
            ],
            [
                'id'          => 11,
                'api_key'     => 'wmyLBRxsEObd1QIB',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 6,
            ],
            [
                'id'          => 12,
                'api_key'     => 'rBnQOqCYGuu3J15aTrkMI9BgpgR2iYXA',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 6,
            ],
            [
                'id'          => 13,
                'api_key'     => 'KDpwT9KklYChIj9V',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 7,
            ],
            [
                'id'          => 14,
                'api_key'     => '0Pl8g9E0adWELqdAlhoZX2CnOXviU45N',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 7,
            ],
            [
                'id'          => 15,
                'api_key'     => 'INYMmxmF3RC5x6VT',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 8,
            ],
            [
                'id'          => 16,
                'api_key'     => '2jPUCZkkFlGFvDIbrW6COA83pyaZAbfw',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 8,
            ],
            [
                'id'          => 17,
                'api_key'     => 'EOeiUbud2GE0npt1',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 9,
            ],
            [
                'id'          => 18,
                'api_key'     => 'ZclGR9qdcu8N5aFF4QS1AuZ6mzEVdt8Y',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 9,
            ],
            [
                'id'          => 19,
                'api_key'     => 'u64QSdIJnJqe3z2t',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 10,
            ],
            [
                'id'          => 20,
                'api_key'     => 'vZHkgu6eyjJuXxZpUclO8TOd8qDVR7R2',
                'created_at'  => now(),
                'updated_at'  => now(),
                'deleted_at'  => null,
                'gate_id'     => 10,
            ],
        ];

        ApiKey::insert($ApiKey);
    }
}
