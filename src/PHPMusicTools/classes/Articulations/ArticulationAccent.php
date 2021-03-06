<?php
namespace ianring;

/**
 * Accent
 */
class ArticulationAccent extends Articulation
{

	public static $props = array(
        'placement',
        'type',
        'defaultX',
        'defaultY',
	);


    public function __construct($placement, $type, $defaultX, $defaultY) {
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
        return new ArticulationAccent($placement, $type, $defaultX, $defaultY);
    }


    /**
     * renders this object as MusicXML
     *
     * @return string MusicXML representation of the object
     */
    function toMusicXML() {
        $out  = '';
        $out .= '<accent';
        if (!empty($this->placement)) {
	        $out .= ' placement="'.$this->placement.'"';
	    }
        if (!empty($this->type)) {
	        $out .= ' type="'.$this->type.'"';
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
