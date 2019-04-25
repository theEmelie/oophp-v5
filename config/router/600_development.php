<?php
/**
 * Routes to ease development and debugging.
 */
return [
    "routes" => [
        [
            "info" => "Dice 100 game.",
            "mount" => "dice_game",
            "handler" => "\Emau\Controller\DiceGameController",
        ],
    ]
];
