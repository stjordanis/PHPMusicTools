<?php
namespace ianring;
require_once 'PMTObject.php';
require_once 'Accidental.php';

/**
 * Pitch is the conceptual represtation of sound frequency. It's the property of a note that describes its pitch.
 * It's not the same as frequency -- because a "G flat" might be tuned differently in various temperaments or
 * instruments. Pitch is what we would call "G flat". Not only do we care about the tone's height, but we also
 * care about its "spelling", i.e. whether something is a G flat or an F sharp. For this reason the class uses
 * the properties defined by MusicXML, which are "step", "alter", and "octave".
 *
 * An octave begins and ends with C.
 * Therefore C4 is the note immediately above B3.
 * The octave does not belong to the step. It is a measurement of what height range the tone is
 * in, not dependent on its spelling.
 * Therefore the enharmonic of C4 is not B#3, it is B#4.
 * C-3 is not in the same octave as the C natural beside it.
 *
 * LILYPOND disagrees with this - it attaches the octave to its step. So in lilypond,
 * bis'' is the note above b''
 *
 * Chromas are numbered 0 to 11, these are the chromatic tones from 0 = C to 11 = B. This is congruent with
 * a lot of the work in post-tonal theory.
 *
 * For some calculations, this class defines a "note number", which is an integer line with its arbitrary
 * origin on middle C. Middle C is zero.
 * going up, C#4 is 1, D4 is 2...
 * going down, B3 is -1, A#3 is -2...
 *
 * MIDI also defines a standard note number, based on an origin point on the C below the range of a piano.
 *
 */
class Pitch extends PMTObject
{

    public function __construct($step = 'C', $alter = 0, $octave = 4) {
        $this->step = $step;
        $this->alter = $alter;
        $this->octave = $octave;
    }

    /**
     * accepts the object in the form of an array structure
     *
     * @param  [winged] $scale [description]
     * @return [winged]        [description]
     */
    public static function constructFromArray($props) {
        $step = $props['step'];
        $alter = $props['alter'];
        $octave = $props['octave'];
        return new Pitch($step, $alter, $octave);
    }

    /**
     * accepts the object in the form of a string
     *
     * @param  [winged] $scale [description]
     * @return [winged]        [description]
     */
    public static function constructFromString($string) {
        $props = self::_resolvePitchString($string);
        return self::constructFromArray($props);
    }

    public static function constructFromMidiNumber($num, $preferredAlteration = 1) {
        $pitch = new \ianring\Pitch('C', 0, -1);
        $pitch->transpose($num, $preferredAlteration);
        return $pitch;
    }


    public static function parseFromXmlObject($obj) {
        /**
         [pitch] => SimpleXMLElement Object
            (
             [step] => C
             [octave] => 5
            )
         */
        $step = $obj->step;
        $alter = $obj->alter;
        $octave = $obj->octave;

        return new Pitch($step, $alter, $octave);

    }

    /**
     * gives the interval between this pitch and the given one.
     * 0 means the pitches are enharmonic.
     * &lt; 0 means the interval is downward,
     * &gt; 0 means the interval is upward
     *
     * @param  Pitch $pitch the pitch being checked
     * @param  bool $heightless if this is true, then we check the interval as heightless pitches, returning the smaller one.
     *                          if either of the pitches being checked is heightless, then this is forced to true
     * @return integer the interval in semitones
     */
    public function interval($pitch, $heightless = false) {
    	if ($pitch === null) {
    		return 0;
    	}
        // gotta be a strict equals, so it handles octave = 0
    	if ($pitch->octave === null || $this->octave === null) {
    		$heightless = true;
    	}
    	if ($heightless) {
    		$pitch->octave = 0;
    		$copy = clone $this;
    		$copy->octave = 0;
    		$interval = $pitch->toNoteNumber() - $this->toNoteNumber();
    		while ($interval < 0) {
    			$interval += 12;
    		}
    		if ($interval > 7) {
    			$interval = 12 - $interval;
    		}
    		return $interval;
    	} else {
	        return $pitch->toNoteNumber() - $this->toNoteNumber();
    	}
    }

    /**
     * returns true if $this is lower than the provided pitch
     *
     * @param  Pitch $pitch the pitch being checked
     * @return boolean       true if $this is lower than $pitch
     */
    public function isLowerThan($pitch) {
        if ($pitch === null) {
            return true;
        }
        return $this->interval($pitch) > 0;
    }

    /**
     * returns true if $this is higher than the provided pitch
     *
     * @param  Pitch $pitch the pitch being checked
     * @return boolean       true if $this is higher than $pitch
     */
    public function isHigherThan($pitch) {
        if ($pitch === null) {
			return true;
		}
        return $this->interval($pitch) < 0;
    }
    /**
     * returns true if $this is enharmonic with the provided pitch
     *
     * @param  Pitch $pitch [description]
     * @return boolean        [description]
     */
    public function isEnharmonic($pitch) {
        if ($pitch === null) {
			return false;
		}
        return $this->interval($pitch) == 0;
    }

    /**
     * note the difference between this and isEnharmonic - in this one, spelling counts.
     *
     * @param  Pitch $pitch The pitch being compared to $this
     * @return boolean true if the step, alter, and octave are all the same.
     */
    public function equals($pitch) {
        if ($pitch === null) {
			return false;
		}
        return $pitch->step == $this->step && $pitch->alter == $this->alter && $pitch->octave == $this->octave;
    }

    /**
     * returns a pitch's chroma as an integer. e.g. C = 0, C# = 1, D = 2, up to B = 11
     *
     * @return int The chrome of the pitch as an integer from 0 to 11
     */
    public function chroma() {
        $steps = array('C' => 0, 'D' => 2, 'E' => 4, 'F' => 5, 'G' => 7, 'A' => 9, 'B' => 11);
        $chroma = $steps[$this->step];
        $chroma += $this->alter;
        $chroma = $this->_truemod($chroma, 12);
        return $chroma;
    }

    /**
     * gives the step above the current one. e.g. given D, returns E. Given G, returns A.
     *
     * @param  [type] $step [description]
     * @return [type]       [description]
     */
    public static function stepUp($step, $distance = 1) {
        $steps = 'CDEFGABCDEFGABC';
        $distance = $distance % 7;
        $pos = strpos($steps, $step);
        return substr($steps, $pos+$distance, 1);
    }
    /**
     * gives the step below the current one. e.g. given E, returns D. Given A, returns G.
     *
     * @param  [type] $step [description]
     * @return [type]       [description]
     */
    public static function stepDown($step, $distance = 1) {
        $steps = 'CBAGFEDCBAGFEDC';
        $distance = $distance % 7;
        $pos = strpos($steps, $step);
        return substr($steps, $pos+$distance, 1);
    }

    /**
     * measures how many steps distant upwards, e.g. if pitch is C, the step distance to G is 4.
     * Ignores alterations. So, a C double-flat to G sharp is also 4.
     * BEWARE that this is a distance, not an interval!
     * The distance of 4 means it's 4 steps up (which is like a fifth), not an inteval of a 4th.
     * Return value will always be an integer from 0 to 6.
     * @param  string $step the step name, like A or D
     * @return int       the number of steps up
     */
    function stepUpDistance($step) {
        $step = strtoupper($step);
        $steps = 'CDEFGABCDEFGAB';
        // first instance of the step
        $pos = strpos($steps, $this->step);
        $pos2 = strpos($steps, $step, $pos);
        return $pos2-$pos;
    }

    /**
     * literally just the inversion of stepUpDistance.
     * @param  [type] $step [description]
     * @return [type]       [description]
     */
    function stepDownDistance($step) {
        $up = $this->stepUpDistance($step);
        return (7 - $up) % 7;
    }

    /**
     * Changes a pitch so it is spelled enharmonically using the provided step; in other words it will
     * change the step but adjust the alter. This is basically designed to turn an F natural into an E sharp when
     * in the context of a C# major scale.
     *
     * The enharmonic should always convert to the nearest tone, whether that's up or down. It would be
     * weird to enharmonicize a C sharp to an F quadruple-flat, but theoretically that's what this function would do.
     *
     * For example. For a pitch of F#, enharmonicizing to step "G" will produce G flat.
     * For a pitch D natural, enharmonisizing to step "C" produces a C double-sharp.
     *
     * @param  [type] $pitch [description]
     * @param  [type] $step  [description]
     * @return [type]        [description]
     */
    function enharmonicizeToStep($step) {
        if ($this->step == $step) {
            return $this;
        }
        $up = $this->closestUp($step, 0, true);
        $down = $this->closestDown($step, 0, true);
        $intervalup = $this->interval($up);
        $intervaldown = $this->interval($down);
        $newpitch = abs($intervalup) > abs($intervaldown) ? $down : $up;
        $interval = $this->interval($newpitch);
        $this->step = $step;
        $this->alter = ($interval * -1);
        return $this;
    }

    public static $chromas = array(
        0 => 'C',
        1 => array(
            1 => array('step' => 'C', 'alter' => 1),
            -1 => array('step' => 'D', 'alter' => -1)
        ),
        2 => 'D',
        3 => array(
            1 => array('step' => 'D', 'alter' => 1),
            -1 => array('step' => 'E', 'alter' => -1),
        ),
        4 => 'E',
        5 => 'F',
        6 => array(
            1 => array('step' => 'F', 'alter' => 1),
            -1 => array('step' => 'G', 'alter' => -1),
        ),
        7 => 'G',
        8 => array(
            1 => array('step' => 'G', 'alter' => 1),
            -1 => array('step' => 'A', 'alter' => -1),
        ),
        9 => 'A',
        10 => array(
            1 => array('step' => 'A', 'alter' => 1),
            -1 => array('step' => 'B', 'alter' => -1),
        ),
        11 => 'B'
    );


    public function isHeightless() {
        return $this->octave === null;
    }

    /**
     * renders this object as MusicXML
     *
     * @return string MusicXML representation of the object
     */
    public function toMusicXML() {
        if ($this->isHeightless()) {
            throw new PitchHeightlessAsXMLException();
        }

        $out = '<pitch>';

        $out .= '<step>' . $this->step . '</step>';
        $out .= '<alter>' . $this->alter . '</alter>';
        $out .= '<octave>' . $this->octave . '</octave>';

        $out .= '</pitch>';

        return $out;
    }

    /**
     * interprets a string like "C#4" or "Gbb"
     *
     * @param  [type] $string [description]
     * @return [type]        [description]
     */
    private static function _resolvePitchString($string) {
        if (is_array($string)) {
            return $string;
        }

        // first split off the octave part, if there is one.
        preg_match('|([ABCDEFGabcdefg]?)([\+#\-b]?[\+#\-b]?)(\d?)|', $string, $matches);

        $step = $matches[1];
        $octave = $matches[3];

        switch ($matches[2]) {
			case '##':
			case '++':
				$alter = 2;
				break;
			case '#':
			case '+':
				$alter = 1;
				break;
			case 'b':
			case '-':
				$alter = -1;
				break;
			case 'bb':
			case '--':
				$alter = -2;
				break;
			default:
				$alter = 0;
        }

        $properties = array(
            'step' => $step,
            'alter' => $alter,
            'octave' => $octave
        );

        return $properties;
    }


    /**
     * transposes a Pitch up or down by $interval semitones.
     *
     * @param  integer $interval            a signed integer telling how many semitones to transpose up or down
     * @param  integer $preferredAlteration either 1, or -1 to indicate whether the transposition should prefer sharps or flats.
     * @return null
     */
    public function transpose($interval, $preferredAlteration = 1) {
        $isHeightless = $this->isHeightless();
        if (!in_array($preferredAlteration, array(1, -1))) {
            $preferredAlteration = 1; // default to prefer sharps.
        }
        if ($isHeightless) {
            $this->octave = 4; // just choose some arbitrary octave to use for calculations
        }
        $num = self::toNoteNumber($this);
        $num += $interval;
        $this->noteNumberToPitch($num, $preferredAlteration);

        if ($isHeightless) {
            // set it back the way it was
            $this->octave = null;
        }
        // return the pitch so we can do chaining
        return $this;
    }

    /**
     * Inverts this pitch around an axis.
     * For example, if I invert C4 around E4, the result is G#4.
     * When I invert G4 around E4, the result is C#4.
     * The tricky part in this is to get the step and alterations right. Not only must the
     * inversion be the right pitch, but the spelling of it must be proper. The unit tests
     * illustrate examples.
     * @param  Pitch  $axis the axis around which to invert
     * @return Pitch  $this, for chaining.
     */
    public function invert($axis) {
        if ($this->isHeightless()) {
            return $this;
        }
        $interval = $this->interval($axis);
        $stepDistance = $this->stepUpDistance($axis->step);
        $newstep = self::stepUp($axis->step, $stepDistance);
        $this->transpose($interval);
        $this->transpose($interval);
        $this->enharmonicizeToStep($newstep);
        return $this;
    }


    /**
     * translates a pitch properties into a signed integer, arbitrarily centered with zero on middle C
     *
     * @param  Pitch $pitch
     * @return int pitch number, useful for doing calculcations
     */
    public function toNoteNumber() {
        $chromas = array('C' => 0, 'D' => 2, 'E' => 4, 'F' => 5, 'G' => 7, 'A' => 9, 'B' => 11);
        $num = ($this->octave - 4) * 12;
        $num += $chromas[$this->step];
        $num += $this->alter; // adds a sharp or flat, e.g. 1 = sharp, -1 = flat, -2 = double-flat...
        return $num;
    }


    /**
     * accepts a note number and sets the pitch properties
     *
     * @param  integer $noteNumber          signed integer with origin zero as middle C4
     * @param  integer $preferredAlteration 1 for sharp or -1 for flats
     * @return array                       returns a pitch array, containing step and alter elements.
     */
    public function noteNumberToPitch($noteNumber, $preferredAlteration = 1) {
        $chroma = $this->_truemod($noteNumber, 12); // chroma is the note pitch independent of octave, eg C = 0, Eb/D# = 3, E = 4
        $octave = (($noteNumber - $chroma) / 12) + 4;
        $this->octave = $octave;

        if (is_array(self::$chromas[$chroma])) {
            if ($preferredAlteration == 1) {
                $this->step = self::$chromas[$chroma][1]['step'];
                $this->alter = self::$chromas[$chroma][1]['alter'];
            } else {
                $this->step = self::$chromas[$chroma][-1]['step'];
                $this->alter = self::$chromas[$chroma][-1]['alter'];
            }
        } else {
            $this->step = self::$chromas[$chroma];
            $this->alter = 0;
        }
    }

    /**
     * returns an absolute pitch string suitable for using in Lilypond
     *
     * @return [type] [description]
     * @todo  needs to handle double-flats and double-sharps too
     */
    public function toLilypond() {
        $out = strtolower($this->step);
        if ($this->alter == 2) {
            $out .= 'isis';
        }
        if ($this->alter == 1) {
            $out .= 'is';
        }
        if ($this->alter == -1) {
            $out .= 'es';
        }
        if ($this->alter == -2) {
            $out .= 'eses';
        }

        // contrary to the standards in this class, lilypond thinks that B sharp belongs in the same
        // octave as the neighbouring B natural. So we have to adjust those specifically
        $octave = $this->octave;
        if ($this->step == 'B' && $this->alter > 0) {
            $octave--;
        }
        // the same must be done for C flats
        if ($this->step == 'C' && $this->alter < 0) {
            $octave++;
        }

        if ($octave > 3) {
            $out .= str_repeat("'", $octave - 3);
        } else {
            $out .= str_repeat(",", 3 - $octave);
        }
        return $out;
    }

    /**
     * returns the MIDI note number of a pitch.
     * MIDI notes are numbered from 0 (C-1) to 127 (G9)
     *
     * @return int
     * @todo
     */
    public function toMidiKeyNumber() {
        $o = new Pitch('C', 0, -1);
        return $o->interval($this);
    }

    /**
     * returns the frequency of a pitch in Hz
     *
     * @param  string  $tuning presumably we would want to be able to do this for more than just Equal Temperament
     * @param  integer $a      the frequency of "A", in case someone wants to use something other than the standard 440Hz
     * @return number           the frequency in Hz
     */
    public function toFrequency($tuning = 'equal', $a = 440, $precision = 2) {
        $ap = new Pitch('A', 0, 4);
        $n = $ap->interval($this); // get the interval between our note and A
        $s = pow(2, (1/12)); // the twelfth root of 2
        $p = pow($s, $n); // raised to the power of the interval in semitones
        $f = $p * $a; // multiplied by the frequency of "A"
        $f = round($f, $precision, PHP_ROUND_HALF_UP);
        return $f;
    }

    /**
     * returns the pitch in Helmoltz notation, e.g. C,, d' F# g#''
     * see https://en.wikipedia.org/wiki/Helmholtz_pitch_notation
     * or http://www.theoreticallycorrect.com/Helmholtz-Pitch-Numbering/
     */
    public function toHemholtz() {
        $str = $this->step;
        if ($this->octave < 3) {
            $str = strtoupper($str);
        } else {
            $str = strtolower($str);
        }

        switch ($this->alter) {
            case -2:
                $str .= 'bb';
                break;
            case -1:
                $str .= 'b';
                break;
            case 1:
                $str .= '#';
                break;
            case 2:
                $str .= '##';
                break;
            default:
                // nothing
        }
        if ($this->octave > 3) {
            $str .= str_repeat("'", $this->octave - 3);
        }
        if ($this->octave < 2) {
            $str .= str_repeat(",", ($this->octave * -1) + 2);
        }
        return $str;
    }

    /**
     * Finds the nearest pitch that is higher than (or equal), with a step and alter.
     * May be called with only one argument which is a heightless pitch.
     *
     * @param  string $step       The step we are moving to
     * @param  int    $alter      the alteration we are moving to
     * @param  bool   $allowEqual when the pitch matches the step and alter, (if true) return the same pitch or (if false) go up one octave
     * @return [type] [description]
     */
    public function closestUp($step = 'C', $alter = 0, $allowEqual = true) {
        // special case: if the first and only argument is a heightless Pitch.
        if (count(func_get_args()) == 1 && $step instanceof Pitch && $step->isHeightless()) {
            $alter = $step->alter;
            $step = $step->step;
        }

        $base = new Pitch($step, $alter, -6);
        for ($i=0; $i<25; $i++) {
            $base->transpose(12, $alter);
            if ($this->isLowerThan($base)) {
                return $base;
            }
            if ($allowEqual && $base->isEnharmonic($this)) {
                return $base;
            }
        }
        return null;
    }

    /**
     * finds the nearest pitch that is lower than or equal, with a step and alter.
     * May be called with only one argument which is a heightless pitch.
     *
     * @param  string $step       The step we are moving to
     * @param  int    $alter      the alteration we are moving to
     * @param  bool   $allowEqual when the pitch matches the step and alter, (if true) return the same pitch or (if false) go down one octave
     * @return [type] [description]
     */
    public function closestDown($step = 'C', $alter = 0, $allowEqual = true) {
        if (count(func_get_args()) == 1 && $step instanceof Pitch && $step->isHeightless()) {
            $alter = $step->alter;
            $step = $step->step;
        }
        $base = new Pitch($step, $alter, 20);
        for ($i=0; $i<25; $i++) {
            $base->transpose(-12, $alter);
            if ($this->isHigherThan($base)) {
                return $base;
            }
            if ($allowEqual && $base->isEnharmonic($this)) {
                return $base;
            }
        }
        // this may happen if the pitch is really high or low
        return null;
    }


    public function toVexFlowKey() {
        return strtolower($this->step) . Accidental::alterToVexFlow($this->alter) . '/' . $this->octave;
    }

    /**
     * This "reflects" a pitch across an axis, producing an opposite pitch.
     * Reflection alters this pitch by reference. It does not return a clone or a new Pitch.
     *
     * For example, if the axis is C and the pitch is E (a major 3 above), then the output is A flat
     * (a major 3 below).
     * The axis might be a Pitch, or it might be an array of two Pitches. If the latter then the axis is
     * actually a point half way between the two pitches. A typical example is to use a tonic-dominant
     * axis, e.g. C and G. The actual reflection point is half way between E and E flat.
     * Reflected across the axis, a C becomes a G, and G becomes a C. D becomes F, and D sharp becomes F flat.
     *
     * Polar reflection is used to mine new sonorities from series of plagal cadences (biii, bvii, IV, I), in
     * contrast to more conventional series of perfect cadences (vi, ii, V, I). In Jazz theory this has become
     * popularlized as "negative harmony".
     *
     * We should expect that a heightless pitch will reflect into another heightless pitch, an array of Pitches
     * should reflect into an array of Pitches, and that a Chord comprised of Notes with Pitches should reflect
     * into a Chord with its tones inverted.
     *
     * When spelling a reflected pitch, if the input Pitch is altered sharp, the reflection should prefer flats, and
     * vice versa.
     */
    public function polarReflection($axis) {
        if (is_null($axis)) {
            return null;
        }
        if (is_array($axis)) {
            $axisWidth = $axis[0]->interval($axis[1]);
            $offset = $this->interval($axis[0]);
            $transposeBy = ($offset * 2) + $axisWidth;
            $this->transpose($transposeBy);
        } else {
            $distance = $this->interval($axis);
            $transposeBy = $distance * 2;
            $this->transpose($transposeBy);
        }
    }

}
