<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantOpeningHoursStorage\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\FilterTransfer;

interface MerchantOpeningHoursStorageRepositoryInterface
{
    /**
     * @param int $fkMerchant
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\WeekdayScheduleTransfer[]
     */
    public function getMerchantOpeningHoursWeekdayScheduleByFkMerchant(int $fkMerchant): ArrayObject;

    /**
     * @param int $fkMerchant
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\DateScheduleTransfer[]
     */
    public function getMerchantOpeningHoursDateScheduleByFkMerchant(int $fkMerchant): ArrayObject;

    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param int[] $merchantIds
     *
     * @return \Generated\Shared\Transfer\SpyMerchantOpeningHoursStorageEntityTransfer[]
     */
    public function getFilteredMerchantOpeningHoursStorageEntities(FilterTransfer $filterTransfer, array $merchantIds): array;

    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantTransfer[]
     */
    public function getFilteredMerchantTransfers(FilterTransfer $filterTransfer): array;
}