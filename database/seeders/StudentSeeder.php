<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'student_name' => 'Rous Darasy',
            'email' => 'rousdarasy@gmail.com',
            'gender' => 'Male',
            'enrollment_date' => '2024-01-01',
            'dept_id' => 1,
            'description' => null,
        ]);

        Student::create([
            'student_name' => 'Chan Sinoun',
            'email' => 'Chansinoun@gmail.com',
            'gender' => 'Female',
            'enrollment_date' => '2024-01-01',
            'dept_id' => 2,
            'description' => null,
        ]);

        Student::create([
            'student_name' => 'Thim Sitha',
            'email' => 'thimsitha@gmail.com',
            'gender' => 'Female',
            'enrollment_date' => '2024-01-02',
            'dept_id' => 1,
            'description' => 'OK',
        ]);

        Student::create([
            'student_name' => 'Leng Makara',
            'email' => 'lengmakara@gmail.com',
            'gender' => 'Male',
            'enrollment_date' => '2024-01-03',
            'dept_id' => 2,
            'description' => null,
        ]);
    }
}