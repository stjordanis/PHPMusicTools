<?php

require_once 'PHPMusicToolsTest.php';
require_once __DIR__.'/../classes/MusicXMLParser.php';


class MusicXMLParserTest extends PHPMusicToolsTest
{
	
	protected function setUp(){
	}
	
	public function test_parse(){
		$xml = file_get_contents('../demo/samples/bach-tidy.xml');
		$parsed = \ianring\MusicXMLParser::parse($xml);
	}

}