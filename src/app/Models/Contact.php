<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'last_name',
        'first_name',
        'gender',
        'email',
        'tel1',
        'tel2',
        'tel3',
        'address',
        'building',
        'category_id',
        'detail',
    ];

    public function scopeFilterName($query, ?string $name, bool $exact = false)
    {
        if ($name===null||$name==='')return $query;
        return $query->where(function ($qquery) use ($name, $exact) {
            if ($exact) {
                $qquery->where('last_name', $name)
                ->orWhere('first_name', $name)
                ->orWhereRaw("CONCAT(last_name, ' ', first_name) = ?", [$name])
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) = ?", [$name]);
            } else {
                $like="%{$name}%";
                $qquery->where('last_name', 'like', $like)
                      ->orWhere('first_name', 'like', $like)
                      ->orWhereRaw("CONCAT(last_name, ' ', first_name) like ?", [$like])
                      ->orWhereRaw("CONCAT(last_name, first_name) like ?", [$like]);
            }
        });
    }

    public function scopeFilterEmail($query, ?string $email, bool $exact = false)
    {
        if ($email===null||$email==='')return $query;
        if ($exact) {
            return $query->where('email', $email);
        } else {
            return $query->where('email', 'like', "%{$email}%");
        }
    }
    public function scopeFilterGender($query, ?string $gender)
    {
        if ($gender===null||$gender==='')return $query;
        return $query->where('gender', $gender);
    }

    public function scopeFilterCategory($query, ?int $category_id)
    {
        if ($category_id===null||$category_id==='')return $query;
        return $query->where('category_id', $category_id);
    }

    public function scopeFilterDate($query, ?string $date)
    {
        if (!$date) return $query;
        return $query->whereDate('created_at', $date);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
