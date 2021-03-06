<?php
/**
 * this script uses vexflow and <canvas> to render the image, then sends the canvas drawing to 
 * the server to be saved as a PNG. Requires that you remove the precautionary die() from the
 * beginning of canvas_save.php
 */

ini_set('display_errors', true);
error_reporting(E_ALL);

?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="../demo/vexflow/vexflow-debug.js"></script>
</head>

</head>
<body>

<?php
// see how easy it is to create a power set?
$allscales = range(0, 4095);

		// how about a little inline PHP to illustrate this. booyah!
		foreach ($allscales as $index => $set) {
			// remove if the root is not in it - ie the lowest bit is not turned on
			if ((1 & $index) == 0) {
				unset($allscales[$index]);
			}
		}

		// for convenience we'll populate the array with the set of tones that are turned on
		foreach ($allscales as $index => $set) {
			$allscales[$index] = array();
			$newset = array();

			for ($i = 0; $i < 12; $i++) {
				if ($index & (1 << ($i))) {
					$newset[] = $i;
				}
			}

			$allscales[$index]['tones'] = $newset;
		}


		$maxinterval = 4;
		foreach ($allscales as $index => $set) {
			// Here is where that earlier step comes in handy. It's easier to analyze the precomputed array
			// than it is to do all this using the binary bitmask
			$setsize = count($set['tones']);
			for ($i = 0; $i < $setsize-1; $i++) {
				// find the distance between this note and the one above it
				if ($set['tones'][$i+1] - $set['tones'][$i] > $maxinterval) {
					unset($allscales[$index]);
				}
			}
			// and check the last one too
			if (12 - $set['tones'][$setsize-1] > $maxinterval) {
				unset($allscales[$index]);
			}
		}
		?>

<?php
foreach ($allscales as $index => $set) {

		echo '<canvas id="vf'.$index.'" width="500" height="100"></canvas>';
		echo '<script>
		var canvas = $("#vf' . $index . '")[0];
		var renderer = new Vex.Flow.Renderer(canvas, Vex.Flow.Renderer.Backends.CANVAS);
		var ctx = renderer.getContext();
		var stave = new Vex.Flow.Stave(10, 0, 450);
		stave.addClef("treble").setContext(ctx).draw();
		  var notes = [
		 ';
		foreach ($set['tones'] as $tone) {
			$pitch = tone2pitch($tone);
		    echo 'new Vex.Flow.StaveNote({ keys: ["' . $pitch['letter'] . '"], duration: "w" })';
		    if (!is_null($pitch['accidental'])) {
		    	echo '.addAccidental(0, new Vex.Flow.Accidental("'.$pitch['accidental'].'"))';
		    }
		    echo ',';
		    echo "\n";
		}
		echo '
		  ];
		  var voice = new Vex.Flow.Voice({
		    num_beats: '.count($set['tones']).',
		    beat_value: 1,
		    resolution: Vex.Flow.RESOLUTION
		  });
		  voice.addTickables(notes);
		  var formatter = new Vex.Flow.Formatter().joinVoices([voice]).format([voice], 400);
		  voice.draw(ctx, stave);

		  // var canvas = document.getElementById("vf'.$index.'");
		  // var img    = canvas.toDataURL("image/png");
		  // document.write(\'<img src="\'+img+\'"/>\');

			// var canvasData = canvas.toDataURL("image/png");

			// $.ajax({
			// 	contentType: \'application/x-www-form-urlencoded\',
			// 	url: \'canvas_save.php\',
			// 	data: {
			// 		\'canvas\': canvasData	,
			// 		\'filename\':\''.$index.'.png\'
			// 	},
			// 	\'type\':\'post\'
			// });
		</script>
		';
}

function tone2pitch($tone) {
	$pitches = array(
		0 => array('letter' => 'c/4', 'accidental' => null),
		1 => array('letter' => 'c#/4', 'accidental' => '#'),
		2 => array('letter' => 'd/4', 'accidental' => null),
		3 => array('letter' => 'd#/4', 'accidental' => '#'),
		4 => array('letter' => 'e/4', 'accidental' => null),
		5 => array('letter' => 'f/4', 'accidental' => null),
		6 => array('letter' => 'f#/4', 'accidental' => '#'),
		7 => array('letter' => 'g/4', 'accidental' => null),
		8 => array('letter' => 'g#/4', 'accidental' => '#'),
		9 => array('letter' => 'a/4', 'accidental' => null),
		10 => array('letter' => 'a#/4', 'accidental' => '#'),
		11 => array('letter' => 'b/4', 'accidental' => null),
	);
	return $pitches[$tone];
}


?>
</body>
</html>

