# Larapoll
A Laravel package to manage your polls


## Installation:
First, install the package through Composer.

```php
composer require inani/larapoll
```

Then include the service provider inside `config/app.php`.

```php
'providers' => [
    ...
    Inani\Larapoll\LarapollServiceProvider::class,
    ...
];
```
Publish migrations, and migrate

```
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
$poll->isCheckable();// false
$poll->optionsNumber(); // 4
```
### attach and detach options to a poll
```php
// too add new elements 
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
