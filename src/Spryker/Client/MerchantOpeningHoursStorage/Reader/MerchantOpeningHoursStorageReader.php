<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MerchantOpeningHoursStorage\Reader;

use Generated\Shared\Transfer\MerchantOpeningHoursStorageTransfer;
use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\MerchantOpeningHoursStorage\Dependency\Client\MerchantOpeningHoursStorageToStorageClientInterface;
use Spryker\Client\MerchantOpeningHoursStorage\Dependency\Service\MerchantOpeningHoursStorageToSynchronizationServiceInterface;
use Spryker\Client\MerchantOpeningHoursStorage\Dependency\Service\MerchantOpeningHoursStorageToUtilEncodingServiceInterface;
use Spryker\Client\MerchantOpeningHoursStorage\Mapper\MerchantOpeningHoursMapperInterface;
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
     * @var \Spryker\Client\MerchantOpeningHoursStorage\Mapper\MerchantOpeningHoursMapperInterface
     */
    protected $merchantOpeningHoursMapper;

    /**
     * @var \Spryker\Client\MerchantOpeningHoursStorage\Dependency\Service\MerchantOpeningHoursStorageToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \Spryker\Client\MerchantOpeningHoursStorage\Dependency\Client\MerchantOpeningHoursStorageToStorageClientInterface $storageClient
     * @param \Spryker\Client\MerchantOpeningHoursStorage\Dependency\Service\MerchantOpeningHoursStorageToSynchronizationServiceInterface $synchronizationService
     * @param \Spryker\Client\MerchantOpeningHoursStorage\Mapper\MerchantOpeningHoursMapperInterface $merchantOpeningHoursMapper
     * @param \Spryker\Client\MerchantOpeningHoursStorage\Dependency\Service\MerchantOpeningHoursStorageToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        MerchantOpeningHoursStorageToStorageClientInterface $storageClient,
        MerchantOpeningHoursStorageToSynchronizationServiceInterface $synchronizationService,
        MerchantOpeningHoursMapperInterface $merchantOpeningHoursMapper,
        MerchantOpeningHoursStorageToUtilEncodingServiceInterface $utilEncodingService
    ) {
        $this->storageClient = $storageClient;
        $this->synchronizationService = $synchronizationService;
        $this->merchantOpeningHoursMapper = $merchantOpeningHoursMapper;
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param int $idMerchant
     *
     * @return \Generated\Shared\Transfer\MerchantOpeningHoursStorageTransfer|null
     */
    public function findMerchantOpeningHoursByIdMerchant(int $idMerchant): ?MerchantOpeningHoursStorageTransfer
    {
        $merchantOpeningHoursStorageData = $this->storageClient->get(
            $this->generateKey($idMerchant)
        );

        if (!$merchantOpeningHoursStorageData) {
            return null;
        }

        return $this->merchantOpeningHoursMapper
            ->mapMerchantOpeningHoursStorageDataToMerchantOpeningHoursStorageTransfer($merchantOpeningHoursStorageData, (new MerchantOpeningHoursStorageTransfer()));
    }

    /**
     * @param array $merchantIds
     *
     * @return \Generated\Shared\Transfer\MerchantOpeningHoursStorageTransfer[]
     */
    public function getMerchantOpeningHoursByMerchantIds(array $merchantIds): array
    {
        $merchantOpeningHoursStorageData = $this->storageClient->getMulti(
            $this->generateKeys($merchantIds)
        );

        if (!$merchantOpeningHoursStorageData) {
            return [];
        }

        $merchantOpeningHoursStorageTransfers = [];
        foreach ($merchantOpeningHoursStorageData as $storageKey => $merchantOpeningHoursStorageDatum) {
            $merchantOpeningHoursStorageTransfers[$this->getIdMerchant($storageKey)] = $this->merchantOpeningHoursMapper
                ->mapMerchantOpeningHoursStorageDataToMerchantOpeningHoursStorageTransfer(
                    $this->utilEncodingService->decodeJson($merchantOpeningHoursStorageDatum, true),
                    (new MerchantOpeningHoursStorageTransfer())
                );
        }

        return $merchantOpeningHoursStorageTransfers;
    }

    /**
     * @param string $storageKey
     *
     * @return int
     */
    protected function getIdMerchant(string $storageKey): int
    {
        $storageKeyArray = explode(':', $storageKey);

        return (int)end($storageKeyArray);
    }

    /**
     * @param int[] $merchantIds
     *
     * @return string[]
     */
    protected function generateKeys(array $merchantIds): array
    {
        $merchantOpeningHoursStorageKeys = [];
        foreach ($merchantIds as $idMerchant) {
            $merchantOpeningHoursStorageKeys[] = $this->generateKey($idMerchant);
        }

        return $merchantOpeningHoursStorageKeys;
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
