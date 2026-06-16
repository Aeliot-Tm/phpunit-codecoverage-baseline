<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\Model;

final class ComparingResult
{
    /**
     * @var bool
     */
    private $hasImprovement = false;

    /**
     * @var ComparingRow[]
     */
    private $rows = [];

    /**
     * @var string[]
     */
    private $regressedNames = [];

    public function addRow(ComparingRow $row): void
    {
        $this->rows[] = $row;
        if ($row->hasRegress()) {
            $this->regressedNames[] = $row->getName();
        } elseif ($row->hasProgress()) {
            $this->hasImprovement = true;
        }
    }

    /**
     * @return ComparingRow[]
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @return string[]
     */
    public function getRegressedNames(): array
    {
        return $this->regressedNames;
    }

    public function hasImprovement(): bool
    {
        return $this->hasImprovement;
    }
}
