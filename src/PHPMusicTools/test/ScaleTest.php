<?php

require_once 'PHPMusicToolsTest.php';
require_once __DIR__.'/../classes/Scale.php';
require_once __DIR__.'/../classes/Pitch.php';

class ScaleTest extends PHPMusicToolsTest
{
	
	protected function setUp(){
	}


	
	public function test_constructFromArray() {

		$input = array(
			'scale' => 4033,
			'root' => array(
				'step' => 'C',
				'alter' => 1,
				'octave' => 4,
			),
			'direction' => 'ascending'
		);

		$scale = \ianring\Scale::constructFromArray($input);

		$this->assertObjectHasAttribute('scale', $scale);
		$this->assertObjectHasAttribute('root', $scale);
		$this->assertObjectHasAttribute('direction', $scale);

		$this->assertInstanceOf(\ianring\Pitch::class, $scale->root);
		$this->assertEquals('C', $scale->root->step);
		$this->assertEquals(1, $scale->root->alter);
		$this->assertEquals(4, $scale->root->octave);

		$this->assertEquals('ascending', $scale->direction);

	}



	/**
	 * @dataProvider provider_getPitches
	 */
	public function test_getPitches($scale, $root, $expected) {
		$scale = new \ianring\Scale($scale, $root);
		$pitches = $scale->getPitches();
		$this->assertEquals($pitches, $expected);
	}
	public function provider_getPitches() {
		return array(
			'C major' => array(
				'scale' => 2741,
				'root' => new \ianring\Pitch('C', 0, 4),
				'expected' => array(
					0 => new \ianring\Pitch('C',0,4),
					1 => new \ianring\Pitch('D',0,4),
					2 => new \ianring\Pitch('E',0,4),
					3 => new \ianring\Pitch('F',0,4),
					4 => new \ianring\Pitch('G',0,4),
					5 => new \ianring\Pitch('A',0,4),
					6 => new \ianring\Pitch('B',0,4)
				)
			),
			'C locrian' => array(
				'scale' => 1387,
				'root' => new \ianring\Pitch('C', 0, 4),
				'expected' => array(
					0 => new \ianring\Pitch('C',0,4),
					1 => new \ianring\Pitch('D',-1,4),
					2 => new \ianring\Pitch('E',-1,4),
					3 => new \ianring\Pitch('F',0,4),
					4 => new \ianring\Pitch('G',-1,4),
					5 => new \ianring\Pitch('A',-1,4),
					6 => new \ianring\Pitch('B',-1,4)
				)
			),
		);
	}


	/**
	 * @dataProvider provider_resolveScaleFromIntervalPattern
	 */
	public function test_resolveScaleFromIntervalPattern($structure, $expected) {
		$actual = ianring\Scale::resolveScaleFromIntervalPattern($structure);
		$this->assertEquals($expected, $actual);
	}
	public function provider_resolveScaleFromIntervalPattern() {
		return array(
			'major' 					=> array('structure' => '2212221', 'expected' => 2741),
			'whole tone' 					=> array('structure' => '222222', 'expected' => 1365),
			'Aeolian' 						=> array('structure' => '2122122', 'expected' => 1453),
			'Algerian' 						=> array('structure' => '21211131', 'expected' => 2541),
			'Arabian (a)' 					=> array('structure' => '21212121', 'expected' => 2925),
			'Arabian (b)' 					=> array('structure' => '2211222', 'expected' => 1397),
			'Asavari Theta' 				=> array('structure' => '2122122', 'expected' => 1453),
			'Balinese' 						=> array('structure' => '12414', 'expected' => 395),
			'Bilaval Theta' 				=> array('structure' => '2212221', 'expected' => 2741),
			'Bhairav Theta' 				=> array('structure' => '1312131', 'expected' => 2483),
			'Bhairavi Theta' 				=> array('structure' => '1222122', 'expected' => 1451),
			'Byzantine' 					=> array('structure' => '1312131', 'expected' => 2483),
			'Chinese' 						=> array('structure' => '42141', 'expected' => 2257),
			'Chinese Mongolian' 			=> array('structure' => '22323', 'expected' => 661),
			'Diminished' 					=> array('structure' => '21212121', 'expected' => 2925),
			'Dorian'   						=> array('structure' => '2122212', 'expected' => 1709),
			'Egyptian'    					=> array('structure' => '23232', 'expected' => 1189),
			'Ethiopian (A raray)'			=> array('structure' => '2212221', 'expected' => 2741),
			'Ethiopian (Geez & ezel)' 		=> array('structure' => '2122122', 'expected' => 1453),
			'Harmonic Minor' 				=> array('structure' => '2122131', 'expected' => 2477),
			'Hawaiian' 						=> array('structure' => '2122221', 'expected' => 2733),
			'Hindustan' 					=> array('structure' => '2212122', 'expected' => 1461),
			'Hungarian Major' 				=> array('structure' => '3121212', 'expected' => 1753),
			'Hungarian Gypsy' 				=> array('structure' => '2131131', 'expected' => 2509),
			'Hungarian Gypsy Persian' 		=> array('structure' => '1312131', 'expected' => 2483),
			'Hungarian Minor' 				=> array('structure' => '2131131', 'expected' => 2509),
			'Ionian' 						=> array('structure' => '2212221', 'expected' => 2741),
			'Japanese (A)' 					=> array('structure' => '14214', 'expected' => 419),
			'Japenese (B)' 					=> array('structure' => '23214', 'expected' => 421),
			'Japanese (Ichikosucho)' 		=> array('structure' => '22111221', 'expected' => 2805),
			'Japanese (Taishikicho)' 		=> array('structure' => '221112111', 'expected' => 3829),
			'Javanese (Pelog)' 				=> array('structure' => '1222212', 'expected' => 1707),
			'Jewish (Adonai Malakh)' 		=> array('structure' => '11122212', 'expected' => 1711),
			'Jewish (Ahaba Rabba)' 			=> array('structure' => '1312122', 'expected' => 1459),
			'Jewish (Magan Abot)' 			=> array('structure' => '12122211', 'expected' => 3419),
			'Kafi Theta' 					=> array('structure' => '2122212', 'expected' => 1709),
			'Kalyan Theta' 					=> array('structure' => '2221221', 'expected' => 2773),
			'Khamaj Theta' 					=> array('structure' => '2212212', 'expected' => 1717),
			'Locrian' 						=> array('structure' => '1221222', 'expected' => 1387),
			'Lydian' 						=> array('structure' => '2221221', 'expected' => 2773),
			'Major' 						=> array('structure' => '2212221', 'expected' => 2741),
			'Marva Theta' 					=> array('structure' => '1321221', 'expected' => 2771),
			'Mela Bhavapriya (44)' 			=> array('structure' => '1231122', 'expected' => 1483),
			'Mela Chakravakam (16)' 		=> array('structure' => '1312212', 'expected' => 1715),
			'Mela Chalanata (36)' 			=> array('structure' => '3112311', 'expected' => 3257),
			'Mela Charukesi (26)' 			=> array('structure' => '2212122', 'expected' => 1461),
			'Mela Chitrambari (66)' 		=> array('structure' => '2221311', 'expected' => 3285),
			'Mela Dharmavati (59)' 			=> array('structure' => '2131221', 'expected' => 2765),
			'Mela Dhatuvardhani (69)' 		=> array('structure' => '3121131', 'expected' => 2521),
			'Mela Dhavalambari (49)' 		=> array('structure' => '1321113', 'expected' => 979),
			'Mela Dhenuka (9)' 				=> array('structure' => '1222131', 'expected' => 2475),
			'Mela Dhirasankarabharana' 		=> array('structure' => '2212221', 'expected' => 2741),
			'Mela Divyamani (48)' 			=> array('structure' => '1231311', 'expected' => 3275),
			'Mela Gamanasrama (53)' 		=> array('structure' => '1321221', 'expected' => 2771),
			'Mela Ganamurti (3)' 			=> array('structure' => '1132131', 'expected' => 2471),
			'Mela Gangeyabhusani (33)' 		=> array('structure' => '3112131', 'expected' => 2489),
			'Mela Gaurimanohari (23)' 		=> array('structure' => '2122221', 'expected' => 2733),
			'Mela Gavambodhi (43)' 			=> array('structure' => '1231113', 'expected' => 971),
			'Mela Gayakapriya (13)' 		=> array('structure' => '1312113', 'expected' => 947),
			'Mela Hanumattodi (8)' 			=> array('structure' => '1222122', 'expected' => 1451),
			'Mela Harikambhoji (28)' 		=> array('structure' => '2212212', 'expected' => 1717),
			'Mela Hatakambari (18)' 		=> array('structure' => '1312311', 'expected' => 3251),
			'Mela Hemavati (58)' 			=> array('structure' => '2131212', 'expected' => 1741),
			'Mela Jalarnavam (38)' 			=> array('structure' => '1141122', 'expected' => 1479),
			'Mela Jhalavarali (39)' 		=> array('structure' => '1141131', 'expected' => 2503),
			'Mela Jhankaradhvani (19)' 		=> array('structure' => '2122113', 'expected' => 941),
			'Mela Jyotisvarupini (68)' 		=> array('structure' => '3121122', 'expected' => 1497),
			'Mela Kamavarardhani (51)' 		=> array('structure' => '1321131', 'expected' => 2515),
			'Mela Kanakangi (1)' 			=> array('structure' => '1132113', 'expected' => 935),
			'Mela Kantamani (61)' 			=> array('structure' => '2221113', 'expected' => 981),
			'Mela Kharaharapriya (22)' 		=> array('structure' => '2122212', 'expected' => 1709),
			'Mela Kiravani (21)' 			=> array('structure' => '2122131', 'expected' => 2477),
			'Mela Kokilapriya (11)' 		=> array('structure' => '1222221', 'expected' => 2731),
			'Mela Kosalam (71)' 			=> array('structure' => '3121221', 'expected' => 2777),
			'Mela Latangi (63)' 			=> array('structure' => '2221131', 'expected' => 2517),
			'Mela Manavati (5)' 			=> array('structure' => '1132221', 'expected' => 2727),
			'Mela Mararanjani (25)' 		=> array('structure' => '2212113', 'expected' => 949),
			'Mela Mayamalavagaula (15)'  	=> array('structure' => '1312131', 'expected' => 2483),
			'Mela Mechakalyani (65)' 		=> array('structure' => '2221221', 'expected' => 2773),
			'Mela Naganandini (30)' 		=> array('structure' => '2212311', 'expected' => 3253),
			'Mela Namanarayani (50)' 		=> array('structure' => '1321122', 'expected' => 1491),
			'Mela Nasikabhusani (70)' 		=> array('structure' => '3121212', 'expected' => 1753),
			'Mela Natabhairavi (20)' 		=> array('structure' => '2122122', 'expected' => 1453),
			'Mela Natakapriya (10)' 		=> array('structure' => '1222212', 'expected' => 1707),
			'Mela Navanitam (40)' 			=> array('structure' => '1141212', 'expected' => 1735),
			'Mela Nitimati (60)' 			=> array('structure' => '2131311', 'expected' => 3277),
			'Mela Pavani (41)' 				=> array('structure' => '1141221', 'expected' => 2759),
			'Mela Ragavardhani (32)' 		=> array('structure' => '3112122', 'expected' => 1465),
			'Mela Raghupriya (42)    ' 		=> array('structure' => '1141311', 'expected' => 3271),
			'Mela Ramapriya (52)     ' 		=> array('structure' => '1321212', 'expected' => 1747),
			'Mela Rasikapriya (72)   ' 		=> array('structure' => '3121311', 'expected' => 3289),
			'Mela Ratnangi (2)       ' 		=> array('structure' => '1132122', 'expected' => 1447),
			'Mela Risabhapriya (62)  ' 		=> array('structure' => '2221122', 'expected' => 1493),
			'Mela Rupavati (12)      ' 		=> array('structure' => '1222311', 'expected' => 3243),
			'Mela Sadvidhamargini (46)' 	=> array('structure' => '1231212', 'expected' => 1739),
			'Mela Salagam (37)       ' 		=> array('structure' => '1141113', 'expected' => 967),
			'Mela Sanmukhapriya (56) ' 		=> array('structure' => '2131122', 'expected' => 1485),
			'Mela Sarasangi (27)     ' 		=> array('structure' => '2212131', 'expected' => 2485),
			'Mela Senavati (7)       ' 		=> array('structure' => '1222113', 'expected' => 939),
			'Mela Simhendramadhyama (57)' 	=> array('structure' => '2131131', 'expected' => 2509),
			'Mela Subhapantuvarali (45)' 	=> array('structure' => '1231131', 'expected' => 2507),
			'Mela Sucharitra (67)    ' 		=> array('structure' => '3121113', 'expected' => 985),
			'Mela Sulini (35)        ' 		=> array('structure' => '3112221', 'expected' => 2745),
			'Mela Suryakantam (17)   ' 		=> array('structure' => '1312221', 'expected' => 2739),
			'Mela Suvarnangi (47)    ' 		=> array('structure' => '1231221', 'expected' => 2763),
			'Mela Syamalangi (55)    ' 		=> array('structure' => '2131113', 'expected' => 973),
			'Mela Tanarupi (6)       ' 		=> array('structure' => '1132311', 'expected' => 3239),
			'Mela Vaschaspati (64)   ' 		=> array('structure' => '2221212', 'expected' => 1749),
			'Mela Vagadhisvari (34)  ' 		=> array('structure' => '3112212', 'expected' => 1721),
			'Mela Vakulabharanam (14)' 		=> array('structure' => '1312122', 'expected' => 1459),
			'Mela Vanaspati (4)      ' 		=> array('structure' => '1132212', 'expected' => 1703),
			'Mela Varunapriya (24)   ' 		=> array('structure' => '2122311', 'expected' => 3245),
			'Mela Visvambari (54)    ' 		=> array('structure' => '1321311', 'expected' => 3283),
			'Mela Yagapriya (31)     ' 		=> array('structure' => '3112113', 'expected' => 953),
			'Melodic Minor           ' 		=> array('structure' => '2122221', 'expected' => 2733),
			'Mixolydian              ' 		=> array('structure' => '2212212', 'expected' => 1717),
			'Mohammedan              ' 		=> array('structure' => '2122131', 'expected' => 2477),
			'Neopolitan              ' 		=> array('structure' => '1222131', 'expected' => 2475),
			'Oriental (a)            ' 		=> array('structure' => '1311222', 'expected' => 1395),
			'Overtone Dominant       ' 		=> array('structure' => '2221212', 'expected' => 1749),
			'Pentatonic Major        ' 		=> array('structure' => '23223', 'expected' => 677),
			'Pentatonic Minor        ' 		=> array('structure' => '32232', 'expected' => 1193),
			'Persian                 ' 		=> array('structure' => '1311231', 'expected' => 2419),
			'Phrygian                ' 		=> array('structure' => '1222122', 'expected' => 1451),
			'Purvi Theta             ' 		=> array('structure' => '1321131', 'expected' => 2515),
			'Roumanian Minor         ' 		=> array('structure' => '2131212', 'expected' => 1741),
			'Spanish Gypsy           ' 		=> array('structure' => '1312122', 'expected' => 1459),
			'Todi Theta              ' 		=> array('structure' => '1231131', 'expected' => 2507),
			'Whole Tone              ' 		=> array('structure' => '222222', 'expected' => 1365),
			'Augmented               ' 		=> array('structure' => '313131', 'expected' => 2457),
			'Blues                   ' 		=> array('structure' => '321132', 'expected' => 1257),
			'Diatonic                ' 		=> array('structure' => '22323', 'expected' => 661),
			'Double Harmonic         ' 		=> array('structure' => '1312131', 'expected' => 2483),
			'Eight Tone Spanish      ' 		=> array('structure' => '12111222', 'expected' => 1403),
			'Enigmatic               ' 		=> array('structure' => '1322211', 'expected' => 3411),
			'Hirajoshi               ' 		=> array('structure' => '21414', 'expected' => 397),
			'Kumoi                   ' 		=> array('structure' => '21423', 'expected' => 653),
			'Leading Whole Tone      ' 		=> array('structure' => '2222211', 'expected' => 3413),
			'Lydian Augmented        ' 		=> array('structure' => '2222121', 'expected' => 2901),
			'Neoploitan Major        ' 		=> array('structure' => '1222221', 'expected' => 2731),
			'Neopolitan Minor        ' 		=> array('structure' => '1222122', 'expected' => 1451),
			'Oriental (b)            ' 		=> array('structure' => '1311312', 'expected' => 1651),
			'Pelog (Javanese)        ' 		=> array('structure' => '1222212', 'expected' => 1707),
			'Prometheus              ' 		=> array('structure' => '222312', 'expected' => 1621),
			'Prometheus Neopolitan   ' 		=> array('structure' => '132312', 'expected' => 1619),
			'Six Tone Symmetrical    ' 		=> array('structure' => '131313', 'expected' => 819),
			'Super Locrian           ' 		=> array('structure' => '1212222', 'expected' => 1371),
			'Lydian Minor            ' 		=> array('structure' => '2221122', 'expected' => 1493),
			'Lydian Diminished       ' 		=> array('structure' => '2131122', 'expected' => 1485),
			'Nine Tone Scale         ' 		=> array('structure' => '211211121', 'expected' => 3037),
			'Auxiliary Diminished    ' 		=> array('structure' => '21212121', 'expected' => 2925),
			'Auxiliary Augmented     ' 		=> array('structure' => '222222', 'expected' => 1365),
			'Auxiliary Diminished Blues' 	=> array('structure' => '12121212', 'expected' => 1755),
			'Major Locrian           ' 		=> array('structure' => '2211222', 'expected' => 1397),
			'Overtone                ' 		=> array('structure' => '2221212', 'expected' => 1749),
			'Hindu                   ' 		=> array('structure' => '2212122', 'expected' => 1461),
			'Diminished Whole Tone   ' 		=> array('structure' => '1212222', 'expected' => 1371),
			'Pure Minor              ' 		=> array('structure' => '2122122', 'expected' => 1453),
			'Half Diminished (Locrian)' 	=> array('structure' => '1221222', 'expected' => 1387),
			'Half Diminished #2 (Locrian #2)'	=> array('structure' => '2121222', 'expected' => 1389),
			'Dominant 7th            ' 		=> array('structure' => '232212', 'expected' => 1701),
		);
	}


	/**
	 * @dataProvider provider_neighbours_and_levenshtein
	 */
	public function test_neighbours_and_levenshtein($scaleNum) {
		// $this->markTestSkipped();
		$scale = new ianring\Scale($scaleNum);
		$neighbours = $scale->neighbours();
		foreach($neighbours as $n) {
			$l = ianring\Scale::levenshteinScale($n, $scaleNum);
			$this->assertEquals($l, 1);
		}
	}
	public function provider_neighbours_and_levenshtein() {
		$all = range(0, 4095);
		$array = array();
		foreach ($all as $a) {
			$array[$a] = $a;
		}
		return $array;
	}


	/**
	 * @dataProvider provider_levenshteinScale
	 */
	public function test_levenshteinScale($scale1, $scale2, $expected) {
		$actual = ianring\Scale::levenshteinScale($scale1, $scale2);
		$this->assertEquals($actual, $expected);
	}
	public function provider_levenshteinScale() {
		return array(
			array('scale1' => 325, 'scale2' => 4095, 'expected' => 8),
			array('scale1' => 273, 'scale2' => 4095, 'expected' => 9),
			array('scale1' => 3549, 'scale2' => 4095, 'expected' => 3),
			array('scale1' => 3549, 'scale2' => 3003, 'expected' => 3),
			array('scale1' => 585, 'scale2' => 273, 'expected' => 3),
			array('scale1' => 273, 'scale2' => 585, 'expected' => 3),
			array('scale1' => 3935, 'scale2' => 4031, 'expected' => 2),
			array('scale1' => 3935, 'scale2' => 3871, 'expected' => 1),

		);
	}



	/**
	 * @dataProvider provider_normalizeScalePitches
	 */
	public function test_normalizeScalePitches($scale, $pitches, $expected) {
		$scale = new \ianring\Scale($scale, $pitches[0]);
		$actual = $scale->normalizeScalePitches($pitches);
		$this->assertEquals($expected, $actual);
	}
	public function provider_normalizeScalePitches() {
		return array(
			array(
				'scale' => 2741,
				'pitches' => array(
					new \ianring\Pitch('C', 0, 3),
					new \ianring\Pitch('D', 0, 3),
					new \ianring\Pitch('F', -1, 3), // this one should change to an E natural
					new \ianring\Pitch('F', 0, 3),
					new \ianring\Pitch('G', 0, 3),
					new \ianring\Pitch('A', 0, 3),
					new \ianring\Pitch('B', 0, 3),
				),
				'expected' => array(
					new \ianring\Pitch('C', 0, 3),
					new \ianring\Pitch('D', 0, 3),
					new \ianring\Pitch('E', 0, 3),
					new \ianring\Pitch('F', 0, 3),
					new \ianring\Pitch('G', 0, 3),
					new \ianring\Pitch('A', 0, 3),
					new \ianring\Pitch('B', 0, 3),
				)
			),
			array(
				'scale' => 2741,
				'pitches' => array(
					new \ianring\Pitch('C', 1, 3),
					new \ianring\Pitch('D', 1, 3),
					new \ianring\Pitch('F', 0, 3), // this one should change to an E sharp
					new \ianring\Pitch('F', 1, 3),
					new \ianring\Pitch('G', 1, 3),
					new \ianring\Pitch('A', 1, 3),
					new \ianring\Pitch('C', 0, 4), // this should become a B sharp
				),
				'expected' => array(
					new \ianring\Pitch('C', 1, 3),
					new \ianring\Pitch('D', 1, 3),
					new \ianring\Pitch('E', 1, 3),
					new \ianring\Pitch('F', 1, 3),
					new \ianring\Pitch('G', 1, 3),
					new \ianring\Pitch('A', 1, 3),
					new \ianring\Pitch('B', 1, 4),
				)
			),
			array(
				'scale' => 2487,
				'pitches' => array(
					new \ianring\Pitch('C', 0, 3),
					new \ianring\Pitch('C', 1, 3), 
					new \ianring\Pitch('D', 0, 3), 
					new \ianring\Pitch('E', 0, 3), 
					new \ianring\Pitch('F', 0, 3), 
					new \ianring\Pitch('G', 0, 3),
					new \ianring\Pitch('G', 1, 3), // this is better as an A flat
					new \ianring\Pitch('B', 0, 3), 
				),
				'expected' => array(
					new \ianring\Pitch('C', 0, 3),
					new \ianring\Pitch('C', 1, 3), 
					new \ianring\Pitch('D', 0, 3), 
					new \ianring\Pitch('E', 0, 3), 
					new \ianring\Pitch('F', 0, 3), 
					new \ianring\Pitch('G', 0, 3),
					new \ianring\Pitch('A', -1, 3),
					new \ianring\Pitch('B', 0, 3), 
				)
			),			
			array(
				'scale' => 1427,
				'pitches' => array(
					new \ianring\Pitch('C', 0, 3),
					new \ianring\Pitch('C', 1, 3), // this one should change to a D flat
					new \ianring\Pitch('E', 0, 3), 
					new \ianring\Pitch('G', 0, 3),
					new \ianring\Pitch('G', 1, 3), // this is better as an A flat
					new \ianring\Pitch('A', 1, 3), // this is better as a B flat
				),
				'expected' => array(
					new \ianring\Pitch('C', 0, 3),
					new \ianring\Pitch('D', -1, 3), 
					new \ianring\Pitch('E', 0, 3), 
					new \ianring\Pitch('G', 0, 3),
					new \ianring\Pitch('A', -1, 3), 
					new \ianring\Pitch('B', -1, 3), 
				)
			),

		);
	}



	/**
	 * @dataProvider provider_countTones
	 */
	public function test_countTones($scale, $expected) {
		$scale = new \ianring\Scale($scale, null);
		$actual = $scale->countTones();
		$this->assertEquals($expected, $actual);
	}
	public function provider_countTones() {
		return array(
			array(
				'scale' => 2741,
				'expected' => 7
			),
			array(
				'scale' => 4095,
				'expected' => 12
			),
			array(
				'scale' => 1235,
				'expected' => 6
			),
			array(
				'scale' => 273,
				'expected' => 3
			)
		);
	}



	/**
	 * @dataProvider provider_isPalindromic
	 */
	public function test_isPalindromic($scale, $expected) {
		$scale = new \ianring\Scale($scale, null);
		$actual = $scale->isPalindromic();
		$this->assertEquals($expected, $actual);
	}
	public function provider_isPalindromic() {
		return array(
			array('scale' => 273, 'expected' => true),
			array('scale' => 337, 'expected' => true),
			array('scale' => 433, 'expected' => true),
			array('scale' => 497, 'expected' => true),
			array('scale' => 585, 'expected' => true),
			array('scale' => 681, 'expected' => true),
			array('scale' => 745, 'expected' => true),
			array('scale' => 793, 'expected' => true),
			array('scale' => 857, 'expected' => true),
			array('scale' => 953, 'expected' => true),
			array('scale' => 1017, 'expected' => true),
			array('scale' => 1093, 'expected' => true),
			array('scale' => 1189, 'expected' => true),
			array('scale' => 1253, 'expected' => true),
			array('scale' => 1301, 'expected' => true),
			array('scale' => 1365, 'expected' => true),
			array('scale' => 1461, 'expected' => true),
			array('scale' => 1525, 'expected' => true),
			array('scale' => 1613, 'expected' => true),
			array('scale' => 1709, 'expected' => true),
			array('scale' => 1773, 'expected' => true),
			array('scale' => 1821, 'expected' => true),
			array('scale' => 1885, 'expected' => true),
			array('scale' => 1981, 'expected' => true),
			array('scale' => 2045, 'expected' => true),
			array('scale' => 2211, 'expected' => true),
			array('scale' => 2275, 'expected' => true),
			array('scale' => 2323, 'expected' => true),
			array('scale' => 2387, 'expected' => true),
			array('scale' => 2483, 'expected' => true),
			array('scale' => 2547, 'expected' => true),
			array('scale' => 2635, 'expected' => true),
			array('scale' => 2731, 'expected' => true),
			array('scale' => 2795, 'expected' => true),
			array('scale' => 2843, 'expected' => true),
			array('scale' => 2907, 'expected' => true),
			array('scale' => 3003, 'expected' => true),
			array('scale' => 3067, 'expected' => true),
			array('scale' => 3143, 'expected' => true),
			array('scale' => 3239, 'expected' => true),
			array('scale' => 3303, 'expected' => true),
			array('scale' => 3351, 'expected' => true),
			array('scale' => 3415, 'expected' => true),
			array('scale' => 3511, 'expected' => true),
			array('scale' => 3575, 'expected' => true),
			array('scale' => 3663, 'expected' => true),
			array('scale' => 3759, 'expected' => true),
			array('scale' => 3823, 'expected' => true),
			array('scale' => 3871, 'expected' => true),
			array('scale' => 3935, 'expected' => true),
			array('scale' => 4031, 'expected' => true),
			array('scale' => 4095, 'expected' => true),
			array('scale' => 1625, 'expected' => false),
			array('scale' => 325, 'expected' => false),
			array('scale' => 1186, 'expected' => false),
		);
	}


	/**
	 * @dataProvider provider_countMaxConsecutiveOffBits
	 */
	public function test_countMaxConsecutiveOffBits($scale, $expected) {
		$scale = new \ianring\Scale($scale, null);
		$actual = $scale->countMaxConsecutiveOffBits();
		$this->assertEquals($expected, $actual);
	}
	public function provider_countMaxConsecutiveOffBits() {
		return array(
			array('scale' => 273, 'expected' => 3),
			array('scale' => 585, 'expected' => 2),
			array('scale' => 1123, 'expected' => 3),
			array('scale' => 1186, 'expected' => 3),
			array('scale' => 1365, 'expected' => 1),
			array('scale' => 1387, 'expected' => 1),
			array('scale' => 1459, 'expected' => 2),
			array('scale' => 2485, 'expected' => 2),
			array('scale' => 2741, 'expected' => 1),
			array('scale' => 3669, 'expected' => 2),
			array('scale' => 4095, 'expected' => 0),
		);
	}



	/**
	 * @dataProvider provider_isChiral
	 */
	public function test_isChiral($scale, $expected) {
		$scale = new \ianring\Scale($scale, null);
		$actual = $scale->isChiral();
		$this->assertEquals($expected, $actual);
	}
	public function provider_isChiral() {
		return array(
			array('scale' => 273, 'expected' => false),
			array('scale' => 585, 'expected' => false),
			array('scale' => 1123, 'expected' => true),
			array('scale' => 1186, 'expected' => true),
			array('scale' => 1365, 'expected' => false),
			array('scale' => 1387, 'expected' => false),
			array('scale' => 1459, 'expected' => true),
			array('scale' => 2485, 'expected' => true),
			array('scale' => 2741, 'expected' => false),
			array('scale' => 3669, 'expected' => true),
			array('scale' => 4095, 'expected' => false),
		);
	}



	/**
	 * @dataProvider provider_enantiomorph
	 */
	public function test_enantiomorph($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->enantiomorph();
		$this->assertEquals($expected, $actual->scale);
	}
	public function provider_enantiomorph() {
		return array(
			array(
				'scale' => 1841,
				'expected' => 413
			),
			array(
				'scale' => 2741,
				'expected' => 1451
			),			
			'chromatic' => array(
				'scale' => 4095,
				'expected' => 4095
			),
			'whole tone' => array(
				'scale' => 1365,
				'expected' => 1365
			),
		);

	}



	/**
	 * @dataProvider provider_imperfections
	 */
	public function test_imperfections($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->imperfections();
		$this->assertEquals($expected, $actual);
	}
	public function provider_imperfections() {
		return array(
			array(
				'scale' => 1841,
				'expected' => array(0, 4, 8)
			),
			array(
				'scale' => 2741,
				'expected' => array(11)
			),			
			'chromatic' => array(
				'scale' => 4095,
				'expected' => array()
			),
			'whole tone' => array(
				'scale' => 1365,
				'expected' => array(0, 2, 4, 6, 8, 10)
			),
		);

	}



	/**
	 * @dataProvider provider_spectrum
	 */
	public function test_spectrum($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->spectrum();
		$this->assertEquals($expected, $actual);
	}
	public function provider_spectrum() {
		return array(
			array(
				'scale' => 273,
				'expected' => array(0, 0, 0, 3, 0, 0)
			),
			array(
				'scale' => 2741,
				'expected' => array(2, 5, 4, 3, 6, 1)
			),			
			'chromatic' => array(
				'scale' => 4095,
				'expected' => array(12, 12, 12, 12, 12, 6)
			),
			'whole tone' => array(
				'scale' => 1365,
				'expected' => array(0, 6, 0, 6, 0, 3)
			),
		);

	}



	/**
	 * @dataProvider provider_symmetries
	 */
	public function test_symmetries($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->symmetries();
		$this->assertEquals($expected, $actual);
	}
	public function provider_symmetries() {
		return array(
			array(
				'scale' => 1841,
				'expected' => array()
			),
			array(
				'scale' => 2741,
				'expected' => array()
			),			
			'chromatic' => array(
				'scale' => 4095,
				'expected' => array(1,2,3,4,5,6,7,8,9,10,11)
			),
			'whole tone' => array(
				'scale' => 1365,
				'expected' => array(2,4,6,8,10)
			),
		);

	}




	/**
	 * @dataProvider provider_getTones
	 */
	public function test_getTones($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->getTones();
		$this->assertEquals($expected, $actual);
	}
	public function provider_getTones() {
		return array(
			array(
				'scale' => 3705,
				'expected' => array(0,3,4,5,6,9,10,11)
			),
			'chromatic' => array(
				'scale' => 4095,
				'expected' => array(0,1,2,3,4,5,6,7,8,9,10,11)
			),
			'whole tone' => array(
				'scale' => 1365,
				'expected' => array(0,2,4,6,8,10)
			),
		);

	}


	/**
	 * @dataProvider provider_getChordBitMasks
	 */
	public function test_getChordBitMasks($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->getChordBitMasks();
		$this->assertEquals($expected, $actual);
	}
	public function provider_getChordBitMasks() {
		return array(
			array(
				'scale' => 2741,
				'expected' => array(145, 548, 2192, 4640, 18560, 70144, 149504)
			),
			array(
				'scale' => 1453,
				'expected' => array(137, 292, 1160, 4384, 17536, 37120, 148480)
			)
		);

	}


	/**
	 * @dataProvider provider_getTriads
	 */
	public function test_getTriads($scale, $root, $expected) {
		$scale = new \ianring\Scale($scale, $root);
		$actual = $scale->getTriads();
		$this->assertEquals($expected, $actual);
	}
	public function provider_getTriads() {
		return array(
			'chromatic scale is not diatonic' => array(
				'scale' => 4095,
				'root' => new \ianring\Pitch('C', 0, 3),
				'expected' => null
			),
			'C major scale' => array(
				'scale' => 2741, // C MAJOR
				'root' => new \ianring\Pitch('C', 0, 3),
				'expected' => array(
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'C', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'E', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'G', 'alter' => 0, 'octave' => 3))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'D', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'F', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'A', 'alter' => 0, 'octave' => 3))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'E', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'G', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'B', 'alter' => 0, 'octave' => 3))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'F', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'A', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'C', 'alter' => 0, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'G', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'B', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'D', 'alter' => 0, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'A', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'C', 'alter' => 0, 'octave' => 4)),
							array('pitch' => array('step' => 'E', 'alter' => 0, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'B', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'D', 'alter' => 0, 'octave' => 4)),
							array('pitch' => array('step' => 'F', 'alter' => 0, 'octave' => 4))
						)
					))
				)
			),

			'C Locrian scale' => array(
				'scale' => 1387,
				'root' => new \ianring\Pitch('C', 0, 3),
				'expected' => array(
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'C', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'E', 'alter' => -1, 'octave' => 3)),
							array('pitch' => array('step' => 'G', 'alter' => -1, 'octave' => 3))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'D', 'alter' => -1, 'octave' => 3)),
							array('pitch' => array('step' => 'F', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'A', 'alter' => -1, 'octave' => 3))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'E', 'alter' => -1, 'octave' => 3)),
							array('pitch' => array('step' => 'G', 'alter' => -1, 'octave' => 3)),
							array('pitch' => array('step' => 'B', 'alter' => -1, 'octave' => 3))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'F', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'A', 'alter' => -1, 'octave' => 3)),
							array('pitch' => array('step' => 'C', 'alter' => 0, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'G', 'alter' => -1, 'octave' => 3)),
							array('pitch' => array('step' => 'B', 'alter' => -1, 'octave' => 3)),
							array('pitch' => array('step' => 'D', 'alter' => -1, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'A', 'alter' => -1, 'octave' => 3)),
							array('pitch' => array('step' => 'C', 'alter' => 0, 'octave' => 4)),
							array('pitch' => array('step' => 'E', 'alter' => -1, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'B', 'alter' => -1, 'octave' => 3)),
							array('pitch' => array('step' => 'D', 'alter' => -1, 'octave' => 4)),
							array('pitch' => array('step' => 'F', 'alter' => 0, 'octave' => 4))
						)
					))
				)
			),

			'G sharp harmonic minor' => array(
				'scale' => 2477,
				'root' => new \ianring\Pitch('G', 1, 3),
				'expected' => array(
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'G', 'alter' => 1, 'octave' => 3)),
							array('pitch' => array('step' => 'B', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'D', 'alter' => 1, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'A', 'alter' => 1, 'octave' => 3)),
							array('pitch' => array('step' => 'C', 'alter' => 1, 'octave' => 4)),
							array('pitch' => array('step' => 'E', 'alter' => 0, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'B', 'alter' => 0, 'octave' => 3)),
							array('pitch' => array('step' => 'D', 'alter' => 1, 'octave' => 4)),
							array('pitch' => array('step' => 'F', 'alter' => 2, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'C', 'alter' => 1, 'octave' => 4)),
							array('pitch' => array('step' => 'E', 'alter' => 0, 'octave' => 4)),
							array('pitch' => array('step' => 'G', 'alter' => 1, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'D', 'alter' => 1, 'octave' => 4)),
							array('pitch' => array('step' => 'F', 'alter' => 2, 'octave' => 4)),
							array('pitch' => array('step' => 'A', 'alter' => 1, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'E', 'alter' => 0, 'octave' => 4)),
							array('pitch' => array('step' => 'G', 'alter' => 1, 'octave' => 4)),
							array('pitch' => array('step' => 'B', 'alter' => 0, 'octave' => 4))
						)
					)),
					\ianring\Chord::constructFromArray(array(
						'notes' => array(
							array('pitch' => array('step' => 'F', 'alter' => 2, 'octave' => 4)),
							array('pitch' => array('step' => 'A', 'alter' => 1, 'octave' => 4)),
							array('pitch' => array('step' => 'C', 'alter' => 1, 'octave' => 5))
						)
					))
				)
			),

		);

	}


	/**
	 * @dataProvider provider_modes
	 */
	public function test_modes($scale, $includeSelf, $unique, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->modes($includeSelf, $unique);
		$this->assertEquals($actual, $expected);
	}
	public function provider_modes() {
		return array(
			array(
				'scale' => 1841,
				'includeSelf' => false,
				'unique' => false,
				'expected' => array(371, 2233, 791, 2443, 3269)
			),
			array(
				'scale' => 2741,
				'includeSelf' => false,
				'unique' => false,
				'expected' => array(1709, 1451, 2773, 1717, 1453, 1387)
			),			
			array(
				'scale' => 2741,
				'includeSelf' => true,
				'unique' => false,
				'expected' => array(2741, 1709, 1451, 2773, 1717, 1453, 1387)
			),			
			'chromatic' => array(
				'scale' => 4095,
				'includeSelf' => false,
				'unique' => false,
				'expected' => array() // nothing to show!
			),
			'chromatic with self' => array(
				'scale' => 4095,
				'includeSelf' => true,
				'unique' => false,
				'expected' => array(4095)
			),
			'chromatic unique' => array(
				'scale' => 4095,
				'includeSelf' => true,
				'unique' => true,
				'expected' => array(4095)
			),
			'whole tone' => array(
				'scale' => 1365,
				'includeSelf' => false,
				'unique' => false,
				'expected' => array() // nothing!
			),
			'whole tone with self' => array(
				'scale' => 1365,
				'includeSelf' => true,
				'unique' => false,
				'expected' => array(1365)
			),
			'whole tone unique' => array(
				'scale' => 1365,
				'includeSelf' => false,
				'unique' => true,
				'expected' => array()
			),
			'octatonic' => array(
				'scale' => 1755,
				'includeSelf' => false,
				'unique' => false,
				'expected' => array(2925)
			),
			'octatonic with self' => array(
				'scale' => 1755,
				'includeSelf' => true,
				'unique' => false,
				'expected' => array(1755, 2925)
			),
			'octatonic unique' => array(
				'scale' => 1755,
				'includeSelf' => false,
				'unique' => true,
				'expected' => array(2925)
			),
			'octatonic with self unique' => array(
				'scale' => 1755,
				'includeSelf' => true,
				'unique' => true,
				'expected' => array(1755, 2925)
			),

		);

	}

	/**
	 * @dataProvider provider_hemitonics
	 */
	public function test_hemitonics($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->hemitonics();
		$this->assertEquals($expected, $actual);
	}
	public function provider_hemitonics() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	bindec('100000010000')
			),
			array(
				'scale' => 		bindec('010101010101'),
				'expected' => 	bindec('000000000000')
			),
			array(
				'scale' => 		bindec('111111111111'),
				'expected' => 	bindec('111111111111')
			),
			array(
				'scale' => 		bindec('111111111110'),
				'expected' => 	bindec('011111111110')
			),
		);

	}


	/**
	 * @dataProvider provider_cohemitonics
	 */
	public function test_cohemitonics($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->cohemitonics();
		$this->assertEquals($expected, $actual);
	}
	public function provider_cohemitonics() {
		return array(
			array(
				'scale' => 		bindec('111011011101'),
				'expected' => 	bindec('011000000100')
			),
			array(
				'scale' => 		bindec('011011011101'),
				'expected' => 	bindec('000000000100')
			),
			array(
				'scale' => 		bindec('000011100000'),
				'expected' => 	bindec('000000100000')
			),
			array(
				'scale' => 		bindec('010101010101'),
				'expected' => 	bindec('000000000000')
			),
			array(
				'scale' => 		bindec('111111111111'),
				'expected' => 	bindec('111111111111')
			),
			array(
				'scale' => 		bindec('111111111110'),
				'expected' => 	bindec('001111111110')
			),
		);

	}

	/**
	 * @dataProvider provider_intervalPattern
	 */
	public function test_intervalPattern($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->intervalPattern();
		$this->assertEquals($expected, $actual);
	}
	public function provider_intervalPattern() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	array(2,2,1,2,2,2,1)
			),
			array(
				'scale' => 		bindec('010101010101'),
				'expected' => 	array(2,2,2,2,2,2)
			),
			array(
				'scale' => 		bindec('111111111111'),
				'expected' => 	array(1,1,1,1,1,1,1,1,1,1,1,1)
			),
		);

	}

	// public function test_justThePopularOnes() {
	// 	$pop = \ianring\Scale::justThePopularOnes();
	// 	var_dump($pop);
	// }


	/**
	 * @dataProvider provider_invert
	 */
	public function test_invert($scale, $axis, $expected) {
		$scale = new \ianring\Scale($scale, null);
		$scale->invert($axis);
		$this->assertEquals($expected, $scale->scale);
	}
	public function provider_invert() {
		return array(
			array(
				'scale' => bindec('101010110101'),
				'axis' => 0,
				'expected' => bindec('010110101011')
			),
			array(
				'scale' => bindec('111111111111'),
				'axis' => 0,
				'expected' => bindec('111111111111')
			),
			array(
				'scale' => bindec('010101010101'),
				'axis' => 0,
				'expected' => bindec('010101010101')
			),
			array(
				'scale' => bindec('110000011111'),
				'axis' => 0,
				'expected' => bindec('111100000111')
			),
			array(
				'scale' => bindec('110000011111'),
				'axis' => 0,
				'expected' => bindec('111100000111')
			),
			array(
				'scale' => bindec('101010110101'),
				'axis' => 1,
				'expected' => bindec('011010101101')
			),
			array(
				'scale' => bindec('101010110101'),
				'axis' => 2,
				'expected' => bindec('101010110101')
			),
			array(
				'scale' => bindec('101010110101'),
				'axis' => 6,
				'expected' => bindec('010110101011')
			),

			array(
				'scale' => bindec('111000111001'),
				'axis' => 0,
				'expected' => bindec('001110001111')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 1,
				'expected' => bindec('111000111100')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 2,
				'expected' => bindec('100011110011')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 3,
				'expected' => bindec('001111001110')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 4,
				'expected' => bindec('111100111000')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 5,
				'expected' => bindec('110011100011')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 6,
				'expected' => bindec('001110001111')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 7,
				'expected' => bindec('111000111100')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 8,
				'expected' => bindec('100011110011')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 9,
				'expected' => bindec('001111001110')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 10,
				'expected' => bindec('111100111000')
			),
			array(
				'scale' => bindec('111000111001'),
				'axis' => 11,
				'expected' => bindec('110011100011')
			),


		);
	}




	/**
	 * @dataProvider provider_containsPitch
	 */
	public function test_containsPitch($scale, $root, $pitch, $strict, $expected) {
		$scale = new \ianring\Scale($scale, $root);
		$actual = $scale->containsPitch($pitch, $strict);
		$this->assertEquals($expected, $actual);
	}
	public function provider_containsPitch() {
		return array(
			array(
				'scale' => bindec('111011011101'),
				'root' => new \ianring\Pitch('C', 0, 4),
				'pitch' => new \ianring\Pitch('C', 0, 4),
				'strict' => false,
				'expected' => 	true
			),
			array(
				'scale' => bindec('001110110111'),
				'root' => new \ianring\Pitch('C', 0, 4),
				'pitch' => new \ianring\Pitch('C', 1, 4),
				'strict' => false,
				'expected' => 	true
			),
			array(
				'scale' => bindec('001110110111'),
				'root' => new \ianring\Pitch('C', 0, 4),
				'pitch' => new \ianring\Pitch('D', -1, 4),
				'strict' => false,
				'expected' => 	true
			),
			array(
				'scale' => bindec('001110110011'),
				'root' => new \ianring\Pitch('C', 0, 4),
				'pitch' => new \ianring\Pitch('D', -1, 4),
				'strict' => true,
				'expected' => 	true
			),
		);

	}


	/**
	 * @dataProvider provider_isTrueScale
	 */
	public function test_isTrueScale($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->isTrueScale();
		$this->assertEquals($expected, $actual);
	}
	public function provider_isTrueScale() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	true
			),
		);

	}

	/**
	 * @dataProvider provider_isHemitonic
	 */
	public function test_isHemitonic($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->isHemitonic();
		$this->assertEquals($expected, $actual);
	}
	public function provider_isHemitonic() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	true
			),
		);

	}

	/**
	 * @dataProvider provider_isCohemitonic
	 */
	public function test_isCohemitonic($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->isCohemitonic();
		$this->assertEquals($expected, $actual);
	}
	public function provider_isCohemitonic() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	false
			),
		);

	}

	/**
	 * @dataProvider provider_isTritonic
	 */
	public function test_isTritonic($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->isTritonic();
		$this->assertEquals($expected, $actual);
	}
	public function provider_isTritonic() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	true
			),
		);

	}

	/**
	 * @dataProvider provider_zRelated
	 */
	public function test_zRelated($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->zRelated();
		$this->assertEquals($expected, $actual);
	}
	public function provider_zRelated() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	null
			),
		);

	}

	/**
	 * @dataProvider provider_scaletype
	 */
	public function test_scaletype($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->scaletype();
		$this->assertEquals($expected, $actual);
	}
	public function provider_scaletype() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	'heptatonic'
			),
			array(
				'scale' => 		bindec('101110110101'),
				'expected' => 	'octatonic'
			),
		);

	}


	/**
	 * @dataProvider provider_hemitonia
	 */
	public function test_hemitonia($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->hemitonia();
		$this->assertEquals($expected, $actual);
	}
	public function provider_hemitonia() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	'dihemitonic'
			),
			array(
				'scale' => 		bindec('101110110101'),
				'expected' => 	'multihemitonic'
			),
		);

	}


	/**
	 * @dataProvider provider_cohemitonia
	 */
	public function test_cohemitonia($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->cohemitonia();
		$this->assertEquals($expected, $actual);
	}
	public function provider_cohemitonia() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	'ancohemitonic'
			),
			array(
				'scale' => 		bindec('101110110101'),
				'expected' => 	'uncohemitonic'
			),
			array(
				'scale' => 		bindec('101110111001'),
				'expected' => 	'dicohemitonic'
			),
			array(
				'scale' => 		bindec('000001111001'),
				'expected' => 	'dicohemitonic'
			),
			array(
				'scale' => 		bindec('110001111001'),
				'expected' => 	'tricohemitonic'
			),
		);

	}


	/**
	 * @dataProvider provider_negative
	 */
	public function test_negative($scale, $prime, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->negative($prime);
		$this->assertEquals($expected, $actual);
	}
	public function provider_negative() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'prime' => false,
				'expected' => 	bindec('010101001010')
			),
			array(
				'scale' => 		bindec('101010110101'),
				'prime' => true,
				'expected' => 	661
			),
		);

	}


	/**
	 * @dataProvider provider_primeForm
	 */
	public function test_primeForm($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->primeForm();
		$this->assertEquals($expected, $actual);
	}
	public function provider_primeForm() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	1387
			),
			array(
				'scale' => 		bindec('101110110101'),
				'expected' => 	1467
			),
		);

	}


	/**
	 * @dataProvider provider_isPrime
	 */
	public function test_isPrime($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->isPrime();
		$this->assertEquals($expected, $actual);
	}
	public function provider_isPrime() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	false
			),
			array(
				'scale' => 		bindec('101110110101'),
				'expected' => 	false
			),
		);

	}


	/**
	 * @dataProvider provider_containsStep
	 */
	public function test_containsStep($pitches, $step, $expected) {
		$actual = \ianring\Scale::containsStep($pitches, $step);
		$this->assertEquals($expected, $actual);
	}
	public function provider_containsStep() {
		return array(
			array(
				'pitches' => array(
					new \ianring\Pitch("C", 0, 4)
				),
				'step' => 'E',
				'expected' => false
			),
		);
	}


	/**
	 * @dataProvider provider_name
	 */
	public function test_name($scale, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->name();
		$this->assertEquals($expected, $actual);
	}
	public function provider_name() {
		return array(
			array(
				'scale' => 		bindec('101010110101'),
				'expected' => 	'Major'
			),
			array(
				'scale' => 		bindec('101110110101'),
				'expected' => 	'Major Bebop'
			),
		);

	}

	/**
	 * @dataProvider provider_resolveScaleFromString
	 */
	public function test_resolveScaleFromString($string, $expected) {
		$actual = \ianring\Scale::resolveScaleFromString($string);
		$this->assertEquals($expected, $actual);
	}
	public function provider_resolveScaleFromString() {
		return array(
			array(
				'string' => 'Major Bebop',
				'expected' => 	array(
					'step' => 'C',
					'alter' => 0,
					'scale' => 2997,
				)
			),
			array(
				'string' => 	'C Major Bebop',
				'expected' => 	array(
					'step' => 'C',
					'alter' => 0,
					'scale' => 2997,
				)
			),
			array(
				'string' => 	'C# Major Bebop',
				'expected' => 	array(
					'step' => 'C',
					'alter' => 1,
					'scale' => 2997,
				)
			),
			array(
				'string' => 	'C # Major Bebop',
				'expected' => 	array(
					'step' => 'C',
					'alter' => 1,
					'scale' => 2997,
				)
			),
			array(
				'string' => 'Csharp Major Bebop',
				'expected' => 	array(
					'step' => 'C',
					'alter' => 1,
					'scale' => 2997,
				)
			),
			array(
				'string' => 'C sharp Major Bebop',
				'expected' => 	array(
					'step' => 'C',
					'alter' => 1,
					'scale' => 2997,
				)
			),
			array(
				'string' => 'Cb melodic minor',
				'expected' => array(
					'step' => 'C',
					'alter' => -1,
					'scale' => 2733,
				)
			),
			array(
				'string' => 'C FLAT Kannadabangala',
				'expected' => 	array(
					'step' => 'C',
					'alter' => -1,
					'scale' => 435,
				)
			),
		);

	}


	/**
	 * @dataProvider provider_findIntervalics
	 */
	public function test_findIntervalics($scale, $interval, $expected) {
		$scale = new \ianring\Scale($scale);
		$actual = $scale->findIntervalics($interval);
		$this->assertEquals($expected, $actual);
	}
	public function provider_findIntervalics() {
		return array(
			array(
				'scale' => bindec('101010110101'),
				'interval' => 1,
				'expected' => bindec('100000010000'),
			),
			array(
				'scale' => bindec('101010110101'),
				'interval' => 2,
				'expected' => bindec('001010100101'),
			),
			array(
				'scale' => bindec('000000100001'),
				'interval' => 5,
				'expected' => bindec('000000000001'),
			),
			array(
				'scale' => bindec('000001100011'),
				'interval' => 5,
				'expected' => bindec('000000000011'),
			),
			array(
				'scale' => bindec('010001100011'),
				'interval' => 5,
				'expected' => bindec('000000100011'),
			),
		);

	}


}
