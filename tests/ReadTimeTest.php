<?php

namespace Realodix\ReadTime\Test;

use Realodix\ReadTime\ReadTime;

class ReadTimeTest extends TestCase
{
    /** @test */
    public function readTime()
    {
        $wordSpeed = 265;
        $this->assertSame(
            'less than a minute',
            (new ReadTime(str_repeat('word', 3), $wordSpeed))->get()
        );
        $this->assertSame(
            '1 min read',
            (new ReadTime(str_repeat('word ', $wordSpeed), $wordSpeed))->get()
        );
        $this->assertSame(
            '3 min read',
            (new ReadTime(str_repeat('word ', $wordSpeed * 3), $wordSpeed))->get()
        );
    }

    /**
     * Words Per Minut must be able to be changed as needed, and must be in accordance
     * with the language. Param 1 must be for counting latin script, param 2 must be for
     * counting Chinese/Japanese/Korean script.
     *
     * @test
     */
    public function readingSpeedMustAdjustToTheLanguage()
    {
        $wordSpeed = 1;
        $content = str_repeat('a ', $wordSpeed);
        $actual = (new ReadTime($content, $wordSpeed))->toArray();
        $this->assertSame($wordSpeed, $actual['word_time']);

        $content = str_repeat('陳る김', $wordSpeed);
        $actual = (new ReadTime($content, $wordSpeed, 12, 3))->toArray();
        $this->assertSame(1, $actual['word_time_cjk']);
    }

    /** @test */
    public function canInputArray()
    {
        $wordSpeed = 265;
        $article = str_repeat('word ', $wordSpeed);
        $array = [$article, $article, $article, $article];

        $this->assertSame(
            $wordSpeed * 4,
            (new ReadTime($array))->toArray()['total_words']
        );
    }

    /** @test */
    public function canInputArrayMultiDimensional()
    {
        $wordSpeed = 265;
        $article = str_repeat('word ', $wordSpeed);
        $array = [$article, [$article, $article], ['a' => ['b' => [$article]]]];

        $this->assertSame(
            $wordSpeed * 4,
            (new ReadTime($array))->toArray()['total_words']
        );
    }

    /** @test */
    public function duration()
    {
        $wordSpeed = 60;

        $article = str_repeat('word ', ($wordSpeed / 2) - 1);
        $this->assertSame(
            'less than a minute',
            (new ReadTime($article, $wordSpeed))->toArray()['duration']
        );

        $article = str_repeat('word ', ($wordSpeed / 2));
        $this->assertSame(
            '1 min read',
            (new ReadTime($article, $wordSpeed))->toArray()['duration']
        );

        $article = str_repeat('word ', ($wordSpeed * 1.5));
        $this->assertSame(
            '2 min read',
            (new ReadTime($article, $wordSpeed))->toArray()['duration']
        );
    }

    /** @test */
    public function imageReadTime()
    {
        $content = str_repeat('<img src="image.jpg">', 5);
        $actual = (new ReadTime($content))->toArray();
        // 12+11+10+9+8
        $this->assertSame(50.0, $actual['image_time'] * 60);

        $content = str_repeat('<img src="image.jpg">', 10);
        $actual = (new ReadTime($content))->toArray();
        // 12+11+10+9+8+7+6+5+4+3
        $this->assertSame(75.0, $actual['image_time'] * 60);

        $content = str_repeat('<img src="image.jpg">', 12);
        $actual = (new ReadTime($content))->toArray();
        // 75 + (3+3)
        $this->assertSame(81.0, $actual['image_time'] * 60);
    }

    /** @test */
    public function imagesCount()
    {
        $content =
        '
            <img src="url" alt="alternatetext">
            <img src="dinosaur.jpg">
            <img />
            <img>
        ';

        $this->assertSame(2, (new ReadTime($content))->toArray()['total_images']);
    }

    /** @test */
    public function canOutputArray()
    {
        $result = (new ReadTime('foo'))->toArray();
        $this->assertIsArray($result);
    }

    /** @test */
    public function canOutputJson()
    {
        $result = (new ReadTime('foo'))->toJson();
        $this->assertJson($result);
    }

    /** @test */
    public function outputArray()
    {
        $wordSpeed = 265;
        $imageTime = 12;
        $cjkSpeed = 500;
        $totalWords = $wordSpeed * 2;
        $t_img = 2;
        $cjkCharacters = '陳港生'  // Jackie Chan
                          .'るろうに剣心' // Rurouni Kenshin
                          .'김제니'; // Jennie Kim
        $actualDuration = ($totalWords / $wordSpeed) + (($imageTime + ($imageTime - 1)) / 60) + (mb_strlen($cjkCharacters) / $cjkSpeed);

        $content = str_repeat('<img src="image.jpg">', $t_img)
                   .str_repeat('word ', $totalWords)
                   .$cjkCharacters;

        $actual = (new ReadTime($content, $wordSpeed, $imageTime, $cjkSpeed))->toArray();

        $expected = [
            'duration'        => '3 min read',
            'actual_duration' => $actualDuration, // 2.4073333333333333
            'total_words'     => $totalWords,
            'total_words_cjk' => mb_strlen($cjkCharacters),
            'total_images'    => $t_img,
            'word_time'       => 2,
            'word_time_cjk'   => 0.024,
            'image_time'      => 0.38333333333333336,
        ];

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function canSetTranslation()
    {
        $customTranslation = 'foobar';
        $actual = (new ReadTime('word'))
                  ->setTranslation(['less_than' => $customTranslation])
                  ->get();

        $this->assertSame($customTranslation, $actual);
    }
}
