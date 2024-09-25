<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apexform extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'subject',
        'financial_amount',
        'advanced_amount',
        'description',
        'department_name',
        'faculty_name',
        'faculty_id',
        'requirements',
        'expected_outcome',
        'submitted_by',
        'due_date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'financial_amount' => 'decimal:2',
        'advanced_amount' => 'decimal:2',
        'requirements' => 'array', 
        'due_date' => 'date',
    ];
}

