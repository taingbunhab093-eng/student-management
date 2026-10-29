<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::create([
            'dept_name' => 'Management Information System',
            'manager_id' => 1,
            'location_id' => 101,
        ]);

        Department::create([
            'dept_name' => 'Design',
            'manager_id' => 2,
            'location_id' => 102,
        ]);

        Department::create([
            'dept_name' => 'Computer Science',
            'manager_id' => 3,
            'location_id' => 103,
        ]);
    }
}