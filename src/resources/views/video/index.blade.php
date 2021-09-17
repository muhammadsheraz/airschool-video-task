@extends('templates.main')


@section('content')
        @auth      
            <!-- Video Listing -->
            <section class="text-center listing-section">
 
                <div class="container">               
                    <h1 class="heading main-heading">All Videos</h1>
                </div>

                <div class="container mb-4 list-container">                
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col"> </th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col" class="text-right">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($videos as $video)
                                            <tr>
                                                <td><img src="https://dummyimage.com/50x50/55595c/fff" /> </td>
                                                <td>{{ $video->title }}</td>
                                                <td>--</td>
                                                <td class="text-right">
                                                    <button id="videoPlay-{{ $video->id }}" value="{{ $video->id }}" 
                                                    class="btn btn-sm btn-danger video-play-btn" 
                                                    data-title="{{$video->title}}"
                                                    data-src="{{Storage::url($video->video_path)}}">
                                                        <i class="fa fa-play"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                
            </section>
        @else
            <!-- Not Authenticated -->
        @endauth


        <!-- Video Player -->
        <section class="text-center player-section" style="display:none;">
            <div class="container">
                <div class="float-left">
                    <a href="" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back to listing</a>
                </div>                
                <h1 class="heading video-heading"></h1>
            </div>

            <video id="videoPlayer"></video>           
        </section>
        

        <script type="text/javascript">
            $(document).ready(function (){
                $('.video-play-btn').click(function () {
                    $('.listing-section').hide();

                    $('.video-heading').html($(this).attr('data-title'));

                    $('.player-section').show();

                    beginVideo($(this).attr('data-src'))
                    $('#videoPlayer').show();
                });
            });

            /**
             * Video Execution
             *
             * @return void
             */
            function beginVideo (src) {
                if(Hls.isSupported()) {
                    var video = document.getElementById('videoPlayer');

                    var hls = new Hls();

                    hls.loadSource(src);
                    
                    hls.attachMedia(video);

                    hls.on(Hls.Events.MANIFEST_PARSED,function() {
                        video.play();
                    });
                }                
            }
        </script>
@endsection