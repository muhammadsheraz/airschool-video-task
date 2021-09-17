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





# Post Deployement Commands
- git clone https://github.com/muhammadsheraz/airschool-video-task.git

- docker-compose up --build or docker-compose up --build -d (for background mode)

- docker exec airvid-app composer install

- docker exec airvid-app cp .env.example .env

- docker exec airvid-app php artisan key:generate

- docker exec airvid-app php artisan vendor:publish --provider "Laravel\Fortify\FortifyServiceProvider"

- docker exec airvid-app php artisan vendor:publish --provider="ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider"

- docker exec airvid-app php artisan migrate

- docker exec airvid-app php artisan db:seed

- docker exec airvid-app php artisan view:clear

- docker exec airvid-app php artisan config:cache