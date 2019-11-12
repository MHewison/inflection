<?php namespace Hewison\Inflection\Verb;


class Rules
{
    const CONJUGATION_RULES = [
        [
            "expression" => "/([uao]m[pb]|[oa]wn|ey|elp|[ei]gn|ilm|o[uo]r|[oa]ugh|igh|ki|ff|oubt|ount|awl|o[alo]d|[iu]"
                ."rl|upt|[oa]y|ight|oid|empt|act|aud|e[ea]d|ound|[aeiou][srcln]t|ept|dd|[eia]n[dk]|[ioa][xk]|[oa]rm|"
                ."[ue]rn|[ao]ng|uin|eam|ai[mr]|[oea]w|[eaoui][rscl]k|[oa]r[nd]|ear|er|[^aieouyfm]it|[aeiouy]ir|"
                ."[^aieouyfm]et|ll|en|vil|om|[^rno].mit|rup|bat|val|.[^skxwb][rvmchslwngb]el)$/",
            "function" => "longVowelConsonant"
        ],
        [
            "expression" => "/[^aeiou]y$/",
            "function" => "consonantY"
        ],
        [
            "expression" => "/[^aeiouy]e$/",
            "function" => "consonantE"
        ],
        [
            "expression" => "/([^dtaeiuo][aeiuo][ptlgnm]|ir|cur|ug|[hj]ar|[^aouiey]ep|[^aeiuo][oua][db])$/",
            "function" => "shortVowelConsonant"
        ],
        [
            "expression" => "/([ieao]ss|[aeiouy]zz|[aeiouy]ch|nch|rch|[aeiouy]sh|[iae]tch|ax)$/",
            "function" => "sibilant"
        ],
        [
            "expression" => "/(ee)$/",
            "function" => "doubleE"
        ],
        [
            "expression" => "/(ie)$/",
            "function" => "iBeforeE"
        ],
        [
            "expression" => "/(ue)$/",
            "function" => "uBeforeE"
        ],
        [
            "expression" => "/./",
            "function" => "regular"
        ]
    ];

    /**
     * Long Vowel Consonant Rule
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    private static function longVowelConsonant(string $verb, string $to) : string
    {
        if ($to === Verb::CONJUGATIONS["PRESENT_THIRD"]) {
            return $verb.'s';
        }

        if ($to === Verb::CONJUGATIONS["GERUND"]) {
            return $verb.'ing';
        }

        if ($to === Verb::CONJUGATIONS["PAST_PARTICIPLE"] || $to === Verb::CONJUGATIONS["PAST"]) {
            return $verb.'ed';
        }

        return $verb;
    }

    /**
     * Short Vowel Consonant Rule
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    private static function shortVowelConsonant(string $verb, string $to) : string
    {
        $last_char = substr($verb, -1);

        if ($to === Verb::CONJUGATIONS["PRESENT_THIRD"]) {
            return $verb.'s';
        }

        if ($to === Verb::CONJUGATIONS["GERUND"]) {
            return $verb.$last_char.'ing';
        }

        if ($to === Verb::CONJUGATIONS["PAST_PARTICIPLE"] || $to === Verb::CONJUGATIONS["PAST"]) {
            return $verb.$last_char.'ed';
        }

        return $verb;
    }

    /**
     * Consonant Before Y Rule
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    private static function consonantY(string $verb, string $to) : string
    {
        $base_verb = substr($verb, 0, -1);

        if ($to === Verb::CONJUGATIONS["PRESENT_THIRD"]) {
            return $base_verb.'ies';
        }

        if ($to === Verb::CONJUGATIONS["GERUND"]) {
            return $verb.'ing';
        }

        if ($to === Verb::CONJUGATIONS["PAST_PARTICIPLE"] || $to === Verb::CONJUGATIONS["PAST"]) {
            return $verb.'ied';
        }

        return $verb;
    }

    /**
     * Consonant Before E Rule
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    private static function consonantE(string $verb, string $to) : string
    {
        $base_verb = substr($verb, 0, -1);

        if ($to === Verb::CONJUGATIONS["PRESENT_THIRD"]) {
            return $verb.'s';
        }

        if ($to === Verb::CONJUGATIONS["GERUND"]) {
            return $base_verb.'ing';
        }

        if ($to === Verb::CONJUGATIONS["PAST_PARTICIPLE"] || $to === Verb::CONJUGATIONS["PAST"]) {
            return $base_verb.'ed';
        }

        return $verb;
    }

    /**
     * Sibilant Rule
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    private static function sibilant(string $verb, string $to) : string
    {
        if ($to === Verb::CONJUGATIONS["PRESENT_THIRD"]) {
            return $verb.'es';
        }

        if ($to === Verb::CONJUGATIONS["GERUND"]) {
            return $verb.'ing';
        }

        if ($to === Verb::CONJUGATIONS["PAST_PARTICIPLE"] || $to === Verb::CONJUGATIONS["PAST"]) {
            return $verb.'ed';
        }

        return $verb;
    }

    /**
     * Double E Rule
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    private static function doubleE(string $verb, string $to) : string
    {
        if ($to === Verb::CONJUGATIONS["PRESENT_THIRD"]) {
            return $verb.'s';
        }

        if ($to === Verb::CONJUGATIONS["GERUND"]) {
            return $verb.'ing';
        }

        if ($to === Verb::CONJUGATIONS["PAST_PARTICIPLE"] || $to === Verb::CONJUGATIONS["PAST"]) {
            return $verb.'d';
        }

        return $verb;
    }

    /**
     * i Before E Rule
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    private static function iBeforeE(string $verb, string $to) : string
    {
        if ($to === Verb::CONJUGATIONS["PRESENT_THIRD"]) {
            return $verb.'s';
        }

        if ($to === Verb::CONJUGATIONS["GERUND"]) {
            return $verb.substr($verb, 0, -2).'ying';
        }

        if ($to === Verb::CONJUGATIONS["PAST_PARTICIPLE"] || $to === Verb::CONJUGATIONS["PAST"]) {
            return $verb.'d';
        }

        return $verb;
    }

    /**
     * u Before E
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    private static function uBeforeE(string $verb, string $to) : string
    {
        if ($to === Verb::CONJUGATIONS["PRESENT_THIRD"]) {
            return $verb.'s';
        }

        if ($to === Verb::CONJUGATIONS["GERUND"]) {
            return $verb.substr($verb, 0, -1).'ing';
        }

        if ($to === Verb::CONJUGATIONS["PAST_PARTICIPLE"] || $to === Verb::CONJUGATIONS["PAST"]) {
            return $verb.'d';
        }

        return $verb;
    }

    /**
     * Regular Rule
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    private static function regular(string $verb, string $to) : string
    {
        if ($to === Verb::CONJUGATIONS["PRESENT_THIRD"]) {
            return $verb.'s';
        }

        if ($to === Verb::CONJUGATIONS["GERUND"]) {
            return $verb.'ing';
        }

        if ($to === Verb::CONJUGATIONS["PAST_PARTICIPLE"] || $to === Verb::CONJUGATIONS["PAST"]) {
            return $verb.'ed';
        }

        return $verb;
    }

    /**
     * Solve the conjugations of the verb
     * @param string $verb
     * @param string $to
     *
     * @return string
     */
    public static function solve(string $verb, string $to) : string
    {
        foreach (self::CONJUGATION_RULES as $rule) {
            if (preg_match($rule['expression'], $verb)) {
                return self::{$rule['function']}($verb, $to);
            }
        }
    }
}
