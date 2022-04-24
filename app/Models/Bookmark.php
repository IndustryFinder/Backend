<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bookmark
 *
 * @property int $id
 * @property int $user_id
 * @property int $marked_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereMarkedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Company|null $marked
 * @property-read \App\Models\User|null $user
 */
class Bookmark extends Model
{
    use HasFactory;
	protected $fillable = ['user_id', 'marked_id'];
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	public function marked()
	{
		return $this->belongsTo(Company::class);
	}
}
