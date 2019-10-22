<?= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL ?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="{{ $link }}"></link>
    <title><![CDATA[{{ $title }}]]></title>
    <description><![CDATA[{{ $description }}]]></description>
    <language>{{ $language }}</language>
    <pubDate>{{ $pub_date }}</pubDate>
    @foreach($items as $item)
        <entry>
            <title><![CDATA[{{ $item['title'] }}]]></title>
            <link rel="alternate" href="{{ $item['url'] }}" />
            <id>{{ $item['id'] }}</id>
            <author>
                <name><![CDATA[{{ $title }}]]></name>
            </author>
            <summary type="html">
                <![CDATA[{!! ! empty($item['content']) ? $item['content'] : ''  !!}]]>
            </summary>
            <category type="html">
                <![CDATA[{!! $item['type'] ?? '' !!}]]>
            </category>
            <updated>{{ $item['created_at']->toRssString() }}</updated>
        </entry>
    @endforeach
</feed>
