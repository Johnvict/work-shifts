# Work-Shifts

**Task**

    Build a REST application from scratch that could serve as a work planning service.
    
**Business requirements:**
- [x] A worker has shifts
- [x] A shift is 8 hours long
- [x] A worker never has two shifts on the same day
- [x] It is a 24 hour timetable 0-8, 8-16, 16-24
- [x] Preferably write a couple of units tests.

**Setup Instructions**
 - To get the app running, run the following command in the project root folder
        
        $ docker-compose up --build

 - Install Composer Dependencies for the Lumen project
    
        $ docker-compose exec work_shifts composer install
  
 - Migrate and seed database with all provided records as in csv files (located in project directory `./database/files`)

        $ docker-compose exec work_shifts php artisan migrate:fresh --seed

