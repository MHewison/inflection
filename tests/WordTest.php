<?php namespace Tests;

use Hewison\Inflection\Word;
use PHPUnit\Framework\TestCase;

final class WordTest extends TestCase
{
    public function testWordCanBeResolved()
    {
        $this->assertEquals([
            'adjective' => [
                'standard' => 'back',
                'comparative' => 'more back',
                'superlative' => 'most back',
            ],
            'adverb' => 'back',
            'noun' => [
                'singular' => 'back',
                'plural' => 'backs'
            ],
    
            'verb' => [
                'entry' => 'back',
                'tense' => 'Present',
                'past' => 'backed',
                'past_participle' => 'backed',
                'present' => 'back',
                'present_third' => 'backs',
                'gerund' => 'backing'
            ]
        ], Word::create("back")->get());
    }
    
    public function testCanGetAdverb()
    {
        $this->assertEquals('back', Word::create("back")->getAdverb());
    }
    
    public function testCanGetNoun()
    {
        $this->assertEquals([
            'singular' => 'back',
            'plural' => 'backs'
        ], Word::create("back")->getNouns());
    }
    
    public function testCanGetAdjective()
    {
        $this->assertEquals([
            'standard' => 'back',
            'comparative' => 'more back',
            'superlative' => 'most back',
        ], Word::create("back")->getAdjective());
    }
    
    public function testCanGetVerb()
    {
        $this->assertEquals([
            'entry' => 'back',
            'tense' => 'Present',
            'past' => 'backed',
            'past_participle' => 'backed',
            'present' => 'back',
            'present_third' => 'backs',
            'gerund' => 'backing'
        ], Word::create("back")->getVerb());
    }
}