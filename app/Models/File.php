<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class File extends Model
{
    use HasFactory;

    /**
     * Get the room that owns the File
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public static function getImageByRoom($id)
    {
        return File::where('room_id', $id)->get();
    }

    public static function store(Request $request)
    {
        $file = new File;

        if ($request->file('file')) {
            $filePath = $request->file('file');
            $fileName = $filePath->getClientOriginalName();
            $path = $request->file('file')->storeAs('uploads', $fileName, 'public');
        }

        $file->name = $fileName;
        $file->path = 'storage/'.$path;
        $file->save();

        return $fileName;
    }

    public static function editRoomId($room_id)
    {
        File::whereNull('room_id')->update([
            'room_id' => $room_id,
        ]);
    }

    public static function destroyByRoom($room_id)
    {
        File::where('room_id', $room_id)->delete();
    }
}
