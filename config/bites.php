<?php

declare(strict_types=1);

return [
    'sync' => ['queue' => false],
    'ui' => [
        'panels' => [
            // panel_id, path, color, brandName, homeUrl
            'admin' => ['admin', 'admin', '#7F174C', 'Administrator Portal', 'filament.staff.pages.dashboard'],
            'lobby' => ['lobby', 'lobby', '#0F4C8D', 'ATM Lobby', 'filament.lobby.pages.dashboard'],
            'staff' => ['staff', 'staff', '#0A83A0', 'ATM Staff Intranet', 'filament.staff.pages.dashboard'],
            'team' => ['team', 'team', '#DA8E27', 'Team Panel', 'filament.staff.pages.dashboard'],
        ],
    ],
    'unit_roles' => ['owner', 'member'],
    'team_roles' => ['captain', 'scout', 'player', 'quartermaster', 'tactician', 'coach'],
];
