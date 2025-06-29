<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
     use HasFactory;

    // Define the table name (if different from the pluralized model name)
    protected $table = 'selections';

    // Define which fields are mass assignable
    protected $fillable = ['selection', 'date','post_id'];
}
