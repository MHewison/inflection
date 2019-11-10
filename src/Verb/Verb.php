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
        private $present = [];

        /** @var array */
        private $past = [];

        /** @var array */
        private $past_participle = [];

        /** @var array */
        private $present_third = [];

        /** @var array */
        private $gerund = [];

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
        public function __construct(string $verb, bool $use_stored_dictionaries = true)
        {
    
            if ($use_stored_dictionaries) {
                $this->present = Rules::PRESENT;
                $this->past = Rules::PAST;
                $this->past_participle = Rules::PAST_PARTICIPLE;
                $this->present_third = Rules::PRESENT_THIRD;
                $this->gerund = Rules::GERUND;
            } else {
                $this->prepareIrregularVerbs();
                $this->prepareRegularVerbs();
            }
            
            $this->entry = $verb;
            $this->verb = $verb;
            $this->index = $this->findNearestVerb();
    
            if ($this->index === false) {
                return ["message" => "No verb found"];
            }
    
            $this->setPrefix();
            
        }
    
        /**
         * Conjugates a verb to all forms
         * @return array
         */
        public function conjugate() : array
        {
            return [
                'entry' => $this->entry,
                'tense' => $this->tense,
                'nearest_verb' => $this->getByTense($this->tense),
                'past' => $this->rebuild($this->toPast()),
                'past_participle' => $this->rebuild($this->toPastParticiple()),
                'present' => $this->rebuild($this->toPresent()),
                'present_third' => $this->rebuild($this->toPresentThird()),
                'gerund' => $this->rebuild($this->toGerund()),
            ];
        }
    
        /**
         * Get verb by its tense
         * @param string $tense
         * @return string
         */
        private function getByTense(string $tense)
        {
            $verb = "";
            
            switch($tense) {
                case Verb::CONJUGATIONS["PRESENT"]:
                    $verb = $this->toPresent();
                    break;
                case Verb::CONJUGATIONS["PRESENT_THIRD"]:
                    $verb = $this->toPresentThird();
                    break;
                case Verb::CONJUGATIONS["PAST"]:
                    $verb = $this->toPast();
                    break;
                case Verb::CONJUGATIONS["PAST_PARTICIPLE"]:
                    $verb = $this->toPastParticiple();
                    break;
                case Verb::CONJUGATIONS["GERUND"]:
                    $verb = $this->toGerund();
                    break;
            }
            
            return $verb;
        }
    
        /**
         * Return gerund form of verb
         * @return string
         */
        public function toGerund() : string
        {
            return $this->rebuild($this->gerund[$this->index]);
        }
    
        /**
         * Return present form of verb
         * @return string
         */
        public function toPresent() : string
        {
            return $this->rebuild($this->present[$this->index]);
        }
    
        /**
         * Return past form of verb
         * @return string
         */
        public function toPast() : string
        {
            return $this->rebuild($this->past[$this->index]);
        }
    
        /**
         * Return past participle form of verb
         * @return string
         */
        public function toPastParticiple() : string
        {
            return $this->rebuild($this->past_participle[$this->index]);
        }
    
        /**
         * Return Present 3rd form of verb
         * @return string
         */
        public function toPresentThird() : string
        {
            return $this->rebuild($this->present_third[$this->index]);
        }
    
        /**
         * Reduce the verb to try to find a similar verb
         * @return bool|false|int|string
         */
        private function reduce()
        {
            if (strlen($this->verb) < 2) {
                return false;
            }
            
            $this->verb = substr($this->verb, 1);

            $this->index = $this->locateIndex();

            if ($this->index !== false) {
                return $this->index;
            }

            return $this->reduce();
        }
    
        /**
         * Locate the nearest verb
         * @return bool|false|int|string
         */
        private function findNearestVerb()
        {
            $this->index = $this->locateIndex();
            
            if ($this->index !== false) {
                return $this->index;
            }

            $this->index = $this->reduce();

            if ($this->index !== false) {
                return $this->index;
            }
            
            return false;
        }
    
        /**
         * Set the prefix if the verb is not in the dictionary
         */
        private function setPrefix()
        {
            $this->prefix = substr($this->entry, 0, strrpos($this->entry, $this->getByTense($this->tense)));
        }
    
        /**
         * Rebuild the verb with a nearest match and the prefix
         * @param string $nearest_verb
         * @return string
         */
        private function rebuild(string $nearest_verb) : string
        {
            return $this->prefix.$nearest_verb;
        }
    
        /**
         * Locate the verb index
         * @return bool|false|int|string
         */
        public function locateIndex()
        {
            $index = array_search($this->verb, $this->present);
            
            if($index !== false) {
                $this->tense = Verb::CONJUGATIONS["PRESENT"];
                return $index;
            }

            $index = array_search($this->verb, $this->past);

            if($index !== false) {
                $this->tense = Verb::CONJUGATIONS["PAST"];
                return $index;
            }

            $index = array_search($this->verb, $this->past_participle);

            if($index !== false) {
                $this->tense = Verb::CONJUGATIONS["PAST_PARTICIPLE"];
                return $index;
            }

            $index = array_search($this->verb, $this->present_third);

            if($index !== false) {
                $this->tense = Verb::CONJUGATIONS["PRESENT_THIRD"];
                return $index;
            }

            $index = array_search($this->verb, $this->gerund);

            if($index !== false) {
                $this->tense = Verb::CONJUGATIONS["GERUND"];
                return $index;
            }
            
            return false;

        }
    
        /**
         * Prepare irregular verbs into an array
         */
        protected function prepareIrregularVerbs()
        {
            foreach (Rules::IRREGULAR as $irregular) {
                [$present, $past, $past_participle, $present_third, $gerund] = $irregular;

                $this->present[] = $present;
                $this->past[] = $past;
                $this->past_participle[] = $past_participle;
                $this->present_third[] = $present_third;
                $this->gerund[] = $gerund;
            }
        }
    
        /**
         * Prepare regular verbs to array
         */
        protected function prepareRegularVerbs()
        {
            foreach (Rules::REGULAR as $regular) {
                $this->present[] = $regular;

                $this->past[] = Rules::solve($regular, self::CONJUGATIONS["PAST"]);
                $this->past_participle[] = Rules::solve($regular, self::CONJUGATIONS["PAST_PARTICIPLE"]);
                $this->present_third[] = Rules::solve($regular, self::CONJUGATIONS["PRESENT_THIRD"]);
                $this->gerund[] = Rules::solve($regular, self::CONJUGATIONS["GERUND"]);
            }
        }
    }