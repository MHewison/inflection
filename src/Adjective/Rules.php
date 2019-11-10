<?php namespace Hewison\Inflection\Adjective;

class Rules
{
    // Adjective => [comparative, superlative]
    const IRREGULAR = [
        "bad" => ["worse", "worst"],
        "boring" => ["more boring", "most boring"],
        "crowded" => ["more crowded", "most crowded"],
        "cunning" => ["more cunning", "most cunning"],
        "far" => ["further", "furthest"],
        "good" => ["better", "best"],
        "well" => ["better", "best"],
        "giant" => ["more giant", "most giant"],
        "late" => ["later", "latest"],
        "little" => ["less", "least"],
        "many" => ["more", "most"],
        "much" => ["more", "most"],
        "some" => ["more", "most"],
        "old" => ["older", "oldest"]
    ];
    
    const FORMS = [
        'COMPARATIVE' => 0,
        'SUPERLATIVE' => 1,
    ];
}
