<?php

spl_autoload_register(function($c) { @include_once strtr($c, '\\_', '//').'.php'; });
use \Suin\RSSWriter\Feed;
use \Suin\RSSWriter\Channel;
use \Suin\RSSWriter\Item;
date_default_timezone_set('Europe/Vienna');

$feed = new Feed();
$channel = new Channel();
$channel
->title("Ö1 ".$_GET["title"])
->description("Converted RSS from 7 Tage Ö1")
->url('http://oe1.orf.at/konsole')
->language('de')
->copyright('Copyright 2014')
->pubDate(time())
->lastBuildDate(time())
->ttl(60)
->appendTo($feed);


for ($offset = 0; $offset < 7; $offset++) {
$streamDate=date_sub(new DateTime(NULL),new DateInterval("P".$offset."D"));
$daysProgramm=json_decode(file_get_contents("http://oe1.orf.at/programm/konsole/tag/".$streamDate->format("Ymd")));
foreach($daysProgramm->list as $show)
{
if(preg_match("/^".$_GET["title"]."$/",$show->title) ){
$item = new Item();
$itemDate=DateTime::createFromFormat("d.m.YH:i",$show->day_label.$show->time);
$item
->title($show->title)
->description($show->info)
->enclosure($show->url_stream)
->pubDate($itemDate->getTimestamp())
->guid($show->id, true)
->appendTo($channel);
}
}

}
echo $feed;