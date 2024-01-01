<?php

namespace Skillcraft\Core\Concerns;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Botble\Base\Facades\BaseHelper;
use Skillcraft\Core\Supports\Period;
use Skillcraft\Core\Http\Requests\AnalyticsRequest;
use Botble\Dashboard\Supports\DashboardWidgetInstance;
use Skillcraft\AccountDashboard\Supports\AccountWidgetInstance;

trait AnalyticsTrait
{
    protected function getWidgetInstance():object
    {
        return ($this->isAccount) ? new AccountWidgetInstance() :new DashboardWidgetInstance();
    }

    protected function getAxisByDimensions(string $dateRow, string $dimensions = 'hour'): string
    {
        return match ($dimensions) {
            'date' => BaseHelper::formatDate($dateRow, 'M, d'),
            'yearMonth' => Carbon::createFromFormat('Ym', $dateRow)->format('M Y'),
            'hour' => BaseHelper::formatDate($dateRow, 'G').':00',
            default => (int)$dateRow . 'h',
        };
    }


    protected function getPeriodFromRequest(AnalyticsRequest $request, string $widgetName = 'widget_session_tracking_activity'): Period
    {
        $dashboardInstance = $this->getWidgetInstance();

        $predefinedRangeFound = $dashboardInstance->getFilterRange($request->input('predefined_range'));
        if ($request->input('changed_predefined_range')) {
            $dashboardInstance->saveSettings(
                $widgetName,
                ['predefined_range' => $predefinedRangeFound['key']]
            );
        }

        $startDate = $predefinedRangeFound['startDate'];

        $endDate = $predefinedRangeFound['endDate'];

        return Period::create($startDate, $endDate);
    }

    protected function getDimensionFromRequest(AnalyticsRequest $request): string
    {
        $predefinedRangeFound = $this->getWidgetInstance()->getFilterRange($request->input('predefined_range'));

        return Arr::get([
            'this_week' => 'date',
            'last_7_days' => 'date',
            'this_month' => 'date',
            'last_30_days' => 'date',
            'this_year' => 'yearMonth',
            'yesterday' => 'hour',
        ], $predefinedRangeFound['key'], 'hour');
    }


    public function getTrendPeriodFromRequest(AnalyticsRequest $request):string
    {
            /**
             * perMinute()
             * perHour()
             * perDay()
             * perMonth()
             * perYear()
            */
        return match ($request->input('predefined_range')) {
            'this_week' => 'perDay',
            'last_7_days' => 'perDay',
            'this_month' => 'perDay',
            'last_30_days' => 'perDay',
            'this_year' => 'perMonth',
            default => 'perHour',
        };
    }
}
