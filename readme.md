# KAMAR Directory Services Package

The package providing Kamar Directory Services functionality to the https://github.com/wing5wong/kamar-directory-service example app
Add this package to a Laravel app and begin receiving directory service updates.

## Initial Configuration
Set the values for the following in your `.env` file:
- `KAMAR_DS_USERNAME` Your Directory Service Username
- `KAMAR_DS_PASSWORD` Your Directory Service Password
- `KAMAR_DS_FORMAT` Your Directory Service Format (json|xml)

__Do not set Username and Password values in the config file.__

Publish the config file:
`php artisan vendor:publish --tag=kamar-directory-services.config`

Set the values in `/config/kamar-directory-services.php` for:
- `serviceName` e.g. "Kamar Directory Service"
- `serviceVersion` e.g. 1.0
- `infoUrl` e.g. "https://www.myschool.co.nz/more-info"
- `privacyStatement` e.g. "Change this to a valid privacy statement | All your data belongs to us and will be kept in a top secret vault."
- `options` The options to be requested for your directory service

## Routes
A single route is defined accepting `POST` requests to `/kamar`.  
The route is handled by `/Controllers/HandleKamarPost.php`.  
Base functionality as described in the KAMAR example is implemented here, but you are free to adjust to suit your requirements.

## Middleware
A new `kamar` middleware group is defined.  
The group is the same as the default `web` group, but has the csrf middleware removed.  
You MUST make sure you are authenticating requests to your application.  

## Storage
The example implementation will write json data files at `/storage/app/data`. These files are not publicly accessible by default.

## Commands & Schedules
A `RemoveOldDataFiles` command is available that will remove files older than 3 days.
A schedule to run the command daily is also configured.

Run the command manually with `php artisan KamarDS:removeOldDataFiles`, or configure a cron job to run the task as per the schedule.

For information on configuring a schedule, see https://laravel.com/docs/9.x/scheduling#running-the-scheduler

## Testing
Run tests with `php artisan test`

## KAMAR Directory Services Documentation
See https://directoryservices.kamar.nz/ for implementation details.
