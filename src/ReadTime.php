<?php

namespace Realodix\ReadTime;

use Aimeos\Map as Arr;

class ReadTime
{
    private string $content;

    private int $wordsPerMin;

    private int $imageTime;

    private int $charactersPerMin;

    private array $translations = [];

    private string $dirtyContent;

    /**
     * @param string|array $content
     * @param int          $wordSpeed Speed of reading the text in Words per Minute
     * @param int          $imageTime Speed of reading the image in seconds
     * @param int          $cjkSpeed  Speed of reading the Chinese / Korean / Japanese
     *                                characters in Characters per Minute
     */
    public function __construct($content, int $wordSpeed = 265, int $imageTime = 12, int $cjkSpeed = 500)
    {
        $this->content = $this->parseContent($content)['content'];
        $this->dirtyContent = $this->parseContent($content)['dirtyContent'];
        $this->wordsPerMin = $wordSpeed;
        $this->imageTime = $imageTime;
        $this->charactersPerMin = $cjkSpeed;

        $this->defaultTranslations();
    }

    public function get(): string
    {
        return $this->duration();
    }

    /**
     * Return an array of the class data
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'duration'       => $this->duration(),
            'actualDuration' => $this->actualDuration(),
            'totalWords'     => $this->wordsCount(),
            'totalWordsCJK'  => $this->wordsCountCJK(),
            'totalImages'    => $this->imagesCount(),
            'wordTime'       => $this->wordReadTime(),
            'wordTimeCJK'    => $this->wordReadTimeCJK(),
            'imageTime'      => $this->imageReadTime(),
        ];
    }

    /**
     * Return a json string of the class data
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Parse the given content so it can be output as a read time
     *
     * @param mixed $content String or array of content
     *
     * @return array
     */
    private function parseContent($content): array
    {
        if (! is_string($content) && ! is_array($content)) {
            throw new \Exception('Content must be type of array or string');
        }

        if (is_array($content)) {
            $content = Arr::from($content)->flat()->join();
        }

        return [
            'content'      => $this->cleanContent($content),
            'dirtyContent' => $content,
        ];
    }

    /**
     * Humanize Duration for the input string
     *
     * @return string
     */
    private function duration(): string
    {
        $readTime = $this->actualDuration();

        if ($readTime < 0.5) {
            return $this->getTranslation('less_than');
        }
        if ($readTime < 1.5) {
            return $this->getTranslation('one_min');
        }

        return ceil($readTime).' '.$this->getTranslation('more_than');
    }

    /**
     * Actual duration of the input string (in minutes)
     *
     * @return float
     */
    private function actualDuration(): float
    {
        return $this->wordReadTime() + $this->wordReadTimeCJK() + $this->imageReadTime();
    }

    /**
     * Read time of the words in the input string (in minutes)
     *
     * @return float
     */
    private function wordReadTime()
    {
        return $this->wordsCount() / $this->wordsPerMin;
    }

    /**
     * Number of words in the input string
     *
     * @return int
     */
    private function wordsCount(): int
    {
        return str_word_count($this->content);
    }

    /**
     * Read time of the Chinese / Japanese / Korean in the input (in minutes)
     *
     * @return float
     */
    private function wordReadTimeCJK()
    {
        return $this->wordsCountCJK() / $this->charactersPerMin;
    }

    /**
     * Chinese / Japanese / Korean language characters count
     */
    private function wordsCountCJK(): int
    {
        $pattern = '/[\p{Han}\p{Hangul}\p{Hiragana}\p{Katakana}]/u';

        return preg_match_all($pattern, $this->content, $matches);
    }

    /**
     * Read Time of the images in the input string (in minutes)
     *
     * @return float
     */
    private function imageReadTime()
    {
        $second = 0;
        $totalImages = $this->imagesCount();

        // For the first image add 12 seconds, second image add 11, ..., for image 10+ add 3 seconds.
        for ($i = 1; $i <= $totalImages; $i++) {
            if ($i > 9) {
                $second += 3;
            } else {
                $second += ($this->imageTime - ($i - 1));
            }
        }

        return $second / 60;
    }

    /**
     * Number of images in the input string
     *
     * @return int
     */
    private function imagesCount(): int
    {
        $pattern = '/<(img)([\W\w]+?)(src=")([\W\w]+?)[\/]?>/';

        return preg_match_all($pattern, $this->dirtyContent, $matches);
    }

    /**
     * Set the default translation when the class is instantiated
     *
     * @return void
     */
    private function defaultTranslations(): void
    {
        $this->setTranslation([]);
    }

    /**
     * Set the translation keys for the read time string
     *
     * @param array $tr An associative array of translation text
     *
     * @return self
     */
    public function setTranslation(array $tr)
    {
        $this->translations = [
            'less_than' => isset($tr['less_than']) ? $tr['less_than'] : 'less than a minute',
            'one_min'   => isset($tr['one_min']) ? $tr['one_min'] : '1 min read',
            'more_than' => isset($tr['more_than']) ? $tr['more_than'] : 'min read',
        ];

        return $this;
    }

    /**
     * Get the translation array or specific key
     *
     * @param string|null $key The translation key
     *
     * @return mixed array if no key is passed, or string if existing key is passed
     */
    private function getTranslation($key = null)
    {
        return is_null($key) ? $this->translations : $this->translations[$key];
    }

    /**
     * Strip html tags from content
     *
     * @param string $content
     *
     * @return string
     */
    private function cleanContent(string $content): string
    {
        return strip_tags($content);
    }
}
