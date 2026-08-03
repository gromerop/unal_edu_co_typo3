<?php

namespace UNAL\UnalNews\Utility;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VideoFile
 *
 * @author ultra
 */
class VideoFile {

	protected $filename;

	public function __construct($filename) {
		$this->filename = $filename;
    }
    
    public function getDurationEstimate(){
        $ffmpeg_output = shell_exec("ffmpeg -i '".$this->filename."' 2>&1");
        if( preg_match('/.*Duration: ([0-9:]+).*/', $ffmpeg_output, $matches) ) {
            return $matches[1];
        }
    }

}