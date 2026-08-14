<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use App\Http\UI\Staff\Widgets;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Override;
use Rimba\Work\Http\UI\Widgets\MyPendingTasksWidget;
use Rimba\Work\Http\UI\Widgets\TaskStatsWidget;
use Rimba\Work\Http\UI\Widgets\UnassignedTasksByRoleWidget;
use UnitEnum;

class Dashboard extends BaseDashboard
{
    protected static string|UnitEnum|null $navigationGroup = 'ToDo';

    protected static string|BackedEnum|null $navigationIcon = 'bites-s-task';

    protected static ?string $navigationLabel = 'Task';

    protected static ?int $navigationSort = 13;

    protected static ?string $title = 'Task';

    protected ?string $subheading = 'Task to get done by you or your teams.';

    public function getColumns(): int|array
    {
        return 4;
    }

    #[Override]
    protected function getHeaderWidgets(): array
    {
        // Only these widgets appear on the Dashboard
        return [
            UnassignedTasksByRoleWidget::class,
            MyPendingTasksWidget::class,
            TaskStatsWidget::class,
        ];
    }
}
