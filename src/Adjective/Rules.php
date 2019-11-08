<?php namespace Hewison\Inflection\Adjective;

class Rules
{
    // Adjective => [comparative, superlative]
    const IRREGULAR = [
        "bad" => ["worse", "worst"],
        "far" => ["further", "furthest"],
        "good" => ["better", "best"],
        "late" => ["later", "latest"],
        "little" => ["less", "least"],
        "many" => ["more", "most"],
        "much" => ["more", "most"],
        "some" => ["more", "most"],
        "old" => ["older", "oldest"],
        "crowded" => ["more crowded", "most crowded"],
        "cunning" => ["more cunning", "most cunning"]
    ];
    
    const FORMS = [
        'COMPARATIVE' => 0,
        'SUPERLATIVE' => 1,
    ];
}
