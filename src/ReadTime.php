<?php

namespace Realodix\ReadTime;

use League\Config\Configuration;
use Nette\Schema\Expect;

class ReadTime
{
    private array $translations;

    /**
     * @param string|array $content   The content to analyze
     * @param int          $wpm       Speed of reading the text in Words per Minute
     * @param int          $imageTime Speed of reading the image in seconds
     * @param int          $cpm       Speed of reading the Chinese / Korean / Japanese
     *                                characters in Characters per Minute
     */
    public function __construct(
        private string|array $content,
        private int $wpm = 265,
        private int $imageTime = 12,
        private int $cpm = 500
    ) {
        $this->defaultTranslations();
    }

    public function get(): string
    {
        return $this->duration();
    }

    /**
     * Set the translation keys for the read time string
     *
     * @param array $value An associative array of translation text
     */
    public function setTranslation(array $value): self
    {
        $this->translations = $value;

        return $this;
    }

    /**
     * Get the contents and settings of the class as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'duration'        => $this->duration(),
            'actual_duration' => $this->actualDuration(),
            'total_words'     => $this->wordsCount(),
            'total_words_cjk' => $this->wordsCountCJK(),
            'total_images'    => $this->imagesCount(),
            'word_time'       => $this->wordReadTime(),
            'word_time_cjk'   => $this->wordReadTimeCJK(),
            'image_time'      => $this->imageReadTime(),
        ];
    }

    /**
     * Get the contents and settings of the class as a JSON string
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Get the content and flatten the array if it is an array
     */
    private function getContent(): string
    {
        $content = $this->content;

        if (is_array($content)) {
            $content = collect($content)->flatten();
        }

        return $content;
    }

    /**
     * Strip html tags from content
     */
    private function cleanContent(): string
    {
        return strip_tags($this->getContent());
    }

    /**
     * Get the dirty content
     */
    private function dirtyContent(): string
    {
        return $this->getContent();
    }

    /**
     * Humanize Duration for the input string
     */
    private function duration(): string
    {
        $readTime = $this->actualDuration();

        $duration = match (true) {
            $readTime < 0.5 => $this->translation()->get('less_than'),
            $readTime < 1.5 => $this->translation()->get('one_min'),
            default         => ceil($readTime).' '.$this->translation()->get('more_than'),
        };

        return $duration;
    }

    /**
     * @return Configuration
     */
    private function translation()
    {
        $config = new Configuration([
            'less_than' => Expect::string()->default('less than a minute'),
            'one_min'   => Expect::string()->default('1 min read'),
            'more_than' => Expect::string()->default('min read'),
        ]);

        $config->merge($this->translations);

        return $config;
    }

    /**
     * Actual duration of the input string (in minutes)
     */
    private function actualDuration(): float
    {
        return $this->wordReadTime() + $this->wordReadTimeCJK() + $this->imageReadTime();
    }

    /**
     * Read time of the words in the input string (in minutes)
     */
    private function wordReadTime(): int|float
    {
        return $this->wordsCount() / $this->wpm;
    }

    /**
     * Number of words in the input string
     */
    private function wordsCount(): int
    {
        return str_word_count($this->cleanContent());
    }

    /**
     * Read time of the Chinese / Japanese / Korean in the input (in minutes)
     */
    private function wordReadTimeCJK(): int|float
    {
        return $this->wordsCountCJK() / $this->cpm;
    }

    /**
     * Chinese / Japanese / Korean language characters count
     */
    private function wordsCountCJK(): int
    {
        $pattern = '/[\p{Han}\p{Hangul}\p{Hiragana}\p{Katakana}]/u';

        return (int) preg_match_all($pattern, $this->cleanContent(), $matches);
    }

    /**
     * Read Time of the images in the input string (in minutes)
     */
    private function imageReadTime(): float
    {
        $second = 0;
        $totalImages = $this->imagesCount();

        // For the first image add 12 seconds, second image add 11, ...,
        // for image 10+ add 3 seconds.
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
     */
    private function imagesCount(): int
    {
        $pattern = '/<(img)([\W\w]+?)(src=")([\W\w]+?)[\/]?>/';

        return (int) preg_match_all($pattern, $this->dirtyContent(), $matches);
    }

    /**
     * Set the default translation when the class is instantiated
     */
    private function defaultTranslations(): void
    {
        $this->setTranslation([]);
    }
}
