## What is this?
This is meant to be a small repo for sending alerts via cronjob to any specified emails.

## Setup.
<!-- this is a snippet from the laravel docs, all credit goes to them for writing this. (https://github.com/laravel/docs/blob/5.4/scheduling.md#defining-schedules) -->
### Starting The Scheduler

When using the scheduler, you only need to add the following Cron entry to your server. If you do not know how to add Cron entries to your server, consider using a service such as [Laravel Forge](https://forge.laravel.com) which can manage the Cron entries for you:

    * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1

This Cron will call the Laravel command scheduler every minute. When the `schedule:run` command is executed, Laravel will evaluate your scheduled tasks and runs the tasks that are due.

Once the cron job is scheduled you need to add to your `app/Console/Kernel.php` file in the `scheudle` method, the commands you want to run. I.E.


# What commands are available?

### Disk space left

##### Command
`php artisan calculate:disk {--location=/} {--email=} {--alert-when=10} {--test=false}`

##### Description
This command sends email alerts based on when the `--alert-when` value is greater than the total avialable disk space

##### Usage
This usage of the command will email `john@example.com` and `smith@example.com` when the space left on the disk is less than 10 GB.

```
php artisan calculate:disk --location=/ --email=john@example.com --email=smith@example.com --alert-when=10
```

**Please note that if no options are passed it will pull emails from the `.env` file, if you prefer that option please format the email addresses like:**

```
EMAIL_ALERTS='john@example.com,smith@example.com'
```

# Contributing
To contribute to this repo please add your commands to the `app/Console/Commands` directory, and in your PR please explain it's purpose and usage for this doc.
