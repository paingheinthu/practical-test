## Survey Application with laravel

### developer setup note
- clone the repo
- generate the application key after finish of `.env` file setup
```sh
php artisan key:generate
```
- create the one database in mysql and set the database name in `.env` config
- run the database migration for creating the require tables
- seeder also the support for the functional testing

### tables definition
- **surveys table** support the multiple surveys application form
- **questions table** can store generic questions data
- **survey_questions table** is pivot table attach question to survey which is need in current survey form
- **answer table** store the customer submitted survey data

### api definition
| Method | URL | definition |
| ------ | --- | ---------- |
| POST | api/v1/user/register | register new user |
| POST | api/v1/user/login | login to system and response access token |
| POST | api/v1/question | crate the new question data |
| POST | api/v1/survey | create the new survey |
| POST | api/v1/survey/question/attach | attach the require question to survey |
| GET | api/v1/survey | fetch the all active survey with related questions |
| GET | api/v1/survey/{survey_id} | response survey information with questions |
| POST | api/v1/survey/answer | submitted user answer the survey form data |
| PUT | api/v1/survey/{id}/disable | disable of survey when no longer this survey is not need |
