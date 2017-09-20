<?php

declare(strict_types = 1);

namespace Sergiors\RDStation;

interface StageInterface
{
    public function lifecycleStage(): int;
    
    public function isOpportunity(): bool;
}
