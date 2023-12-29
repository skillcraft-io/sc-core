<?php

namespace Skillcraft\Core\Supports\Trend;

use Error;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Skillcraft\Core\Supports\Trend\Adapters\MySqlAdapter;
use Skillcraft\Core\Supports\Trend\Adapters\PgsqlAdapter;
use Skillcraft\Core\Supports\Trend\Adapters\SqliteAdapter;

final class Trend
{
    public string $interval;

    public Carbon $start;

    public Carbon $end;

    public string $dateColumn = 'created_at';

    public string $dateAlias = 'date';

    public function __construct(public Builder $builder)
    {
    }

    public static function query(Builder $builder): self
    {
        return new static($builder);
    }

    public static function model(string $model): self
    {
        return new static($model::query());
    }

    public function between($start, $end): self
    {
        $this->start = $start;
        $this->end = $end;

        return $this;
    }

    public function interval(string $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function perMinute(): self
    {
        return $this->interval('minute');
    }

    public function perHour(): self
    {
        return $this->interval('hour');
    }

    public function perDay(): self
    {
        return $this->interval('day');
    }

    public function perMonth(): self
    {
        return $this->interval('month');
    }

    public function perYear(): self
    {
        return $this->interval('year');
    }

    /**
     * Sets the date column for the query builder.
     *
     * @param string $column The name of the date column.
     * @return self
     */
    public function dateColumn(string $column): self
    {
        $this->dateColumn = $column;

        return $this;
    }

    /**
     * Sets the date alias.
     *
     * @param string $alias The alias for the date.
     * @return self The current instance of the class.
     */
    public function dateAlias(string $alias): self
    {
        $this->dateAlias = $alias;

        return $this;
    }

    /**
     * @param string $column
     * @param string $aggregate
     * @return Collection
     */
    public function aggregate(string $column, string $aggregate): Collection
    {
        $values = $this->builder
            ->toBase()
            ->selectRaw("
                {$this->getSqlDate()} as {$this->dateAlias},
                {$aggregate}({$column}) as aggregate
            ")
            ->whereBetween($this->dateColumn, [$this->start, $this->end])
            ->groupBy($this->dateAlias)
            ->orderBy($this->dateAlias)
            ->get();

        return $this->mapValuesToDates($values);
    }

    /**
     * Calculates the average value of a given column.
     *
     * @param string $column The name of the column to calculate the average for.
     * @return Collection The collection containing the calculated average value.
     */
    public function average(string $column): Collection
    {
        return $this->aggregate($column, 'avg');
    }

    /**
     * Retrieves the minimum value from the specified column.
     *
     * @param string $column The column from which to retrieve the minimum value.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Collection The collection containing the minimum value from the specified column.
     */
    public function min(string $column): Collection
    {
        return $this->aggregate($column, 'min');
    }

    /**
     * Retrieves the maximum value from the specified column.
     *
     * @param string $column The name of the column to retrieve the maximum value from.
     * @return Collection The collection of maximum values.
     */
    public function max(string $column): Collection
    {
        return $this->aggregate($column, 'max');
    }

    /**
     * Retrieves the sum of a specified column.
     *
     * @param string $column The name of the column to sum.
     * @return Collection The collection of summed column values.
     */
    public function sum(string $column): Collection
    {
        return $this->aggregate($column, 'sum');
    }

    /**
     * Count the number of records in the collection.
     *
     * @param string $column The column to count records from. Default is '*'.
     * @return Collection The collection with the count result.
     */
    public function count(string $column = '*'): Collection
    {
        return $this->aggregate($column, 'count');
    }

    /**
     * Maps the values in the given collection to dates and returns a new collection.
     *
     * @param Collection $values The collection of values to be mapped.
     * @return Collection The new collection with values mapped to dates.
     */
    public function mapValuesToDates(Collection $values): Collection
    {
        $values = $values->map(fn ($value) => new TrendValue(
            date: $value->{$this->dateAlias},
            aggregate: $value->aggregate,
        ));

        $placeholders = $this->getDatePeriod()->map(
            fn (Carbon $date) => new TrendValue(
                date: $date->format($this->getCarbonDateFormat()),
                aggregate: 0,
            )
        );

        return $values
            ->merge($placeholders)
            ->unique('date')
            ->sort()
            ->flatten();
    }

    /**
     * Retrieves a collection of dates within a specified period.
     *
     * @return Collection A collection of dates within the specified period.
     */
    protected function getDatePeriod(): Collection
    {
        return collect(
            CarbonPeriod::between(
                $this->start,
                $this->end,
            )->interval("1 {$this->interval}")
        );
    }

    /**
     * Generates a SQL date string based on the specified interval.
     *
     * @return string The formatted SQL date string.
     * @throws Error If an invalid interval is provided.
     */
    protected function getSqlDate(): string
    {
        $adapter = match ($this->builder->getConnection()->getDriverName()) {
            'mysql' => new MySqlAdapter(),
            'sqlite' => new SqliteAdapter(),
            'pgsql' => new PgsqlAdapter(),
            default => throw new Error('Unsupported database driver.'),
        };

        return $adapter->format($this->dateColumn, $this->interval);
    }

    /**
     * Returns the Carbon date format based on the interval.
     *
     * @return string The Carbon date format.
     * @throws Error When the interval is invalid.
     */
    protected function getCarbonDateFormat(): string
    {
        return match ($this->interval) {
            'minute' => 'Y-m-d H:i:00',
            'hour' => 'Y-m-d H:00',
            'day' => 'Y-m-d',
            'month' => 'Y-m',
            'year' => 'Y',
            default => throw new Error('Invalid interval.'),
        };
    }
}
