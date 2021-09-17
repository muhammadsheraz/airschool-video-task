@extends('templates.main')

@section('content')
<div class="container mt-5">
    <!-- Upload Video Form -->
    <div class="p-6">
        <div class="flex items-center">
            <div class="ml-4 text-lg leading-7 font-semibold">
                <section class="text-center">
                    <div class="container">
                        <h1 class="heading">Upload Videos</h1>
                    </div>
                </section>
            </div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <form method="POST" action="{{ route('videos.uploadVideo') }}" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" type="text" name="title" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label for="description">Video Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="video">Select Video File</label>
                        <input type="file" class="form-control-file" id="video" name="video">
                    </div>                    
                    <hr>
                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </form>
            </div>
            
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div>{{$error}}</div>
                @endforeach
            @endif
        </div>
    </div>
</div>  
@endsection