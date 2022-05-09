<?php

namespace App\Models;

use App\Models\Survey;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'type',
        'is_required',
    ];

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_questions', 'question_id', 'survey_id');
    }
}
