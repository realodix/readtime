<?php

namespace Realodix\ReadTime\Test;

use PHPUnit\Framework\Attributes\Test;
use Realodix\ReadTime\ReadTime;

class ConfigurationTest extends TestCase
{
    /**
     * Words Per Minut must be able to be changed as needed, and must be in accordance
     * with the language. Param 1 must be for counting latin script, param 2 must be for
     * counting Chinese/Japanese/Korean script.
     */
    #[Test]
    public function readingSpeedMustAdjustToTheLanguage()
    {
        $wpm = 1;
        $content = str_repeat('a ', $wpm);
        $actual = (new ReadTime($content, $wpm))->toArray();
        $this->assertSame($wpm, $actual['word_time']);

        $content = str_repeat('陳る김', $wpm);
        $actual = (new ReadTime($content, $wpm, 12, 3))->toArray();
        $this->assertSame(1, $actual['word_time_cjk']);
    }

    /**
     * Translation must be able to be changed as needed
     */
    #[Test]
    public function setTranslation()
    {
        $customTranslation = 'foo';
        $actual = (new ReadTime('word'))
            ->setTranslation(['less_than' => $customTranslation])
            ->get();

        $this->assertSame($customTranslation, $actual);
    }

    /**
     * Set translation with wrong key, and it should return default translation
     */
    #[Test]
    public function setTranslationWithWrongKey()
    {
        $this->expectException(\Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException::class);

        (new ReadTime('word'))
            ->setTranslation(['foo' => 'bar'])
            ->get();
    }

    /**
     * Translation must be in accordance with data type
     */
    #[Test]
    public function setTranslationWithWrongDataType()
    {
        $this->expectException(\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException::class);

        (new ReadTime('word'))
            ->setTranslation(['less_than' => true])
            ->get();
    }
}
