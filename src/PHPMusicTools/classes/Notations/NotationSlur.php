<?php
namespace ianring;

/**
 * Slur is a glyph connecting two notes which indicates they should be performed smoothly and attached
 */
class NotationSlur extends Notation
{

	public static $props = array(
        'number',
        'placement',
        'type',
        'bezierX',
        'bezierY',
        'defaultX',
        'defaultY',
	);


    public function __construct($number, $placement, $type, $bezierX, $bezierY, $defaultX, $defaultY) {
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
        return new NotationSlur($number, $placement, $type, $bezierX, $bezierY, $defaultX, $defaultY);
    }


    /**
     * renders this object as MusicXML
     *
     * @return string MusicXML representation of the object
     */
    function toMusicXML() {
        $out  = '';
        $out .= '<slur';
        if (!empty($this->number)) {
	        $out .= ' number="'.$this->number.'"';
        }
        if (!empty($this->placement)) {
	        $out .= ' placement="'.$this->placement.'"';
	    }
        if (!empty($this->type)) {
	        $out .= ' type="'.$this->type.'"';
	    }
        if (!empty($this->bezierX)) {
	        $out .= ' bezier-x="'.$this->bezierX.'"';
	    }
        if (!empty($this->bezierY)) {
	        $out .= ' bezier-y="'.$this->bezierY.'"';
	    }
        if (!empty($this->defaultX)) {
	        $out .= ' default-x="'.$this->defaultX.'"';
	    }
        if (!empty($this->defaultY)) {
	        $out .= ' default-y="'.$this->defaultY.'"';
	    }

        $out .= '/>';
        return $out;
    }



}
