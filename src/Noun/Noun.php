<?php namespace Hewison\Inflection\Noun;
    
    
    class Noun
    {
        /**
         * Checks if a noun is not countable
         * @param string $noun
         * @return bool
         */
        public static function isNotCountable(string $noun) : bool
        {
            return !self::isCountable($noun);
        }
    
        /**
         * Checks if a noun is countable
         * @param string $noun
         * @return bool
         */
        public static function isCountable(string $noun) : bool
        {
            return array_search($noun, array_values(Rules::UNCOUNTABLE)) === false;
        }
    
        /**
         * Checks if a noun is singular
         * @param string $noun
         * @return bool
         */
        public static function isSingular(string $noun) : bool
        {
            $noun = self::splitWords($noun);
            
            // Look for the noun in the countables and known lists.
            if (self::isNotCountable($noun) || isset(Rules::SINGULAR_TO_PLURAL[$noun])) {
                return true;
            }
            
            if (isset(Rules::PLURAL_TO_SINGULAR[$noun])) {
                return false;
            }
            
            // Work through the patterns.
            foreach (Rules::SINGULAR_PATTERNS as $singular_pattern) {
                if (preg_match($singular_pattern, $noun)) {
                    return true;
                }
            }
            
            foreach (Rules::PLURAL_PATTERNS as $plural_pattern) {
                if (preg_match($plural_pattern, $noun)) {
                    return false;
                }
            }
            
            return true;
        }
    
        /**
         * Checks if a noun is plural
         * @param string $noun
         * @return bool
         */
        public static function isPlural(string $noun) : bool
        {
            $noun = self::splitWords($noun);
            
            if (self::isNotCountable($noun)) {
                return true;
            }
            
            return !self::isSingular($noun);
        }
    
        /**
         * Splits entry by words and returns the first one
         * @param string $noun
         * @return string
         */
        private static function splitWords(string $noun) : string
        {
            $noun_split = preg_split("/\W/", $noun, 1, PREG_SPLIT_NO_EMPTY);
            return trim(strtolower(count($noun_split) ? $noun_split[0] : $noun));
        }
        
        public static function toPlural(string $noun) : string
        {
            if (self::isPlural($noun)) {
                return $noun;
            }
            
            if (isset(Rules::SINGULAR_TO_PLURAL[$noun]))
            {
                return Rules::SINGULAR_TO_PLURAL[$noun][0];
            }
            
            foreach (Rules::TO_PLURAL_EXPRESSIONS as $to_plural_expression) {
                if (preg_match($to_plural_expression['expression'], $noun)) {
                    return preg_replace($to_plural_expression['expression'], $to_plural_expression['replacement'], $noun);
                }
            }
            
            return $noun;
        }
        
        public static function toSingular(string $noun) : string
        {
            if (self::isSingular($noun)) {
                return $noun;
            }
            
            if (isset(Rules::PLURAL_TO_SINGULAR[$noun])) {
                return Rules::PLURAL_TO_SINGULAR[$noun];
            }
            
            foreach (Rules::TO_SINGULAR_EXPRESSIONS as $to_singular_expression) {
                if (preg_match($to_singular_expression['expression'], $noun)) {
                    return preg_replace($to_singular_expression['expression'], $to_singular_expression['replacement'], $noun);
                }
            }
            
            return $noun;
        }
    }
    