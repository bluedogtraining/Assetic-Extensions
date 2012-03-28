<?php

namespace AsseticExtension\Filter;

use Assetic\Filter\BaseCssFilter,
    Assetic\Asset\AssetInterface;

/**
 * An Assetic filter for appending cachebusting strings to CSS URLs.
 */
class CachebusterFilter extends BaseCssFilter
{
    /**
     * @param string cachebusting string
     */
    private $buster;

    /**
     * Create the filter with the cachebusting tag to use.
     *
     * The cachebusting tag should be something unique to the release,
     * e.g. release number, a timestamp, vcs tag or commit hash
     *
     * @param string $buster the cachebusting string to append to the url, ie. "v=somestring"
     */
    public function __construct($buster)
    {
        $this->buster = $buster;
    }

    public function filterLoad(AssetInterface $asset)
    {
        // Don't touch the asset on load.
    }

    public function filterDump(AssetInterface $asset)
    {
        $buster = $this->buster;

        $content = $this->filterUrls($asset->getContent(), function($matches) use ($buster) {
            // Leave "data:" URIs untouched.
            if (strpos($matches['url'], 'data:') === 0) {
                return $matches[0];
            }

            // If there's already ? in the querystring, concat with &
            if (strpos($matches['url'], '?') !== false) {
                $concat = '&';
            } else {
                $concat = '?';
            }
            $newUrl = "{$matches['url']}{$concat}{$buster}";

            // Replace the URL with the cachebusting URL.
            return str_replace($matches['url'], $newUrl, $matches[0]);
        });
        $asset->setContent($content);
    }
}