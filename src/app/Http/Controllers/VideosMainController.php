<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Video;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

use App\Jobs\ProcessVideoConversion;

use Illuminate\Support\Facades\Storage as Storage;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Log;

class VideosMainController extends Controller
{
    /**
     * Landing page with videos listing
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $data = [];

        $data['videos'] = Video::converted()->get();

        return view('video.index', $data);
    }    


    /**
     * Video upload form
     *
     * @param Request $request
     * @return void
     */
    public function createVideo(Request $request)
    {
        return view('video.upload');
    }     

    /**
     * Video upload handling and further pocessing
     *
     * @param Request $request
     * @return void
     */
    public function uploadVideo(Request $request)
    {
        $validator = $this->validate($request, [
            'title' => 'required|string|max:150',
            'description' => 'string|max:500',
            'video' => 'required|file|mimetypes:video/mp4',
        ]);

        $video = new Video;
        $video->title = $request->title;

        if ($request->hasFile('video'))
        {
            $videoFile = $request->file('video');

            $path = $videoFile->store('public');

            $video->video_path = $path;

            $video->visibility = Video::VISIBILITY_PUBLIC;
            $video->state = Video::STATE_DEFAULT;
            $video->status = Video::STATUS_DRAFT;

            $video->user_id = Auth::id();

            $video->meta_data = collect([
                'originalName' => $videoFile->getClientOriginalName(),
                'ext' => $videoFile->extension(),
                'mimeType' => $videoFile->getClientMimeType(),
                'fileSize' => $videoFile->getSize()
            ])->toJson();
        }

        $video->save();  

        // Dispatching the job to the queue, 
        // so format conversion work will be processed asynchronously
        ProcessVideoConversion::dispatch($video);

        return redirect('/');
   }
}
