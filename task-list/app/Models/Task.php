<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','long_description'];

    public function toggleComplte()
    {
        $this->completed = !$this->completed;
        $this->save();
    }
}
