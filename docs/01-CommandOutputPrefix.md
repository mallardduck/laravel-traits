# CommandOutputPrefix Trait
An easy to to prefix a Console Commands output. Most often useful for logging a commands output while running it as a cron.

## Why use this?
Have you ever had a Console Command that you want to run as a cron, but log the output?
Not a huge issue. Just tell laravel to log it!?

What about when multiple commands can run concurrently?
Now that's a little more complex. The output's going to be all mixed up and hard to track. Even if the concurrent commands are different, the output may look similar and be hard to delineate.

If only there was a way to delineate between the output of different command processes.

## How to use:
First things first, pick the command you want to output prefix and open it in your preferred editor.

Paste this line amongst your `use` imports:
```
use MallardDuck\LaravelTraits\Console\CommandOutputPrefix;
```

Near the top of your Command class, paste:
```php
use CommandOutputPrefix;
```

Within the commands `__construct` set the prefix:
```php
$this->bootOutputPrefix("Command Prefix");
```

Right at the top of the `handle()` method, add:
```php
$this->initOutputPrefix();
```

### Using output prefxing:
Either simply run the command with the new `-C` flag:
```bash
./artisan my:command -C
```

Or setup the commands cron with the new flag:
```php
$cronLog = storage_path('logs/cron.log');

$schedule->command('maps:find -C')
         ->hourly()
         ->appendOutputTo($cronLog);
 ```
*Note*: Setting it up like this would log the cron to `storage/logs/cron.log` in youre Laravel app. It would not log, nor include prefix, one-off executions of the command.

Read more about Laravel's Scheduled Tasks here: [Task Scheduling](https://laravel.com/docs/5.8/scheduling)

## Example output:
Depending on prefix string you setup the output will vary. However in general, the prefix will include the string you set and an 'ID' corresponding to the UNIX timestamp.

`[{outputPrefix} ID:{epochTime}] `

Where `{outputPrefix}` is the string you set via `$this->bootOutputPrefix()` and `{epochTime}` is the current Unix EPOCH time based on when the command starts running.

### App specific example:
Here is an example from a personal app. This particular command is configured with:
`$this->bootOutputPrefix("Map::Find Places");``

Without the prefix flag:
```
± |master ↑2 U:13 ✗| → ./artisan maps:find
Found 158 locations to scan!
Starting item #1 of 158 total localities.
Found 2 locations and saved 2
Starting item #2 of 158 total localities.
Found 20 locations and saved 20
```

With the prefix flag:
```
± |master ↑2 U:13 ✗| → ./artisan maps:find -C
[Map::Find Places ID:1562088914] Found 156 locations to scan!
[Map::Find Places ID:1562088914] Starting item #1 of 156 total localities.
[Map::Find Places ID:1562088914] Found 19 locations and saved 19
[Map::Find Places ID:1562088914] Starting item #2 of 156 total localities.
```
