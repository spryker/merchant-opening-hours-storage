<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantOpeningHoursStorage;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class MerchantOpeningHoursStorageConfig extends AbstractBundleConfig
{
    /**
     * @return bool
     */
    public function isSendingToQueue(): bool
    {
        return true;
    }

    /**
     * @return string|null
     */
    public function getMerchantOpeningHoursSynchronizationPoolName(): ?string
    {
        return 'synchronizationPool';
    }
}
