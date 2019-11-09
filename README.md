# Larapoll
A Laravel package to manage your polls


## Installation:
First, install the package through Composer. 

```bash
composer require inani/larapoll 
```

You can skip the next two steps

Then include the service provider inside `config/app.php`.

```php
'providers' => [
    ...
    Inani\Larapoll\LarapollServiceProvider::class,
    ...
];


'aliases' => [
        ...
        'PollWriter' => Inani\Larapoll\PollWriterFacade::class,
        ...
];
```


Publish migrations, and migrate

```bash
php artisan vendor:publish
php artisan migrate
```

___

## Setup a Model

To setup a model all you have to do is add (and import) the `Voter` trait.

```php
use Inani\Larapoll\Traits\Voter;
class User extends Model
{
    use Voter;
    ...
}
```

___

## Creating, editing and closing polls

### Create poll
```php
// create the question
$poll = new Poll([
            'question' => 'What is the best PHP framework?'
]); 

// attach options and how many options you can vote to
// more than 1 options will be considered as checkboxes
$poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
                     ->maxSelection() // you can ignore it as well
                     ->generate();
$poll->isRadio(); // true
$poll->isCheckable(); // false
$poll->optionsNumber(); // 4
```
### attach and detach options to a poll
```php
// to add new elements 
$bool = $poll->attach([
            'Yii', 'CodeIgniter'
]);
$poll->optionsNumber(); // 6

// to remove options(not voted yet)
$option = $poll->options()->first(); // get first option
$bool = $poll->detach($option); 
$poll->optionsNumber(); // 5
```
### Lock a poll
```php
$bool = $poll->lock();
```
### Unlock a closed poll
```php
$bool = $poll->unLock();
```
### Remove a poll
All related options and votes will be deleted once the Poll is removed
```php
$bool = $poll->remove();
```
## Voting

### Making votes
```php
// a voter(user) picks a poll to vote for
// only ids or array of ids are accepted
$voter->poll($poll)->vote($voteFor->getKey());
```
### Result of votes
```php
// get results unordered
$poll->results()->grab();
// get results in order (desc)
$poll->results()->inOrder();
```

## CRUD HANDLER
LaraPoll ships with a UI a system to manage polls, very easy and fast. you need practically nothing to start using it.
[Please visit the link for the explantation of the interface.](https://medium.com/@InaniT0/create-polls-easily-using-laravel-package-larapoll-d8e520f021f5)

### Set up the admin middleware's name
A larapoll_config.php file will be added where you can put the name of the middleware used to protect the access and other things like pagination and prefix to protect your routes
Add this line in the .env too

```php
LARAPOLL_ADMIN_AUTH_MIDDLEWARE = auth
LARAPOLL_ADMIN_AUTH_GUARD = web
LARAPOLL_PAGINATION = 10
LARAPOLL_PREFIX = Larapoll
```

## FRONT END USE
With Larapoll its easy to integrate a poll for users to vote, you only have to specify two things
- the ID of the poll 

```php
{{ PollWriter::draw(Poll::find(77)) }}
```
### Override views
You can override the views related to the results page and both pages checkbox/radio via the same larapoll_config.php file in the config folder.

#### Route of the vote action
``` php
{{ route('poll.vote', $id) }}
```

#### Data passed to result view
- $question : the question of the poll
- $options : array of objects holding (name, percent, votes).
#### Data passed to the poll checkbox/radio
- $question : the question
- $options : holding the name and id of the option.


