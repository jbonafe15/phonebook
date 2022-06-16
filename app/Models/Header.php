<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;

    protected $table = 'headers';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    // I added fixed value in database headers
    // id name
    // 1  title
    // 2  firstname
    // 3  lastname
    // 4  mobile
    // 5  company
}
