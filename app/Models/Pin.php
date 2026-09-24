<?php

namespace App\Models;

use Database\Factories\PinFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * One image, by URL, with a one-line note, on one board.
 *
 * @property int $id
 * @property int $board_id
 * @property string $image_url
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['image_url', 'note'])]
class Pin extends Model
{
    /** @use HasFactory<PinFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Board, $this>
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
