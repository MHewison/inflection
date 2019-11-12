# Inflection #

A library to inflect adjectives, conjugate verbs and pluralize/singularize nouns.

## Usage ##

```composer require hewison/inflection```



```php
use Hewison\Inflection\Word;

$word = Word::create("back");

$word->get();
```
### Output ###
```php
    [adjectives] => Array
        (
            [standard] => back
            [comparative] => more back
            [superlative] => most back
        )
    [adverb] => back
    [noun] => Array
        (
            [singular] => back
            [plural] => backs
        )

    [verb] => Array
        (
            [entry] => back
            [tense] => Present
            [past] => backed
            [past_participle] => backed
            [present] => back
            [present_third] => backs
            [gerund] => backing
        )
```

It is also possible to return just the words you are interested in.

```php
use Hewison\Inflection\Word;

$word = Word::create("back");

$word->getVerb(); // returns verb in all tenses.
$word->getAdverb(); // returns entered word if is adverb
$word->getNoun(); // returns singular and plural forms of entered, if it is a noun. Proper nouns and gibberish will still be processed here.
$word->getAdjective(); // returns adjective with superlative and comparative forms.
```

Additionally if you know what type of word you are working with, you can use the sub libraries on their own.

NOTE: the methods below to not undergo the same library checks as using the Word class.
### Nouns ###

```php
Hewison\Inflection\Noun\Noun::toSingular("tables"); // table
Hewison\Inflection\Noun\Noun::toPlural("bear")' // bears
Hewison\Inflection\Noun\Noun::isSingular("tables"); // false
Hewison\Inflection\Noun\Noun::isPlural("bears"); // true
Hewison\Inflection\Noun\Noun::isCountable("economics"); // false
```

### Adjectives ###
```php
Hewison\Inflection\Adjective\Adjective::resolveSuperlativeForm("boring"); // most boring
Hewison\Inflection\Adjective\Adjective::resolveComparativeForm("boring"); // more boring
Hewison\Inflection\Adjective\Adjective::resolveAllForms("boring"); // array
```

### Verbs ###
```php
Hewison\Inflection\Verb\Verb::create("go")->conjugate(); // array of all forms
Hewison\Inflection\Verb\Verb::create("go")->toGerund(); // Gerund form
Hewison\Inflection\Verb\Verb::create("go")->toPast(); // Past form
Hewison\Inflection\Verb\Verb::create("go")->toPastParticiple(); // Past Participle form
Hewison\Inflection\Verb\Verb::create("go")->toPresentThird(); // Present Third form
Hewison\Inflection\Verb\Verb::create("go")->toPresent(); // Present form

$verb = new Verb("walk");

$verb->toGerund(); // walking
```