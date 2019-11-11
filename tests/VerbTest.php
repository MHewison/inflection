<?php namespace Tests;

use Hewison\Inflection\Verb\Verb;
use PHPUnit\Framework\TestCase;

final class VerbTest extends TestCase
{
    public function testCanBeConjugated()
    {
        $this->assertEquals([
            "entry" => "abhor",
            "tense" => "Present",
            "nearest_verb" => "abhor",
            "past" => "abhorred",
            "past_participle" => "abhorred",
            "present" => "abhor",
            "present_third" => "abhors",
            "gerund" => "abhorring"
        ], Verb::create("abhor")->conjugate());
    }

    public function testCanBeConvertedToGerund()
    {
        $this->assertEquals("walking", Verb::create("walk")->toGerund());
    }

    public function testCanBeConvertedToPast()
    {
        $this->assertEquals("read", Verb::create("read")->toPast());
    }

    public function testCanBeConvertedToPastParticiple()
    {
        $this->assertEquals("talked", Verb::create("talk")->toPastParticiple());
    }

    public function testCanBeConvertedToPresent()
    {
        $this->assertEquals("walk", Verb::create("walking")->toPresent());
    }

    public function testCanBeConvertedToPresentThird()
    {
        $this->assertEquals("fakes", Verb::create("fake")->toPresentThird());
    }

    public function testCanFindNearestVerb()
    {
        $this->assertEquals("withforeseeing", Verb::create("withforeseen")->toGerund());
    }

    public function testWillFailGracefullyIfNoVerbExists()
    {
        $this->assertEquals([
            "entry" => "thisisnotaverb",
            "tense" => null,
            "nearest_verb" => "",
            "past" => "thisisnotaverb",
            "past_participle" => "thisisnotaverb",
            "present" => "thisisnotaverb",
            "present_third" => "thisisnotaverb",
            "gerund" => "thisisnotaverb",
        ], Verb::create("thisisnotaverb")->conjugate());
    }

    public function testWillFailGracefullyIfVerbEmpty()
    {
        $this->assertEquals([
            "entry" => "",
            "tense" => null,
            "nearest_verb" => "",
            "past" => "",
            "past_participle" => "",
            "present" => "",
            "present_third" => "",
            "gerund" => "",
        ], Verb::create("")->conjugate());
    }
}