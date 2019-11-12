<?php namespace Hewison\Inflection;
    
    
    use Hewison\Inflection\Adjective\Adjective;
    use Hewison\Inflection\Noun\Noun;
    use Hewison\Inflection\Verb\Verb;

    class Word
    {
        /** @var array */
        private $available_dictionaries = [];
    
        /** @var array */
        private $current_dictionary = [];
    
        /** @var string */
        private $word;
    
        /** @var array ['adj', 'adv', 'noun', 'verb'] */
        private $parameters = [];
    
        /** @var array */
        private $result;
    
        /**
         * Returns a new instance of word
         * @param string $word
         * @return Word
         */
        public static function create(string $word)
        {
            return new Word($word);
        }
    
        /**
         * Word constructor.
         * @param string $word
         */
        public function __construct(string $word)
        {
            $this->word = $word;
            $this->available_dictionaries = range('A', 'Z');
        
            if (strlen($word) > 0) {
                $this->setWordsBeginningWith(strtoupper($word[0]));
            }
        
            if ($this->findWord()) {
                $result = $this->processWord();
            }
        
            if (!isset($result['verb'])) {
                $result['verb'] = Verb::create($this->word)->conjugate();
            }
        
            // if none of the above are found, we can assume it is a noun.
            if (!isset($result['noun']) && !isset($result['verb'])) {
                $result['noun']['singular'] = Noun::toSingular($this->word);
                $result['noun']['plural'] = Noun::toPlural($this->word);
            }
        
            $this->result = $result;
        }
    
        /**
         * Assign the dictionary which will contain the word.
         * @param string $letter
         * @return bool
         */
        private function setWordsBeginningWith(string $letter): bool
        {
            if (in_array($letter, $this->available_dictionaries)) {
                $this->current_dictionary = include dirname(__FILE__) . "/Dictionary/{$letter}.php";
                return true;
            }
        
            return false;
        }
    
        /**
         * find word in provided dictionary
         * @return bool
         */
        private function findWord(): bool
        {
            if (isset($this->current_dictionary[$this->word])) {
                $this->parameters = $this->current_dictionary[$this->word];
                return true;
            }
        
            return false;
        }
    
        /**
         * Process the word
         * @return array
         */
        private function processWord(): array
        {
            $result = [];
            
            [$adjective, $adverb, $noun, $verb] = $this->parameters;
        
            if ($adjective) {
                $result['adjective'] = Adjective::resolveAllForms($this->word);
            }
        
            // TODO: If this is an adjective. we can try to construct some adverbs from some rules.
            // TODO: Leave this until a later version
            if ($adverb) {
                $result['adverb'] = $this->word;
            }
        
            if ($noun) {
                $result['noun']['singular'] = Noun::toSingular($this->word);
                $result['noun']['plural'] = Noun::toPlural($this->word);
            }
        
            if ($verb) {
                $result['verb'] = Verb::create($this->word)->conjugate();
            }
        
            return $result;
        }
    
        /**
         * Return all results.
         * @return array
         */
        public function get() : array
        {
            return $this->result;
        }
    
        /**
         * Return nouns if exists
         * @return bool|mixed
         */
        public function getNouns()
        {
            return isset($this->result['noun']) ? $this->result['noun'] : false;
        }
    
        /**
         * Return verb if exists
         * @return bool|mixed
         */
        public function getVerb()
        {
            return isset($this->result['verb']) ? $this->result['verb'] : false;
            
        }
        
        /**
         * Return adjective if exists
         * @return bool|mixed
         */
        public function getAdjective()
        {
            return isset($this->result['adjective']) ? $this->result['adjective'] : false;
        }
    
        /**
         * Return adverb if exists
         * @return bool|mixed
         */
        public function getAdverb()
        {
            return isset($this->result['adverb']) ? $this->result['adverb'] : false;
        }
    }