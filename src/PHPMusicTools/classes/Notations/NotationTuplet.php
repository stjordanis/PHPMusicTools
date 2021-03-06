<?php
namespace ianring;

/**
 * Tuplet is the visual glyph that represents a time modification.
 */
class NotationTuplet extends Notation
{

	public static $props = array(
        'bracket',
        'number',
        'placement',
        'type',
        'lineShape',
        'showNumber',
        'showType',
	);

    public function __construct($bracket, $number, $placement, $type, $lineShape, $showNumber, $showType) {
    	foreach (self::$props as $prop) {
    		$this->$prop = $$prop;
    	}
    }


    /**
     * accepts the object in the form of an array structure
     *
     * @param  [type] $scale [description]
     * @return [type]        [description]
     */
    public static function constructFromArray($props) {
    	foreach (self::$props as $prop) {
    		if (!empty($props[$prop])) {
    			$$prop = $props[$prop];
    		} else {
    			$$prop = null;
    		}
    	}
        return new NotationTuplet($bracket, $number, $placement, $type, $lineShape, $showNumber, $showType);
    }


    /**
     * renders this object as MusicXML
     *
     * @return string MusicXML representation of the object
     */
    function toMusicXML() {
        $out  = '';
        $out .= '<tuplet';
        $out .= ' bracket="' . ($this->bracket ? 'yes': 'no') . '"';
        $out .= ' line-shape="'.$this->lineShape.'"';
        $out .= ' number="'.$this->number.'"';
        $out .= ' placement="'.$this->placement.'"';
        $out .= ' show-number="'.$this->showNumber.'"';
        $out .= ' show-type="'.$this->showType.'"';
        $out .= ' type="'.$this->type.'"';
        $out .= '/>';
        return $out;
    }



}
