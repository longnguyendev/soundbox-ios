<?php

namespace App\Http\Controllers;

use App\Http\Resources\SongResourceEedit;
use App\Http\Resources\SongResource;
use App\Models\Category;
use App\Models\Singer;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $songs = Song::all();
        return SongResource::collection($songs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'required',
            'singer_id' => 'required',
        ]);
        $file = $request->file('file');
        $fileName = $this->convert_name(preg_replace('!\s+!', ' ', trim($request->name))) . "-" . time() .  '.' . $file->getClientOriginalExtension();
        $pathSong =  $file->storeAs(
            'public/filePaths',
            $fileName
        );
        $song = new Song;
        $song->name = preg_replace('!\s+!', ' ', $request->name);
        $song->file_path = basename($pathSong);
        $song->singer_id = $request->singer_id;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . $thumbnail->getClientOriginalName();
            $pathThumbnail = $thumbnail->storeAs(
                'public/thumbnails',
                $thumbnailName
            );
            $song->thumbnail = basename($pathThumbnail);
        }
        if ($song->save()) {
            return response(['message' => 'add success'], 201);
        } else {
            return response(['message' => 'add fail'], 203);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $song = Song::find($id);
        if (!$song) return response(['message' => 'Song not found'], 404);
        $song->listens += 1;
        $song->save();
        return response(new SongResource($song));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $song = Song::find($id);
        if (!$song) return response(['message' => 'Song not found'], 404);
        return response(new SongResource($song));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */

    public function search($q = "")
    {
        if ($q == "") return response([]);
        $songs = DB::table('songs')->join('singers', 'songs.singer_id', '=', 'singers.id')->where('songs.name', 'LIKE', '%' . $q . '%')->orwhere('singers.name', 'LIKE', '%' . $q . '%')->select('songs.id', 'songs.name', 'songs.file_path', 'songs.thumbnail', 'songs.listens', 'singers.name as singer')->get();
        return response(["data" => $songs]);
    }

    public function searchByIds(Request $request)
    {
        $ids   = json_decode($request->ids);
        if (!$ids) {
            return response(["data" => []]);
        }
        $songs = Song::findMany($ids);
        return SongResource::collection($songs);
    }
    public function getReccommedSongs()
    {
        $songs = Song::limit(20)->orderBy('listens', 'DESC')->get();
        return SongResource::collection($songs);
    }
    public function getRecentlySongs(Request $request)
    {
        $ids   = json_decode($request->ids);
        if (!$ids) {
            return response(["data" => []]);
        }
        $songs = Song::whereIn('id', $ids)
            ->orderByRaw("FIELD(id, " . implode(",", $ids) . ")")
            ->get();
        return SongResource::collection($songs);
    }
    public function getNextSong()
    {
        $song = Song::inRandomOrder()->first();
        return new SongResource($song);
    }
    function convert_name($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        $str = preg_replace("/(  )/", " ", $str);
        $str = preg_replace("/( )/", "-", $str);
        return $str;
    }
}
