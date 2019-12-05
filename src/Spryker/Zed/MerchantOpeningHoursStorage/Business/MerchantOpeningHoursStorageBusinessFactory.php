<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantOpeningHoursStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\MerchantOpeningHoursStorage\Business\Publisher\MerchantOpeningHoursStoragePublisher;
use Spryker\Zed\MerchantOpeningHoursStorage\Business\Publisher\MerchantOpeningHoursStoragePublisherInterface;

/**
 * @method \Spryker\Zed\MerchantOpeningHoursStorage\MerchantOpeningHoursStorageConfig getConfig()
 * @method \Spryker\Zed\MerchantOpeningHoursStorage\Persistence\MerchantOpeningHoursStorageEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\MerchantOpeningHoursStorage\Persistence\MerchantOpeningHoursStorageRepositoryInterface getRepository()
 */
class MerchantOpeningHoursStorageBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\MerchantOpeningHoursStorage\Business\Publisher\MerchantOpeningHoursStoragePublisherInterface
     */
    public function createMerchantOpeningHoursStoragePublisher(): MerchantOpeningHoursStoragePublisherInterface
    {
        return new MerchantOpeningHoursStoragePublisher(
            $this->getEntityManager(),
            $this->getRepository()
        );
    }
}
