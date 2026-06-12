<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProgressLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'spk_id',
        'user_id',
        'old_status',
        'new_status',
        'catatan'
    ];

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateStatus(Request $request, $id)
    {
        $spk = Spk::findOrFail($id);

        $oldStatus = $spk->status;

        $spk->update([
            'status' => $request->status
        ]);

        ProgressLog::create([
            'spk_id' => $spk->id,
            'user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'catatan' => $request->catatan
        ]);

        return back()
            ->with('success', 'Status berhasil diupdate');
    }
}