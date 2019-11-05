<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MerchantOpeningHoursStorage\Reader;

use Generated\Shared\Transfer\MerchantOpeningHoursStorageTransfer;
use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\MerchantOpeningHoursStorage\Dependency\Client\MerchantOpeningHoursStorageToStorageClientInterface;
use Spryker\Client\MerchantOpeningHoursStorage\Dependency\Service\MerchantOpeningHoursStorageToSynchronizationServiceInterface;
use Spryker\Shared\MerchantOpeningHoursStorage\MerchantOpeningHoursStorageConfig;

class MerchantOpeningHoursStorageReader implements MerchantOpeningHoursStorageReaderInterface
{
    /**
     * @var \Spryker\Client\MerchantOpeningHoursStorage\Dependency\Client\MerchantOpeningHoursStorageToStorageClientInterface
     */
    protected $storageClient;

    /**
     * @var \Spryker\Client\MerchantOpeningHoursStorage\Dependency\Service\MerchantOpeningHoursStorageToSynchronizationServiceInterface
     */
    protected $synchronizationService;

    /**
     * @param \Spryker\Client\MerchantOpeningHoursStorage\Dependency\Client\MerchantOpeningHoursStorageToStorageClientInterface $storageClient
     * @param \Spryker\Client\MerchantOpeningHoursStorage\Dependency\Service\MerchantOpeningHoursStorageToSynchronizationServiceInterface $synchronizationService
     */
    public function __construct(
        MerchantOpeningHoursStorageToStorageClientInterface $storageClient,
        MerchantOpeningHoursStorageToSynchronizationServiceInterface $synchronizationService
    ) {
        $this->storageClient = $storageClient;
        $this->synchronizationService = $synchronizationService;
    }

    /**
     * @param int $idMerchant
     *
     * @return \Generated\Shared\Transfer\MerchantOpeningHoursStorageTransfer|null
     */
    public function findMerchantOpeningHoursByIdIdMerchant(int $idMerchant): ?MerchantOpeningHoursStorageTransfer
    {
        $merchantOpeningHoursStorageTransferData = $this->storageClient->get(
            $this->generateKey($idMerchant)
        );

        if (!$merchantOpeningHoursStorageTransferData) {
            return null;
        }

        return $this->mapToMerchantOpeningHoursStorage($merchantOpeningHoursStorageTransferData);
    }

    /**
     * @param array $merchantOpeningHoursStorageTransferData
     *
     * @return \Generated\Shared\Transfer\MerchantOpeningHoursStorageTransfer
     */
    protected function mapToMerchantOpeningHoursStorage(array $merchantOpeningHoursStorageTransferData): MerchantOpeningHoursStorageTransfer
    {
        return (new MerchantOpeningHoursStorageTransfer())
            ->fromArray($merchantOpeningHoursStorageTransferData, true);
    }

    /**
     * @param int $idMerchant
     *
     * @return string
     */
    protected function generateKey(int $idMerchant): string
    {
        $synchronizationDataTransfer = (new SynchronizationDataTransfer())
            ->setReference((string)$idMerchant);

        return $this->synchronizationService
            ->getStorageKeyBuilder(MerchantOpeningHoursStorageConfig::MERCHANT_OPENING_HOURS_RESOURCE_NAME)
            ->generateKey($synchronizationDataTransfer);
    }
}
