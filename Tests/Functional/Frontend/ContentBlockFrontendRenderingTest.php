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

namespace TYPO3\CMS\ContentBlocks\Tests\Functional\Frontend;

use TYPO3\CMS\Core\Tests\Functional\SiteHandling\SiteBasedTestTrait;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class ContentBlockFrontendRenderingTest extends FunctionalTestCase
{
    use SiteBasedTestTrait;

    protected array $coreExtensionsToLoad = [
//        'content_blocks',
    ];

    protected array $testExtensionsToLoad = [
        'typo3conf/ext/content_blocks/Tests/Fixtures/Extensions/simple',
        'typo3conf/ext/content_blocks',
    ];

    protected const LANGUAGE_PRESETS = [
        'EN' => ['id' => 0, 'title' => 'English', 'locale' => 'en_US.UTF8'],
    ];

    protected const ROOT_PAGE_ID = 1;

    public function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet('typo3conf/ext/content_blocks/Tests/Functional/Frontend/Fixtures/frontend.csv');
        $this->writeSiteConfiguration(
            'fluid_template',
            $this->buildSiteConfiguration(self::ROOT_PAGE_ID, '/'),
        );
    }

    /**
     * @test
     */
    public function variablesAndAssetsRendered(): void
    {
        $this->setUpFrontendRootPage(
            self::ROOT_PAGE_ID,
            [
                'typo3conf/ext/content_blocks/Tests/Functional/Frontend/Fixtures/frontend.typoscript',
            ]
        );
        $response = $this->executeFrontendSubRequest((new InternalRequest())->withPageId(self::ROOT_PAGE_ID));
        $html = (string)$response->getBody();
        self::assertStringContainsString('HeaderSimple', $html);
        self::assertStringContainsString('BodytextSimple', $html);
        self::assertStringContainsString('Simple Content Block', $html);
        self::assertStringContainsString('<p>uid:1</p>', $html);
        self::assertStringContainsString('<p>pid:1</p>', $html);
        self::assertStringContainsString('<p>languageId:0</p>', $html);
        self::assertStringContainsString('<p>typeName:simple_simple</p>', $html);
        self::assertStringContainsString('<p>tableName:tt_content</p>', $html);
        self::assertStringContainsString('<p>creationDate:1697810914</p>', $html);
        self::assertStringContainsString('<p>updateDate:1697810925</p>', $html);
        self::assertStringContainsString('<link href="/typo3conf/ext/simple/ContentBlocks/ContentElements/simple/Assets/Frontend.css', $html);
        self::assertStringContainsString('<script src="/typo3conf/ext/simple/ContentBlocks/ContentElements/simple/Assets/Frontend.js', $html);
    }
}
