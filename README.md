# Read time

![PHPVersion](https://img.shields.io/badge/PHP-8.1-777BB4.svg?style=flat-square)
![Build Status](https://github.com/realodix/readtime/actions/workflows/ci.yml/badge.svg)
[![GitHub license](https://img.shields.io/github/license/realodix/readtime?style=flat-square)](https://github.com/realodix/readtime/blob/main/LICENSE)

📚 Medium's like reading time estimation, based on [Medium's read time formula](https://help.medium.com/hc/en-us/articles/214991667-Read-time).

Sites like Medium.com have popularized the concept of giving users an estimate for the amount of time it will take them to read the content. With this convenience in mind, ReadTime gives PHP developers the same tool for their readable content. It's a simple feature that will give a nice touch to your PHP application.

### Features

- Calculates read time of images in decreasing progression (Example - 12 seconds for the first image, 11 for the second, until images counted at 3 seconds).
- Calculates read time of the Chinese / Japanese / Korean characters separately.
- Removes unwanted html tags to calculate read time more efficiently.

**Reference**
- [help.medium.com/articles/Read-time](https://help.medium.com/hc/en-us/articles/214991667-Read-time)
- [medium.com/blogging-guide/how-is-medium-article-read-time-calculated](https://medium.com/blogging-guide/how-is-medium-article-read-time-calculated-924420338a85)


## Installation

You can install the package via composer:

```sh
composer require realodix/readtime
```

## Quick start

Here is an example of the most basic usage:

```php
<?php

use Realodix\ReadTime\ReadTime;

$readTime = new ReadTime('foo bar');

echo $readTime->get();
// less than a minute
```

You may also pass several arguments to the constructor if you wish to change settings on the fly:

```php
/**
 * @param string|array $content   The content to analyze
 * @param int          $wpm       Speed of reading the text in Words per Minute
 * @param int          $imageTime Speed of reading the image in seconds
 * @param int          $cpm       Speed of reading the Chinese / Korean / Japanese
 *                                characters in Characters per Minute
 */

$readTime = new ReadTime($content, $wpm = 265, $imageTime = 12, $cpm = 500);

echo $readTime->get();
```

The ReadTime class is able to accept a string of content or a array (flat or multidimensional) of multiple pieces of content. This may come in handy if you are attempting to display the total read time of body content along with sidebar content.

For example:

```php

$readTime = new ReadTime([$content, $moreContent, $evenMoreContent]);

echo $readTime->get();
```

> :exclamation: [Named arguments](https://www.php.net/manual/en/functions.arguments.php#functions.named-arguments) are not covered by Realodix Readtime backwards compatibility guidelines. We may choose to rename function arguments when necessary in order to improve codebase. Therefore, using named arguments when calling methods should be done cautiously and with the understanding that the parameter names may change in the future.

### Methods

##### `get()`
Retrieve the read time.

##### `setTranslation(array $translations)`
Manually set the translation text for the class to use. If no key is passed it will default to the English counterpart. A complete translation array will contain the following:

```php
[
    'less_than' => 'less than a minute',
    'one_min'   => '1 min read',
    'more_than' => 'min read',
];
```

##### `toArray()`
Get the contents and settings of the class as an array.

##### `toJson()`
Get the contents and settings of the class as a JSON string.

```php
[
    'duration'        => '6 min read',
    'actual_duration' => 5.55,
    'total_words'     => 1325,
    'total_words_cjk' => 0,
    'total_images'    => 3,
    'word_time'       => 5.660,
    'word_time_cjk'   => 0,
    'image_time'      => 0.55,
];
```

| Variable | Description |
| :------- | :-----------|
| `duration`        | Humanized `actualDuration` for the input |
| `actual_duration` | Actual duration of the input (in minutes) |
| `total_words`     | Number of words in the input |
| `total_words_cjk` | Chinese / Japanese / Korean language characters count |
| `total_images`    | Number of images in input |
| `word_time`       | Read time of the words in the input (in minutes) |
| `word_time_cjk`   | Read time of the Chinese / Japanese / Korean in the input (in minutes) |
| `image_time`      | Read time of the images in the input (in minutes) |


## Contributing
Thank you for your interest in ReadTime. Please check out our [contributing guide](/CONTRIBUTING.md).

## License
This package is licensed using the [MIT License](/LICENSE).
