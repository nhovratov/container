<?php

declare(strict_types=1);
namespace B13\Container\Tests\Functional\Datahandler\DefaultLanguage;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Tests\Functional\Datahandler\DatahandlerTest;

class CopyElementTest extends DatahandlerTest
{

    /**
     * @test
     */
    public function copyChildElementOutsideContainerAtTop(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/CopyElement/setup.xml');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 1,
                        'update' => [
                            'colPos' => 0,
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(0, (int)$row['tx_container_parent']);
        self::assertSame(0, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(0, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function copyChildElementOutsideContainerAfterElement(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/CopyElement/setup.xml');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => -4,
                        'update' => [
                            'colPos' => 0,
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(0, (int)$row['tx_container_parent']);
        self::assertSame(0, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(0, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function copyChildElementToOtherColumnTop(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/CopyElement/setup.xml');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 1,
                        'update' => [
                            'colPos' => '1-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(1, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(0, (int)$row['sys_language_uid']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($row['sorting'] > $container['sorting'], 'copied element is not sorted after container');
    }

    /**
     * @test
     */
    public function copyChildElementToOtherColumnAfterElement(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/CopyElement/setup.xml');
        $cmdmap = [
            'tt_content' => [
                2 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => -3,
                        'update' => [
                            'colPos' => '1-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(1, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(0, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function copyElementIntoContainerAtTop(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/CopyElement/setup.xml');
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 1,
                        'update' => [
                            'colPos' => '1-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 4);
        self::assertSame(1, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(0, (int)$row['sys_language_uid']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($row['sorting'] > $container['sorting'], 'copied element is not sorted after container');
    }

    /**
     * @test
     */
    public function copyElementIntoContainerAfterElement(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/CopyElement/setup.xml');
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => -3,
                        'update' => [
                            'colPos' => '1-201',
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 4);
        self::assertSame(1, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(0, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function copyElementIntoContainerAfterElementWithSimpleCommandMap(): void
    {
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/CopyElement/setup.xml');
        // see test above what should be done
        $cmdmap = [
            'tt_content' => [
                4 => [
                    'copy' => -3,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 4);
        self::assertSame(1, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame(1, (int)$row['pid']);
        self::assertSame(0, (int)$row['sys_language_uid']);
    }
}
