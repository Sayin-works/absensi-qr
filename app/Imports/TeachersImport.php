<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TeachersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        if (empty($row['name'])) {
            return null;
        }

        $nameSlug = Str::slug($row['name'], '.');
        $email = $nameSlug . '@example.com';

        return new User([
            'name'     => $row['name'],
            'email'    => $email,
            'password' => Hash::make('password'), // default password
            'role'     => 'guru',
            'phone'    => $row['phone'] ?? null,  // opsional
            'subject_id' => null,
            'class_id'   => null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name' => ['required', 'string'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.name.required' => 'Nama guru wajib diisi.',
        ];
    }
}
