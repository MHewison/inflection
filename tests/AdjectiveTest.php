<?php namespace Tests;

use Hewison\Inflection\Adjective\Adjective;
use PHPUnit\Framework\TestCase;

final class AdjectiveTest extends TestCase
{
    public function testCanCountSyllables()
    {
        $this->assertEquals(2, Adjective::countSyllables("boring"));
        $this->assertEquals(3, Adjective::countSyllables("delicious"));
        $this->assertEquals(1, Adjective::countSyllables("red"));
        $this->assertEquals(2, Adjective::countSyllables("hatred"));
    }

    public function testCanResolveSuperlativeForm()
    {
        $this->assertEquals("most boring", Adjective::resolveSuperlativeForm("boring"));
    }

    public function testCanResolveComparativeForm()
    {
        $this->assertEquals("more delicious", Adjective::resolveComparativeForm("delicious"));
    }

    public function canResolveAllforms()
    {
        $this->assertEquals([
            "standard" => "large",
            "comparative" => "larger",
            "superlative" => "largest"
        ], Adjective::resolveAllForms("large"));
    }
}