Laravel Project<br>
Overview<br>
This is a Laravel-based project with a Vue 3 frontend. The project includes functionalities for managing leaderboard users and winners, as well as generating QR codes.<br>

Setup Instructions<br>
Prerequisites<br>
Composer<br>
Node.js and npm<br>
Installation<br>
Clone the Repository<br>
git clone https://github.com/harsh4vardhan/leaderBoard.git<br>
cd leaderBoard<br>

Install Composer Dependencies<br>
composer install<br>

Set Up Environment Variables<br>
cp .env.example .env<br>

Generate Application Key<br>
php artisan key:generate<br>

Run Migrations<br>
Run the database migrations to set up the initial database schema:<br>
php artisan migrate<br>

Seed the Database<br>
php artisan db:seed --class=LeaderboardUserSeeder<br>

Reset the Score<br>
php artisan scores:reset<br>

Declare Winner<br>
php artisan winner:declare<br>

Test Cases<br>
Run php artisan test to run test cases.<br>

Install Frontend Dependencies<br>
Navigate to the frontend directory and install the frontend dependencies:<br>
cd frontend<br>
npm install<br>

Build Frontend Assets<br>
Generate the production build of the frontend:<br>
npm run build<br>
The build files will be generated in the frontend/dist directory.<br>

Serve the Application<br>
You can now start the Laravel development server:<br>
php artisan serve<br>
The application will be available at http://localhost:8000.<br>

Jobs<br>
Declare Winner<br>
Job Description: Handles the logic for declaring the current winner based on the leaderboard data.<br>
Usage: To declare a winner, ensure the relevant logic is executed via scheduled tasks or command-line execution.<br>

Generate QR Code<br>
Job Description: Responsible for generating QR codes for various purposes.<br>
Usage: QR codes can be generated using a dedicated service or command as defined in your application.<br>

Frontend Resources<br>
The frontend resources are located in the frontend folder. The Vue 3 application uses modern JavaScript tooling and is built using Vite.<br>

API Endpoints<br>
All API endpoints are prefixed with /api. Here is a brief overview of the available routes:<br>

Leaderboard Users<br>
GET /api/leaderboard-users<br>
Fetch all leaderboard users.<br>

POST /api/leaderboard-users<br>
Create a new leaderboard user.<br>

GET /api/leaderboard-users/{leaderboardUser}<br>
Retrieve a specific leaderboard user by ID.<br>

PUT /api/leaderboard-users/{leaderboardUser}<br>
Update a specific leaderboard user by ID.<br>

DELETE /api/leaderboard-users/{leaderboardUser}<br>
Delete a specific leaderboard user by ID.<br>

GET /api/leaderboard-users/search<br>
Search for leaderboard users based on query parameters.<br>

GET /api/leaderboard-users/sort/name<br>
Sort leaderboard users by name.<br>

GET /api/leaderboard-users/sort/points<br>
Sort leaderboard users by points.<br>

GET /api/leaderboard-users/group/score<br>
Group leaderboard users by score.<br>

Leaderboard Winner<br>
GET /api/leaderboard-winner<br>
Retrieve the current winner from the leaderboard.<br>
Notes<br>
Ensure that you have the correct database and API configurations in your .env file.<br>
For more advanced usage, refer to the Laravel and Vue.js documentation.<br>
