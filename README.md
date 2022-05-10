## Survey Application with laravel
Users can create various survey forms creation with allowable data type support questions. Can fetch the summary report per survey and user submitted answer.

### tables definition
- **surveys table** store multiple surveys application form
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
| GET | api/v1/report/survey/{id}/answers | fetch all answer related of survey, response with paginate |
| GET | api/v1/report/user/{id}/answers | fetch all user answers, response with paginate |

### developer notes
#### Requirement
- php8.1 and above
- laravel 9 and above

#### setup
- clone the repo
- run the `composer install` command in project folder path
- generate the application key after finish of `.env` require config setup
```sh
php artisan key:generate
```
- create the one database in mysql and set the database name in `.env` config
- run the database migration for creating the require tables
- seeder also the support for the functional testing
- will come out every queries log and include in response when the enable `API_DEBUG` mode
- you can see every request status log eg.,
```sh
2022-05-10 03:44:17] local.INFO: 172.24.0.1  GET  api/v1/report/user/1/answers  200 insomnia/2022.3.0
```

#### todo
- need to write unit test
- need to setup CI for code style check and integrate testing
- need to create well design frontend part