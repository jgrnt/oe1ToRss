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
->url('http://oe1.orf.at/player')
->language('de')
->copyright('Copyright 2017')
->pubDate(time())
->lastBuildDate(time())
->ttl(60)
->appendTo($feed);

$daysProgramm=json_decode(file_get_contents("https://audioapi.orf.at/oe1/api/json/current/broadcasts"));

foreach($daysProgramm as $day)
{
foreach($day->broadcasts as $show_header)
{
$title = isset($show_header->programTitle) ? $show_header->programTitle : $show_header->title; 

if(preg_match("/^".$_GET["title"]."$/",$title) ){
$show=json_decode(file_get_contents($show_header->href));
$item = new Item();
$item
->title($title)
->description($show->info)
->enclosure("http://loopstream01.apa.at/?channel=oe1&shoutcast=0&player=oe1_v1&referer=radiothek&id=".$show->streams[0]->loopStreamId)
->pubDate($show_header->niceTime / 1000)
->guid($show->id, true)
->appendTo($channel);
}
}
}

echo $feed;
