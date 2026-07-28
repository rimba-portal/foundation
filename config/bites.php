<?php

declare(strict_types=1);

return [
    'sync' => ['queue' => false],
    'ui' => [
        'panels' => [
            // panel_id, path, color, brandName, homeUrl
            'admin' => ['admin', 'admin', '#7f174b', 'Administrator Portal', 'filament.staff.pages.dashboard'],
            'lobby' => ['lobby', 'lobby', '#069800', 'ATM Lobby', 'filament.lobby.pages.dashboard'],
            'staff' => ['staff', 'staff', '#09829f', 'ATM Staff Intranet', 'filament.staff.pages.dashboard'],
        ],
    ],
    'unit_roles' => ['owner','member'],
    'team_roles' => ['captain','scout', 'player', 'quartermaster', 'tactician', 'coach'],
];
