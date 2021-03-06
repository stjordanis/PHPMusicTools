<?php
/**
 * Chord is a collection of notes that are sounded simultaneously, and which may share the same stem.
 *
 * @package ianring/PHPMusicTools
 * @author  Ian Ring <httpwebwitch@gmail.com>
 */

namespace ianring;
require_once 'PMTObject.php';
require_once 'Note.php';

class Chord extends PMTObject
{

    public $notes = array();

    /**
     * Constructor
     *
     * @param array notes And array of Note objects
     */
    public function __construct($notes = array()) {
        if (!is_array($notes)) {
            $notes = array($notes);
        }

        foreach ($notes as $note) {
            $this->addNote($note);
        }

    }


    /**
     * accepts the props object in the form of an array structure
     */
    public static function constructFromArray($props) {
        $notes = array();
        if (isset($props['notes'])) {
            foreach ($props['notes'] as $note) {
                if ($note instanceof Note) {
                    $notes[] = $note;
                } else {
                    $notes[] = Note::constructFromArray($note);
                }
            }
        }

        return new Chord($notes);

    }


    /**
     * transposes all the notes in this chord by $interval
     *
     * @param  integer $interval            a signed integer telling how many semitones to transpose up or down
     * @param  integer $preferredAlteration either 1, or -1 to indicate whether the transposition should prefer sharps or flats.
     * @return null
     */
    public function transpose($interval, $preferredAlteration = 1) {
        foreach ($this->notes as &$note) {
            $note->transpose($interval, $preferredAlteration);
        }

    }


    /**
     * adds a note to this chord
     *
     * @param array|Note $note
     */
    function addNote($note) {
        if (!$note instanceof Note) {
            $note = new Note($note);
        }

        $this->notes[] = clone $note;

    }


    function clear() {
        $this->notes = array();
    }


    /**
     * renders this object as MusicXML.
     *
     * @return string MusicXML representation of the object
     */
    function toMusicXML() {
        $out = '';
        $n   = 0;
        foreach ($this->notes as $note) {
            if (count($this->notes) > 1 && $n > 0) {
                $note->setProperty('chord', true);
            }

            $out .= $note->toMusicXML();
            $n++;
        }

        return $out;
    }



    /**
     * analyze the current chord, and return an array of all the Scales that its notes fit into.
     *
     * @param  Pitch $root if the root is known and we only want to learn about matching modes, provide a Pitch for the root.
     * @return [type] [description]
     */
    public function getScales($root=null) {
        $scales = Scale::getScales($this);

    }


    /**
     * returns an array of Pitch objects, for every pitch of every note in the chord.
     *
     * @param  boolean $heightless if true, will return heightless pitches all mudulo to the same octave. Useful for analysis, determining mode etc. analysis, determining mode etc.
     *                              analysis, determining mode etc.
     * @return array                a key for every pitch represented in string form (like "C#4" or "A-7", and inside that an array
     *                              of Pitch objects.
     */
    public function getAllPitches($heightless=false) {
        $pitches = array();

        foreach ($this->notes as $note) {
            $pitch = $note->properties['pitch'];
            if ($heightless) {
                $pitch->setProperty('octave', null);
            }

            $pitchStringKey = $pitch->toString();
            if (!is_array($pitches[$pitchStringKey])) {
                $pitches[$pitchStringKey] = array();
            }

            $pitches[$pitchStringKey][] = $pitch;
        }

        // dedupe + count
        return $pitches;

    }

    public function lowestMember() {
        $lowest = null;
        foreach ($this->notes as $note) {
            if ($lowest == null || $note->pitch->isLowerThan($lowest->pitch)) {
                $lowest = $note;
            }
        }
        return $lowest;
    }

    public function analyzeTriad($degree = 0) {
        // first turn our note pitches into numbers
        $numbers = array();
        foreach ($this->notes as $note) {
            $numbers[] = $note->pitch->toNoteNumber();
        }
        // put them in order ascending
        asort($numbers);
        // shift them all so the lowest note is a zero
        $lowest = $numbers[0];
        for ($i=0; $i<count($numbers); $i++) {
            $numbers[$i] += ($lowest * -1);
        }
        // turn it into a bitmask
        $bits = 0;
        foreach ($numbers as $number) {
            $bits = $bits | (1<<$number);
        }
        switch ($bits) {
            case 69:
                return 'diminished flat 3';
            case 73:
                return 'diminished';
            case 81:
                return 'major flat 5';
            case 137:
                return 'minor';
            case 145:
                return 'major';
            case 273:
                return 'augmented';
            default:
                return null;
        }

    }

    /**
     * renders a script fragment for a chord. What we want to end up with is a string that looks like this:
     *
     *      new Vex.Flow.StaveNote({ keys: ["c#/4","e/4","g#/4"], duration: "w" })
     *          .addAccidental(0, new Vex.Flow.Accidental("#"))
     *          .addAccidental(2, new Vex.Flow.Accidental("#"));
     *
     * (^ that's a c sharp minor triad)
     * the "key" part puts the note head in place.
     * "addAccidental" is needed if you want the accidental to be shown; vexflow doesn't render them
     * automatically because they could be present earlier in the measure or in the key signature.
     *
     * @todo allow this to accept an optional key signature object, or an array of something similar, so
     * that it omits unnecessary accidentals
     */
    function toVexFlow($duration = 'w') {
        $output = '';
        $append = array();
        $keys = array();
        foreach ($this->notes as $index => $note) {
            $pitch = $note->pitch;
            $keys[] = $pitch->toVexFlowKey();
            if ($pitch->alter !== 0) {
                $append[] = "\n    " . '.addAccidental('.$index.', new Vex.Flow.Accidental("'.Accidental::alterToVexFlow($pitch->alter).'"))';
            }
        }
        $output .= 'new Vex.Flow.StaveNote({keys:' . json_encode($keys) . ', duration: "'.$duration.'"})';
        $output .= implode('', $append);
        $output .= "\n";
        return $output;
    }

}
