# Inflection #

A library to inflect adjectives, conjugate verbs and pluralize/singularize nouns.

## Usage ##

```composer require hewison/inflection```

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

