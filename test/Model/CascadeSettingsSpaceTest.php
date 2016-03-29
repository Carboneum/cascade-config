<?php

namespace CarboneumTest\CascadeConfig\Model;

use Carboneum\CascadeConfig\Model\ImmutableSettingsSpace;
use Carboneum\CascadeConfig\Source\CascadeSettingsSpace\CascadeArraySource;
use Carboneum\NestedState\State;

/**
 * Class CascadeSettingsSpaceTest
 * @package CarboneumTest\CascadeConfig
 */
class CascadeSettingsSpaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $settings
     * @param array $stateParams
     * @param array $expectedConfig
     *
     * @dataProvider provideTestGetAllConfig
     */
    public function testGetAllConfig(array $settings, array $stateParams, array $expectedConfig)
    {
        $settings = (new CascadeArraySource(['settings' => $settings]))->getSettingsSpace('settings');
        $settings->setState(new State($stateParams));

        $this->assertEquals($expectedConfig, $settings->getAll());

        foreach ($expectedConfig as $key => $value) {
            $this->assertEquals($value, $settings->get($key));
        }

        $this->assertEquals('settings', $settings->getName());
    }

    /**
     * @return array
     */
    public function provideTestGetAllConfig()
    {
        return [
            [
                'settings' => [
                    '' => [
                        'param1' => 100,
                        'param2' => true
                    ],
                    'foo=10' => [
                        'param2' => false,
                        'param3' => 'value'
                    ],
                    'foo=10&bar=false' => [
                        'param3' => 'value-wrong',
                        'param4' => 10
                    ],
                    'foo=10&bar=true' => [
                        'param3' => 'value-right',
                        'param4' => 20
                    ],
                ],
                'stateParams' => ['foo' => '10', 'bar' => 'true'], // @todo fix types of state params
                'expectedConfig' => [
                    'param1' => 100,
                    'param2' => false,
                    'param3' => 'value-right',
                    'param4' => 20

                ]
            ]
        ];
    }

    /**
     * @param array $settings
     * @param array $stateParams
     * @param array $stateChange
     * @param array $expectedConfigBefore
     * @param array $expectedConfigAfter
     *
     * @dataProvider provideTestTriggerStateChange
     */
    public function testTriggerStateChange(
        array $settings,
        array $stateParams,
        array $stateChange,
        array $expectedConfigBefore,
        array $expectedConfigAfter
    ) {

        $settings = (new CascadeArraySource(['settings' => $settings]))->getSettingsSpace('settings');
        $settingsImmutable = new ImmutableSettingsSpace($settings);

        $state = new State($stateParams);
        $settings->setState($state);

        $this->assertEquals($expectedConfigBefore, $settings->getAll());

        foreach ($stateChange as $key => $value) {
            $state->setParameter($key, $value);
        }

        $settings->triggerStateChange();

        $this->assertEquals($expectedConfigAfter, $settingsImmutable->getAll());
    }

    /**
     * @return array
     */
    public function provideTestTriggerStateChange()
    {
        return [
            [
                'settings' => [
                    '' => [
                        'param1' => 100,
                        'param2' => true
                    ],
                    'foo=10' => [
                        'param2' => false,
                        'param3' => 'value'
                    ],
                    'foo=20' => [
                        'param3' => 'value-right',
                        'param4' => 10
                    ],
                ],
                'stateParams' => ['foo' => '10', 'bar' => 'true'],
                'stateChange' => ['foo' => '20'],
                'expectedConfigBefore' => [
                    'param1' => 100,
                    'param2' => false,
                    'param3' => 'value'

                ],
                'expectedConfigAfter' => [
                    'param1' => 100,
                    'param2' => true,
                    'param3' => 'value-right',
                    'param4' => 10
                ]
            ]
        ];
    }

    /**
     * @expectedException \Carboneum\CascadeConfig\Exception\SettingsSpaceKey\SpaceKeyMissingException
     */
    public function testException()
    {
        $source = new CascadeArraySource(
            [
                'settings' => [
                    'foo=olo' => [
                        'baz' => 10
                    ],
                    'foo=bar' => [
                        'bar' => 20
                    ]
                ]
            ]
        );

        $settings = $source->getSettingsSpace('settings');
        $settings->setState(new State(['foo' => 'bar']));

        $settings->get('baz');
    }
}
