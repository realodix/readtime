<?php

namespace Realodix\ReadTime;

class ReadTime
{
    private string $dirtyContent;

    private array $translations = [];

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
        if (is_array($content)) {
            $content = collect($content)->flatten();
        }

        $this->content = $this->cleanContent($content);
        $this->dirtyContent = $content;
        $this->wpm = $wpm;
        $this->imageTime = $imageTime;
        $this->cpm = $cpm;

        $this->defaultTranslations();
    }

    public function get(): string
    {
        return $this->duration();
    }

    /**
     * Return an array of the class data
     */
    public function toArray(): array
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
     * Return a json string of the class data
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Humanize Duration for the input string
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
        return str_word_count($this->content);
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

        return preg_match_all($pattern, $this->content, $matches);
    }

    /**
     * Read Time of the images in the input string (in minutes)
     */
    private function imageReadTime(): float
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
     */
    private function imagesCount(): int
    {
        $pattern = '/<(img)([\W\w]+?)(src=")([\W\w]+?)[\/]?>/';

        return preg_match_all($pattern, $this->dirtyContent, $matches);
    }

    /**
     * Set the default translation when the class is instantiated
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
     * @return array|string array if no key is passed, or string if existing key is passed
     */
    private function getTranslation(string|null $key = null): array|string
    {
        return is_null($key) ? $this->translations : $this->translations[$key];
    }

    /**
     * Strip html tags from content
     */
    private function cleanContent(string $content): string
    {
        return strip_tags($content);
    }
}
