Laravel Project
Overview
This is a Laravel-based project with a Vue 3 frontend. The project includes functionalities for managing leaderboard users and winners, as well as generating QR codes.

Setup Instructions
Prerequisites
Composer
Node.js and npm
Installation
Clone the Repository

git clone https://github.com/harsh4vardhan/leaderBoard.git
cd leaderBoard

Run the following command to install composer dependencies:

composer install
Set Up Environment Variables

Copy the .env.example file to .env and update the environment variables as needed:


cp .env.example .env


Generate Application Key
php artisan key:generate


Run Migrations

Run the database migrations to set up the initial database schema:
php artisan migrate

Test Cases
run php artisan test to run test cases

Install Frontend Dependencies

Navigate to the frontend directory and install the frontend dependencies:
cd frontend
npm install
Build Frontend Assets

Generate the production build of the frontend:

npm run build
The build files will be generated in the frontend/dist directory.

Serve the Application

You can now start the Laravel development server:
php artisan serve
The application will be available at http://localhost:8000.

Jobs
Declare Winner
Job Description: Handles the logic for declaring the current winner based on the leaderboard data.
Usage: To declare a winner, ensure the relevant logic is executed via scheduled tasks or command-line execution.
Generate QR Code
Job Description: Responsible for generating QR codes for various purposes.
Usage: QR codes can be generated using a dedicated service or command as defined in your application.
Frontend Resources
The frontend resources are located in the frontend folder. The Vue 3 application uses modern JavaScript tooling and is built using Vite.

API Endpoints
All API endpoints are prefixed with /api. Here is a brief overview of the available routes:

Leaderboard Users
GET /api/leaderboard-users
Fetch all leaderboard users.

POST /api/leaderboard-users
Create a new leaderboard user.

GET /api/leaderboard-users/{leaderboardUser}
Retrieve a specific leaderboard user by ID.

PUT /api/leaderboard-users/{leaderboardUser}
Update a specific leaderboard user by ID.

DELETE /api/leaderboard-users/{leaderboardUser}
Delete a specific leaderboard user by ID.

GET /api/leaderboard-users/search
Search for leaderboard users based on query parameters.

GET /api/leaderboard-users/sort/name
Sort leaderboard users by name.

GET /api/leaderboard-users/sort/points
Sort leaderboard users by points.

GET /api/leaderboard-users/group/score
Group leaderboard users by score.

Leaderboard Winner
GET /api/leaderboard-winner
Retrieve the current winner from the leaderboard.
Notes
Ensure that you have the correct database and API configurations in your .env file.
For more advanced usage, refer to the Laravel and Vue.js documentation.
