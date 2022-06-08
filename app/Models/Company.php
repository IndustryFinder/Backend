<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $email
 * @property string $phone
 * @property string $user_id
 * @property string $logo
 * @property string $description
 * @property string $website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereWebsite($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Category|null $Category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Request[] $Requests
 * @property-read int|null $requests_count
 * @property-read \App\Models\User|null $User
 * @property string|null $verification_file
 * @property int $is_verified
 * @property int $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereVerificationFile($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $Comment
 * @property-read int|null $comment_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $Ads
 * @property-read int|null $ads_count
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'phone', 'category_id', 'description', 'email', 'website', 'user_id', 'is_active', 'is_verified', 'verification_file'
        ];
	public function User()
	{
		return $this->belongsTo(User::class);
	}
	public function Category()
	{
		return $this->hasOne(Category::class);
	}
	public function Requests()
	{
		return $this->hasMany(Request::class);
	}
    public function Comment() {
        return $this->hasMany(Comment::class);
    }
    public function Ads()
    {
        return $this->hasMany(Ad::class, 'receiver', 'id');
    }
}
