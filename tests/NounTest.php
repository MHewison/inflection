<?php namespace Tests;

use Hewison\Inflection\Noun\Noun;
use PHPUnit\Framework\TestCase;

final class NounTest extends TestCase
{
    public function testCanBeCheckedIfCountable()
    {
        $this->assertFalse(Noun::isCountable("sheep"));
    }

    public function testCanBeCheckedIfNotCountable()
    {
        $this->assertTrue(Noun::isNotCountable("fish"));
    }

    public function testCanBeCheckedIfSingular()
    {
        $this->assertTrue(Noun::isSingular("turkey"));
    }

    public function testCanBeCheckedIfPlural()
    {
        $this->assertTrue(Noun::isPlural("turkeys"));
    }

    public function testCanBeConvertedToPlural()
    {
        $this->assertEquals("turkeys", Noun::toPlural("turkey"));
        $this->assertEquals("octopuses", Noun::toPlural("octopus"));
        $this->assertEquals("radii", Noun::toPlural("radius"));
    }

    public function testCanBeConvertedToSingular()
    {
        $this->assertEquals("giant", Noun::toSingular("giants"));
        $this->assertEquals("octopus", Noun::toSingular("octopi"));
        $this->assertEquals("octopus", Noun::toSingular("octopodes"));
        $this->assertEquals("locus", Noun::toSingular("loci"));
    }

    public function testSingularWillRemainSingularWhenConvertedToSingular()
    {
        $this->assertEquals("city", Noun::toSingular("city"));
    }

    public function testPuralWillRemainPluralWhenConvertedToPlural()
    {
        $this->assertEquals("cities", Noun::toPlural("cities"));
    }

    public function testWillFailGracefullyIfNounEmpty()
    {
        $this->assertEquals("", Noun::toPlural(""));
        $this->assertEquals("", Noun::toSingular(""));
    }
}