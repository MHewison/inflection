<?php namespace Hewison\Inflection\Verb;

class Verb
{
    
    const CONJUGATIONS = [
        "PRESENT" => "Present", // VBP
        "PAST" => "Past", // VBD
        "PAST_PARTICIPLE" => "Past Participle", // VBN
        "PRESENT_THIRD" => "Present Third", // VBZ
        "GERUND" => "Gerund" // VBG
    ];
    
    /** @var array */
    public $present = [];
    
    /** @var array */
    public $past = [];
    
    /** @var array */
    public $past_participle = [];
    
    /** @var array */
    public $present_third = [];
    
    /** @var array */
    public $gerund = [];
    
    /** @var */
    private $tense;
    
    /** @var */
    private $prefix;
    
    /** @var bool|false|int|string */
    private $index;
    
    /** @var string */
    private $verb;
    
    /** @var string  */
    private $entry;
    
    /** @var string */
    private $error;
    
    /**
     * Static creation method
     * @param string $verb
     * @param bool $use_stored_dictionaries
     * @return Verb
     */
    public static function create(string $verb, $use_stored_dictionaries = true)
    {
        return new Verb($verb, $use_stored_dictionaries);
    }
    
    /**
     * Verb constructor.
     * @param string $verb
     * @param bool $use_stored_dictionaries
     */
    public function __construct(string $verb)
    {
        $this->present = include dirname(__FILE__)."/List/Present.php";
        $this->past = include dirname(__FILE__)."/List/Past.php";
        $this->past_participle = include dirname(__FILE__)."/List/PastParticiple.php";
        $this->present_third = include dirname(__FILE__)."/List/PresentThird.php";
        $this->gerund = include dirname(__FILE__)."/List/Gerund.php";
        
        $this->entry = $verb;
        $this->verb = $verb;
        $this->index = $this->findVerb();
    }
    
    /**
     * Conjugates a verb to all forms
     * @return array|bool
     */
    public function conjugate()
    {
        return $this->index !== false ? [
            'entry' => $this->entry,
            'tense' => $this->tense,
            'past' => $this->toPast(),
            'past_participle' => $this->toPastParticiple(),
            'present' => $this->toPresent(),
            'present_third' => $this->toPresentThird(),
            'gerund' => $this->toGerund(),
        ] : false;
    }
    
    /**
     * Return gerund form of verb
     * @return string
     */
    public function toGerund() : string
    {
        return $this->gerund[$this->index];
    }
    
    /**
     * Return present form of verb
     * @return string
     */
    public function toPresent() : string
    {
        return $this->present[$this->index];
    }
    
    /**
     * Return past form of verb
     * @return string
     */
    public function toPast() : string
    {
        return $this->past[$this->index];
    }
    
    /**
     * Return past participle form of verb
     * @return string
     */
    public function toPastParticiple() : string
    {
        return $this->past_participle[$this->index];
    }
    
    /**
     * Return Present 3rd form of verb
     * @return string
     */
    public function toPresentThird() : string
    {
        return $this->present_third[$this->index];
    }
    
    /**
     * Locate the nearest verb
     * @return bool|false|int|string
     */
    private function findVerb()
    {
        $this->index = $this->locateIndex();
        
        if ($this->index !== false) {
            return $this->index;
        }
        
        return false;
    }
    
    /**
     * Locate the verb index
     * @return bool|false|int|string
     */
    public function locateIndex()
    {
        $index = array_search($this->verb, $this->present);
        
        if ($index !== false) {
            $this->tense = Verb::CONJUGATIONS["PRESENT"];
            return $index;
        }
        
        $index = array_search($this->verb, $this->past);
        
        if ($index !== false) {
            $this->tense = Verb::CONJUGATIONS["PAST"];
            return $index;
        }
        
        $index = array_search($this->verb, $this->past_participle);
        
        if ($index !== false) {
            $this->tense = Verb::CONJUGATIONS["PAST_PARTICIPLE"];
            return $index;
        }
        
        $index = array_search($this->verb, $this->present_third);
        
        if ($index !== false) {
            $this->tense = Verb::CONJUGATIONS["PRESENT_THIRD"];
            return $index;
        }
        
        $index = array_search($this->verb, $this->gerund);
        
        if ($index !== false) {
            $this->tense = Verb::CONJUGATIONS["GERUND"];
            return $index;
        }
        
        return false;
    }
}