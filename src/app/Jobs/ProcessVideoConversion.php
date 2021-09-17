<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Video;

use Illuminate\Support\Facades\Storage as Storage;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Log;

class ProcessVideoConversion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $video;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Job started.');

        try {
            $videoRelPath = $this->video->video_path;

            Log:info(Storage::path($videoRelPath));

            if (Storage::exists($videoRelPath)){
                $this->video->state = Video::STATE_PROCESSING;
                $this->video->save();

                $format = (new X264);
                $fileInfo = pathinfo($this->video->video_path);

                $m3u8FileName = $fileInfo['dirname']."/".$fileInfo['filename'] . '.m3u8';

                FFMpeg::open($videoRelPath)
                    ->exportForHLS()
                    ->addFormat($format)
                    ->save($m3u8FileName);

                $this->video->video_path = $m3u8FileName;
                $this->video->status = Video::STATUS_PUBLISHED;
                $this->video->state = Video::STATE_M3U8_CONVERTED;

                $this->video->save();
            } else {
                throw new \Exception('File doesn\'t exists');

                // Conversion failed error file doesn't exists
            }
        } catch (EncodingException $exception) {
            $command = $exception->getCommand();
            $errorLog = $exception->getErrorOutput();
            
            Log::error($command);
            Log::error($errorLog);
        }
    }
}
