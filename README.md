# Slack notifier

Slack notifier is a PHP library that helps you send your monolog data into slack. Whether you need to log errors or exceptions, get nice looking debug data as a message Slack notifier is for you.

Mainly it was developed for Symfony framework but since it is a library you can use it with different frameworks as well

Slack notifier requires PHP >= 7.1.

## Installation

```sh
composer require russbalabanov/slack-notifier
```

Make sure to pass `SLACK_NOTIFIER_DEFAULT_HOOK_URL` ENV with a slack hook url. This is a fallback url when other urls are not specified
A full list of ENV's is [here](#full-list-of-hook-urls)

## Basic Usage
```
$logger = new Monolog\Logger('default', [new \SlackNotifier\Handler\Handler()]);
$log->error('Some error goes here!')
```

### Adding attachments manually
```
use SlackNotifier\Handler\Handler;
use SlackNotifier\Handler\Attachment;
use SlackNotifier\Handler\Field;

$logger = new Monolog\Logger('default', [new Handler()]);

$attachment = (new Attachment('color'))
    ->addField(new Field('Foo', 'Bar', true))
    ->addField(new Field('Baz', 'Zaz', true));
    
$logger->error('A simple error', [
    'attachments' => [
        $attachment
    ]
]);
```

## Symfony Integration

Integration with Symfony framework is really simple. Just go to your `config` (if you are using SF4+) select a folder with desired environment, for example prod
and modify your monolog.yaml file like this 

```
monolog:
  handlers:
    slack:
      type: service
      id: SlackNotifier\Handler\Handler
```

## Full list of Hook urls
```
SLACK_NOTIFIER_EMERGENCY_HOOK
SLACK_NOTIFIER_ALERT_HOOK
SLACK_NOTIFIER_CRITICAL_HOOK
SLACK_NOTIFIER_ERROR_HOOK
SLACK_NOTIFIER_WARNING_HOOK
SLACK_NOTIFIER_NOTICE_HOOK
SLACK_NOTIFIER_INFO_HOOK
SLACK_NOTIFIER_DEBUG_HOOK
```
## License

Slack notifier is released under the MIT Licence. See the bundled LICENSE file for details.
