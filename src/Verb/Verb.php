<?php namespace Hewison\Inflection\Verb;
    
    class Verb
    {

        const CONJUGATIONS = [
            "PRESENT" => 0, // VBP
            "PAST" => 1, // VBD
            "PAST_PARTICIPLE" => 2, // VBN
            "PRESENT_THIRD" => 3, // VBZ
            "GERUND" => 4 // VBG
        ];

        private $present = [];

        private $past = [];

        private $past_participle = [];

        private $present_third = [];

        private $gerund = [];

        private $tense;

        public function __construct()
        {
            // Uncomment to regenerate the conjugation of the verbs, can also be used instead of the default
            // conjugated sets

            $this->present = Rules::PRESENT;
            $this->past = Rules::PAST;
            $this->past_participle = Rules::PAST_PARTICIPLE;
            $this->present_third = Rules::PRESENT_THIRD;
            $this->gerund = Rules::GERUND;

            // $this->prepareIrregularVerbs();
            // $this->prepareRegularVerbs();
        }

        public function conjugate(string $verb) : array
        {
            $index = $this->locateIndex($verb);

            return [
                'entry' => $verb,
                'tense' => $this->tense,
                'past' => $this->toPast($index),
                'past_particple' => $this->toPastParticiple($index),
                'present' => $this->toPresent($index),
                'present_third' => $this->toPresentThird($index),
                'gerund' => $this->toGerund($index),
            ];
        }

        private function toGerund(int $index) : string
        {
            return $this->gerund[$index];
        }

        private function toPresent(int $index) : string
        {
            return $this->present[$index];
        }

        private function toPast(int $index) : string
        {
            return $this->past[$index];
        }

        private function toPastParticiple(int $index) : string
        {
            return $this->past_participle[$index];
        }

        private function toPresentThird(int $index) : string
        {
            return $this->present_third[$index];
        }

        public function locateIndex(string $verb) : int
        {

            if ($index = array_search($verb, $this->present)) {
                $this->tense = "present";
                return $index;
            }

            if ($index = array_search($verb, $this->past)) {
                $this->tense = "past";
                return $index;
            }

            if ($index = array_search($verb, $this->past_participle)) {
                $this->tense = "past participle";
                return $index;
            }

            if ($index = array_search($verb, $this->present_third)) {
                $this->tense = "present 3rd";
                return $index;
            }

            if ($index = array_search($verb, $this->gerund)) {
                $this->tense = "gerund";
                return $index;
            }

            // need a way of finding nearest verbs
        }

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