<?php
    /**
     * Start XML output
     */

    echo '<?xml version="1.0" encoding="UTF-8"?>';
?><rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:anchor="https://anchor.fm/xmlns">
	<channel>
		<title>This American Life</title>
        <description>This American Life is a weekly public radio show, heard by 2.2 million people on more than 500 stations. Another 2.5 million people download the weekly podcast. It is hosted by Ira Glass, produced in collaboration with Chicago Public Media, delivered to stations by PRX The Public Radio Exchange, and has won all of the major broadcasting awards.</description>
        <language>en</language>
        <copyright>Copyright 1995-<?php echo date("Y"); ?> This American Life</copyright>
        <itunes:author>This American Life</itunes:author>
        <itunes:subtitle>This American Life is a weekly public radio show, heard by 2.2 million people on more than 500 stations. Another 2.5 million people download the weekly podcast.</itunes:subtitle>
        <itunes:owner> <itunes:email>rich@thislife.org</itunes:email> </itunes:owner>
        <itunes:category text="Society &amp; Culture" />
        <itunes:category text="Arts" />
        <itunes:category text="News"> <itunes:category text="Politics" /></itunes:category>
        <itunes:image href="https://files.thisamericanlife.org/sites/all/themes/thislife/img/tal-name-1400x1400.png" />
<?php
    $episodes = json_decode( $jsonFile, true );
    foreach($episodes  as $episode) {
        $leading = $episode['number'] < 100 ?
            substr(str_pad($episode['number'], 5, '0', STR_PAD_LEFT), -3):
            $episode['number'];
?>
        <item>
            <title><![CDATA[<?php echo $episode['number'].': '.$episode['title']?>]]></title>
            <link><?php echo $episode['link']?></link>
            <description><![CDATA[<?php echo $episode['description']?>]]></description>
            <pubDate><?php echo $episode['date']?></pubDate>
            <guid isPermaLink="false"><?php echo $episode['number']?></guid>
            <enclosure url="<?php echo 'http://assets.thisamericanlife.co/podcasts/' . $leading . '.mp3' ?>" type="audio/mpeg" />
            <itunes:author><![CDATA[This American Life]]></itunes:author>
            <itunes:image href="<?php echo 'http://assets.thisamericanlife.co/images/' . $leading . '.jpg' ?>" />
            <itunes:subtitle><![CDATA[<?php echo $episode['description']?>]]></itunes:subtitle>
            <itunes:summary><![CDATA[<?php echo $episode['description']?>]]></itunes:summary>
        </item>
<?php
    }
?>
    </channel>
</rss>