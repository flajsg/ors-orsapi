<?php namespace Ors\Orsapi\Orm;

use Ors\Orsapi\Oam\OAMAvailabilityResponse;
use Common;

/**
 * ORM Response
 *
 * Response info from after ORM post
 */

class ORMResponse extends OAMAvailabilityResponse {

    /**
     * Attributes for this model
     * @var array
     */
    protected $fillable = [
    	// same as availability
    	'mid', 'ttp', 'ppc', 'ppct', 'txt', 'old_ppc', 'severity',
    			
    	// extended
    	'cur', 'ppm', 'sts', 'createdAt', 'modifiedAt', 'dirty',
	];
    
    /*
     * ACCESSORS
     */
    
    /**
     * Bootstrap status indicator, depending on 'severity' value.
     * 
     * For example 'success' if final action was a success, or 'danger' if something went wrong. 
     * 
     * @return string
     */
    public function getStatusAttribute() {
    	switch ($this->attributes['severity']) {
    		case '1':
				return 'success';
    		case '2':
				return 'warning';
    		case '3':
				return 'danger';
			default:
				return 'primary';
    	}
    }
    
    /**
     * CreatedAtHuman attribute.
     * @return string
     */
    public function getCreatedAtHumanAttribute() {
    	if (strtotime($this->attributes['createdAt']) <= 0)
    	    return null;
    	return Common::dateTime($this->attributes['createdAt']);
    }

    /**
     * ModifiedAtHuman attribute.
     * @return string
     */
    public function getModifiedAtHumanAttribute() {
        if (strtotime($this->attributes['modifiedAt']) <= 0)
            return null;
        return Common::dateTime($this->attributes['modifiedAt']);
    }

    /**
     * Return true if booking has failed
     * @return boolean
     */
    public function hasFailed() {
    	return !empty($this->attributes['dirty']);
    }
    
    public function toArray(){
        $array = parent::toArray();
        unset($array['ttp_check']);
        unset($array['ppc_check']);
        return $array;
    }
}