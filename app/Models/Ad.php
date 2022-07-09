<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ad
 *
 * @property int $id
 * @property int $category_id
 * @property int $isCompany
 * @property int $sender
 * @property int $receiver
 * @property string $description
 * @property int $max_budget
 * @property int $min_budget
 * @property string|null $photo
 * @property int $ViewCount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereIsCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereMaxBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereMinBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $title
 * @property-read \App\Models\Company|null $Receiver
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Request[] $Requests
 * @property-read int|null $requests_count
 * @property-read \App\Models\User|null $Sender
 * @property-read \App\Models\Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereTitle($value)
 * @property int $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereIsActive($value)
 */
class Ad extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title', 'sender', 'receiver', 'isCompany', 'description', 'category_id', 'max_budget', 'min_budget', 'is_active',
        'photo', 'ViewCount'
    ];

    protected $attributes=[
        'ViewCount'=> 0
    ];
	public function category(){
		return $this->hasOne(Category::class, 'id', 'category_id');
	}
	public function Sender(){
        return $this->hasOne(User::class, 'id', 'sender');
	}
	public function Receiver(){
		return $this->hasOne(Company::class, 'id', 'receiver');
	}
	public function Requests(){
		return $this->hasMany(Request::class, 'ad_id', 'id');
	}

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
