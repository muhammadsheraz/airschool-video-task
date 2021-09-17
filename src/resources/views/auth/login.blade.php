@extends('templates.main')


@section('content')
<div class="container pt-5 text-center">
<div class="row  flex items-center">
    <div class="col-4"></div>
    <div class="col-4">
        <div class="card-container">
            <!-- <img class="profile-img-card" src="https://res.cloudinary.com/demo/image/upload/w_100,h_100,c_thumb,g_face,r_20,d_avatar.png/non_existing_id.png" alt="" />
            
            <p id="profile-name" class="profile-name-card"></p> -->
            <form method="POST" action="{{route('login')}}" class="form-signin">
                {{ csrf_field() }}
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus value="sheraz@example.com">
                <input type="password" id="password" name="password" class="form-control mt-2" placeholder="Password" required value="MetalCode123">
                <button class="btn btn-lg btn-primary btn-block btn-signin mt-5" type="submit">Sign in</button>
            </form><!-- /form -->
        </div><!-- /card-container -->
    </div>
    <div class="col-4"></div>
</div>
</div><!-- /container -->                    

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div>{{$error}}</div>
    @endforeach
@endif

@endsection