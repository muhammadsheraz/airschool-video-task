# AirSchool Video Task
Coding task for technical evaluation by Air School


# Deadline: 
17th September 2021


# Task Details:
- Create a page where a user can upload videos.
- Store the videos’ metadata in the database.
- Once video uploading is completed, convert it into m3u8 format in the background.
- Once video conversion is completed, update video conversion status in the database
- Final step, create a page where users can see all the converted videos and also be able to play the video.





# Post Installation Commands

- Composer install
- php artisan queue:table
- php artisan migrate
- php artisan vendor:publish --provider "Laravel\\Fortify\\FortifyServiceProvider"
- php artisan vendor:publish --provider="ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider"
- php artisan db:seed 