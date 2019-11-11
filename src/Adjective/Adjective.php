<?php namespace Hewison\Inflection\Adjective;
    
    class Adjective
    {
        /**
         * Counts syllables in a word
         * @param string $word
         * @return int
         */
        public static function countSyllables(string $word) : int
        {
            return preg_match_all("/[aiouy]+e*|e(?!d$|ly).|[tdr]ed|le$/", $word);
        }
    
        /**
         * Resolve superlative adjective form of a word
         * @param string $word
         * @return string
         */
        public static function resolveSuperlativeForm(string $word) : string {
            return self::resolveForm($word, Rules::FORMS['SUPERLATIVE']);
        }
    
        /**
         * Resolve comparative adjective form of a word
         * @param string $word
         * @return string
         */
        public static function resolveComparativeForm(string $word) : string {
            return self::resolveForm($word, Rules::FORMS['COMPARATIVE']);
        }
    
        /**
         * Resolve an array containing all forms of the adjective
         * @param string $word
         * @return array
         */
        public static function resolveAllForms(string $word) : array {
            $forms['standard'] = $word;
            $forms['comparative'] = self::resolveComparativeForm($word);
            $forms['superlative'] = self::resolveSuperlativeForm($word);
            
            return $forms;
        }
    
        /**
         * Resolves form, comparative or superlative
         *
         * @param string $word
         * @param int $type
         * @return string
         */
        public static function resolveForm(string $word, int $type = 0) : string
        {
            if (isset(Rules::IRREGULAR[$word])) {
                return ($type ? Rules::IRREGULAR[$word][1] : Rules::IRREGULAR[$word][0]);
            }
            
            $syllables = self::countSyllables($word);
            
            if ($syllables >= 3 && !($syllables < 5 && preg_match("/y$/", $word))) {
                return ($type ? "most " : "more ").$word;
            }
            
            if ($syllables >= 2 && preg_match("/ing$/", $word)) {
                return ($type ? "most " : "more ").$word;
            }
            
            if ($syllables > 2 && preg_match("/ed$/", $word)) {
                return ($type ? "most " : "more ").$word;
            }
            
            if (preg_match("/[^aeiouy][aeiouy][^rwaeiouy]$/", $word)) {
                return preg_replace("/([^aeiouy])$/", ($type ? "$1$1est" : "$1$1er"), $word);
            }
    
            if (preg_match("/y$/", $word)) {
                return preg_replace("/y$/", ($type ? "iest" : "ier"), $word);
            }
    
            if (preg_match("/e$/", $word)) {
                return preg_replace("/e$/", ($type ? "est" : "er"), $word);
            }
    
            if (preg_match("/e$/", $word)) {
                return preg_replace("/e$/", ($type ? "est" : "er"), $word);
            }
            
            return $word.($type ? "est" : "er");
            
        }
    }