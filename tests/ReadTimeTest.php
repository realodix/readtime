<?php

namespace Realodix\ReadTime\Test;

use Realodix\ReadTime\ReadTime;

class ReadTimeTest extends TestCase
{
    public function testReadTimeMethod()
    {
        $wpm = 265;

        $this->assertSame(
            'less than a minute',
            (new ReadTime(str_repeat('word', 3), $wpm))->get(),
        );
        $this->assertSame(
            '1 min read',
            (new ReadTime(str_repeat('word ', $wpm), $wpm))->get(),
        );
        $this->assertSame(
            '3 min read',
            (new ReadTime(str_repeat('word ', $wpm * 3), $wpm))->get(),
        );
    }

    public function testInputArray()
    {
        $wpm = 265;
        $article = str_repeat('word ', $wpm);
        $array = [$article, $article, $article, $article];

        $this->assertSame(
            $wpm * 4,
            (new ReadTime($array))->toArray()['total_words'],
        );
    }

    public function testInputMultiDimensionalArray()
    {
        $wpm = 265;
        $article = str_repeat('word ', $wpm);
        $array = [$article, [$article, $article], ['a' => ['b' => [$article]]]];

        $this->assertSame(
            $wpm * 4,
            (new ReadTime($array))->toArray()['total_words'],
        );
    }

    public function testOutputDuration()
    {
        $wpm = 60;

        $article = str_repeat('word ', ($wpm / 2) - 1);
        $this->assertSame(
            'less than a minute',
            (new ReadTime($article, $wpm))->toArray()['duration'],
        );

        $article = str_repeat('word ', ($wpm / 2));
        $this->assertSame(
            '1 min read',
            (new ReadTime($article, $wpm))->toArray()['duration'],
        );

        $article = str_repeat('word ', ($wpm * 1.5));
        $this->assertSame(
            '2 min read',
            (new ReadTime($article, $wpm))->toArray()['duration'],
        );
    }

    public function testOutputImageTime()
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

    public function testOutputTotalImages()
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

    public function testOutputArrayDataType()
    {
        $result = (new ReadTime('foo'))->toArray();
        $this->assertIsArray($result);
    }

    public function testOutputJsonDataType()
    {
        $result = (new ReadTime('foo'))->toJson();
        $this->assertJson($result);
    }

    public function testOutput()
    {
        $wpm = 265;
        $imageTime = 12;
        $cpm = 500;
        $totalWords = $wpm * 2;
        $t_img = 2;
        $cjkCharacters = '陳港生'  // Jackie Chan
                          . 'るろうに剣心' // Rurouni Kenshin
                          . '김제니'; // Jennie Kim
        $actualDuration = ($totalWords / $wpm)
                            + (($imageTime + ($imageTime - 1)) / 60)
                            + (mb_strlen($cjkCharacters) / $cpm);

        $content = str_repeat('<img src="image.jpg">', $t_img)
                   . str_repeat('word ', $totalWords)
                   . $cjkCharacters;

        $actual = (new ReadTime($content, $wpm, $imageTime, $cpm))->toArray();

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
}
