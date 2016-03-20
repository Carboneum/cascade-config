<?php

namespace CarboneumTest\CascadeConfig;

use Carboneum\CascadeConfig\ConfigurationService;
use Carboneum\CascadeConfig\Interfaces\SourceInterface;
use Carboneum\CascadeConfig\Source\CascadeSettingsSpace\CascadeArraySource;
use Carboneum\CascadeConfig\Source\SimpleSettingsSpace\SimpleArraySource;
use Carboneum\NestedState\State;

/**
 * Class ConfigurationServiceTest
 * @package CarboneumTest\CascadeConfig
 */
class ConfigurationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param SourceInterface[] $sources
     * @param State $state
     * @param array $expectedSettingsBySpace
     *
     * @dataProvider provideTestGetSettingsSpaces
     */
    public function testGetSettingsSpaces(array $sources, State $state, array $expectedSettingsBySpace)
    {
        $configurationService = new ConfigurationService($sources);
        $configurationService->setState($state);

        foreach ($expectedSettingsBySpace as $spaceName => $expectedSettings) {
            $this->assertEquals($expectedSettings, $configurationService->getSettingsSpace($spaceName)->getAll());
        }
    }

    /**
     * @return array
     */
    public function provideTestGetSettingsSpaces()
    {
        return [
            [
                'sources' => [
                    new SimpleArraySource(['simpleSettings' => ['foo' => 'bar']]),
                    new CascadeArraySource(
                        [
                            'cascadeSettings' => [
                                '' => ['city' => 'San Paulo', 'Country' => 'USA'],
                                'env=dev&user=null' => ['city' => 'San Francisco']
                            ]
                        ]
                    )
                ],
                'state' => new State(['env' => 'dev', 'user' => 'null']),
                'expectedSettingsBySpace' => [
                    'simpleSettings' => ['foo' => 'bar'],
                    'cascadeSettings' => ['city' => 'San Francisco', 'Country' => 'USA']
                ]
            ]
        ];
    }

    /**
     * @param array $sources
     * @param State $state
     * @param array $expectedSettingsBySpace
     * @param array $stateChange
     * @param array $expectedSettingsBySpaceAfterStateChange
     *
     * @dataProvider provideTestTriggerStateChange
     */
    public function testTriggerStateChange(
        array $sources,
        State $state,
        array $expectedSettingsBySpace,
        array $stateChange,
        array $expectedSettingsBySpaceAfterStateChange
    ) {

        $configurationService = new ConfigurationService($sources);
        $configurationService->setState($state);

        foreach ($expectedSettingsBySpace as $spaceName => $expectedSettings) {
            $this->assertEquals($expectedSettings, $configurationService->getSettingsSpace($spaceName)->getAll());
        }

        foreach ($stateChange as $parameter => $value) {
            $state->setParameter($parameter, $value);
        }

        foreach ($expectedSettingsBySpace as $spaceName => $expectedSettings) {
            $this->assertEquals($expectedSettings, $configurationService->getSettingsSpace($spaceName)->getAll());
        }

        $configurationService->triggerStateChange();

        foreach ($expectedSettingsBySpaceAfterStateChange as $spaceName => $expectedSettings) {
            $this->assertEquals($expectedSettings, $configurationService->getSettingsSpace($spaceName)->getAll());
        }

    }

    /**
     * @return array
     */
    public function provideTestTriggerStateChange()
    {
        return [
            'state change after init' => [
                'sources' => [
                    new SimpleArraySource(['simpleSettings' => ['foo' => 'bar']]),
                    new CascadeArraySource(
                        [
                            'cascadeSettings' => [
                                '' => ['city' => 'San Paulo', 'Country' => 'USA'],
                                'env=dev&user=125' => ['city' => 'San Francisco']
                            ]
                        ]
                    )
                ],
                'state' => new State(['env' => 'dev', 'user' => 'null']),
                'expectedSettingsBySpace' => [
                    'simpleSettings' => ['foo' => 'bar'],
                    'cascadeSettings' => ['city' => 'San Paulo', 'Country' => 'USA']
                ],
                'stateChange' => ['user' => '125'],
                'expectedSettingsBySpaceAfterStateChange' => [
                    'simpleSettings' => ['foo' => 'bar'],
                    'cascadeSettings' => ['city' => 'San Francisco', 'Country' => 'USA']
                ]
            ],
            'init after state change' => [
                'sources' => [
                    new SimpleArraySource(['simpleSettings' => ['foo' => 'bar']]),
                    new CascadeArraySource(
                        [
                            'cascadeSettings' => [
                                '' => ['city' => 'San Paulo', 'Country' => 'USA'],
                                'env=dev&user=125' => ['city' => 'San Francisco']
                            ]
                        ]
                    )
                ],
                'state' => new State(['env' => 'dev', 'user' => 'null']),
                'expectedSettingsBySpace' => [], // not initialising
                'stateChange' => ['user' => '125'],
                'expectedSettingsBySpaceAfterStateChange' => [
                    'simpleSettings' => ['foo' => 'bar'],
                    'cascadeSettings' => ['city' => 'San Francisco', 'Country' => 'USA']
                ]
            ],
        ];
    }

    /**
     * @expectedException \Carboneum\CascadeConfig\Exception\ConfigurationException\InvalidSourceException
     */
    public function testInvalidSourceException()
    {
        new ConfigurationService(
            [
                new SimpleArraySource(['simpleSettings' => ['foo' => 'bar']]),
                false
            ]
        );
    }

    /**
     * @expectedException \Carboneum\CascadeConfig\Exception\SettingsSpace\SpaceNotDefinedException
     */
    public function testSpaceNotDefinedException()
    {
        $configurationService = new ConfigurationService(
            [new SimpleArraySource(['simpleSettings' => ['foo' => 'bar']])]
        );

        $configurationService->getSettingsSpace('notExists');
    }

    /**
     * @expectedException \Carboneum\CascadeConfig\Exception\ConfigurationException\StateIsNotDefined
     */
    public function testStateIsNotDefined()
    {
        $configurationService = new ConfigurationService(
            [
                new SimpleArraySource(['simpleSettings' => ['foo' => 'bar']]),
                new CascadeArraySource(
                    [
                        'cascadeSettings' => [
                            '' => ['city' => 'San Paulo', 'Country' => 'USA'],
                            'env=dev&user=125' => ['city' => 'San Francisco']
                        ]
                    ]
                )
            ]
        );

        $configurationService->getSettingsSpace('cascadeSettings');
    }
}
