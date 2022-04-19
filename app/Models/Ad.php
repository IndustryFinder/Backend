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
 */
class Ad extends Model
{
    use HasFactory;
}
