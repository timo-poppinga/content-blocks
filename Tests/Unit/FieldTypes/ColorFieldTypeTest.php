<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CMS\ContentBlocks\Tests\Unit\FieldTypes;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\ContentBlocks\Tests\Unit\Fixtures\FieldTypeRegistryTestFactory;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

final class ColorFieldTypeTest extends UnitTestCase
{
    public static function getTcaReturnsExpectedTcaDataProvider(): iterable
    {
        yield 'truthy values' => [
            'config' => [
                'label' => 'foo',
                'description' => 'foo',
                'displayCond' => [
                    'foo' => 'bar',
                ],
                'l10n_display' => 'foo',
                'l10n_mode' => 'foo',
                'onChange' => 'foo',
                'exclude' => true,
                'non_available_field' => 'foo',
                'default' => '#000000',
                'placeholder' => 'Placeholder text',
                'size' => 20,
                'autocomplete' => 1,
                'required' => 1,
                'readOnly' => 1,
                'nullable' => 1,
                'mode' => 'useOrOverridePlaceholder',
                'valuePicker' => [
                    'items' => [
                        ['One', '1'],
                        ['Two', '2'],
                    ],
                ],
                'opacity' => true,
            ],
            'expectedTca' => [
                'label' => 'foo',
                'description' => 'foo',
                'displayCond' => [
                    'foo' => 'bar',
                ],
                'l10n_display' => 'foo',
                'l10n_mode' => 'foo',
                'onChange' => 'foo',
                'exclude' => true,
                'config' => [
                    'type' => 'color',
                    'size' => 20,
                    'default' => '#000000',
                    'readOnly' => true,
                    'nullable' => true,
                    'mode' => 'useOrOverridePlaceholder',
                    'placeholder' => 'Placeholder text',
                    'required' => true,
                    'autocomplete' => true,
                    'valuePicker' => [
                        'items' => [
                            ['One', '1'],
                            ['Two', '2'],
                        ],
                    ],
                    'opacity' => true,
                ],
            ],
        ];

        yield 'falsy values' => [
            'config' => [
                'label' => '',
                'description' => null,
                'displayCond' => [],
                'l10n_display' => '',
                'l10n_mode' => '',
                'onChange' => '',
                'exclude' => false,
                'non_available_field' => 'foo',
                'default' => '',
                'placeholder' => '',
                'size' => 0,
                'autocomplete' => 0,
                'required' => 0,
                'readOnly' => 0,
                'nullable' => 0,
                'mode' => '',
                'valuePicker' => [
                    'items' => [],
                ],
                'opacity' => false,
            ],
            'expectedTca' => [
                'config' => [
                    'type' => 'color',
                    'default' => '',
                    'autocomplete' => false,
                ],
            ],
        ];

        yield 'default value null for nullable' => [
            'config' => [
                'nullable' => true,
            ],
            'expectedTca' => [
                'exclude' => true,
                'config' => [
                    'type' => 'color',
                    'default' => null,
                    'nullable' => true,
                ],
            ],
        ];

        yield 'no default value set' => [
            'config' => [
                'nullable' => false,
            ],
            'expectedTca' => [
                'exclude' => true,
                'config' => [
                    'type' => 'color',
                ],
            ],
        ];
    }

    #[DataProvider('getTcaReturnsExpectedTcaDataProvider')]
    #[Test]
    public function getTcaReturnsExpectedTca(array $config, array $expectedTca): void
    {
        $fieldTypeRegistry = FieldTypeRegistryTestFactory::create();
        $fieldType = $fieldTypeRegistry->get('Color');
        $fieldConfiguration = $fieldType->createFromArray($config);

        self::assertSame($expectedTca, $fieldConfiguration->getTca());
    }
}
