<?php

namespace AsseticExtension\Test\Filter;

use Assetic\Asset\StringAsset,
    AsseticExtension\Filter\CachebusterFilter;

class CachebusterFilterTest extends \PHPUnit_Framework_Testcase
{
    /**
     * @dataProvider provideUrls
     */
    public function testUrls($before, $after)
    {
        $asset = new StringAsset($before, array(), null, '.');
        $asset->setTargetPath('.');
        $asset->load();

        $filter = new CachebusterFilter('v=bar');
        $filter->filterDump($asset); 
        $this->assertEquals($after, $asset->getContent());
    }

    public function provideUrls()
    {
        return array(
            array(
                'body { background: url(foo.gif); }', 
                'body { background: url(foo.gif?v=bar); }'
            ),
            array(
                'body { background: url(foo.gif?foo=bar); }', 
                'body { background: url(foo.gif?foo=bar&v=bar); }'
            ),
        );
    }

}