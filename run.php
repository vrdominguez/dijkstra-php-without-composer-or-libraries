<?php

// Simple autoload (in order to avoid the use of external libraries/services)
define( 'BASE', realpath(__DIR__ ) );

spl_autoload_register(
    function ($class) {
        $file = str_replace('\\', '/', $class) . '.php';

        // require file only if it exists (other classes must be PHP internals)
        if ( file_exists(BASE . '/src/' . $file) ) {
            require BASE . '/src/' . $file;
        }
    }
);

use Dijkstra\Graph;

// List of cities (each city position is equivalent to its index in graph
$cities=['Logroño','Zaragoza','Teruel','Madrid','Lleida','Alicante','Castellón','Segovia','Ciudad Real'];

// Distances (graph)
$connections=[
    [0,4,6,8,0,0,0,0,0], // Starting in Logroño
    [4,0,2,0,2,0,0,0,0], // Starting in Zaragoza
    [6,2,0,3,5,7,0,0,0], // Starting in Teruel
    [8,0,3,0,0,0,0,0,0], // Starting in Madrid
    [0,2,5,0,0,0,4,8,0], // Starting in Lleida
    [0,0,7,0,0,0,3,0,7], // Starting in Alicante
    [0,0,0,0,4,3,0,0,6], // Starting in Castellón
    [0,0,0,0,8,0,0,0,4], // Starting in Segovia
    [0,0,0,0,0,7,6,4,0], // Starting in Ciudad Real
];

// Create the Graph object with current data
$graph = Graph::graphFromArray($cities, $connections);

// Get path from Logoroño to Madrid
print PHP_EOL . "GET ONE PATH:" . PHP_EOL . PHP_EOL;
$path = $graph->getShortestPath("Logroño", "Ciudad Real");
showPaths("Logroño", $path);

print PHP_EOL . "GET ALL PATHS" . PHP_EOL . PHP_EOL;
$paths = $graph->getShortestPath("Madrid");
showPaths("Madrid", $paths);


/**
 * Displays de shortest path to the nodes ind paths from the selected initial one
 *
 * @param string $from
 * @param array $paths
 */
function showPaths(string $from, array $paths): void {
    foreach ($paths as $to => $pathData) {
        print 'Path from ' . $from . ' to ' . $to . ':' . PHP_EOL
            . '  - Cost: ' . $pathData[1] . PHP_EOL
            . '  - Path: ' . implode(' => ', $pathData[0])  . PHP_EOL . PHP_EOL;
    }
}