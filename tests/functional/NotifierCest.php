<?php

namespace Tests\functional;

use Codeception\Example;
use FunctionalTester;
use Worfect\Notice\Notice;
use Worfect\Notice\Notifier;

class NotifierCest
{

    /**
     *
     * @param FunctionalTester $I
     */
    public function easyWay(FunctionalTester $I)
    {
        notice('test');

        $message = \session()->get('notice');

        $I->assertEquals('test', $message['0']['message']);
        $I->assertEquals('info', $message['0']['level']);
        $I->assertEquals(false, $message['0']['overlay']);
        $I->assertEquals(false, $message['0']['title']);
        $I->assertEquals(false, $message['0']['important']);
    }

    /**
     *
     * @example (message="test2", level="danger")
     * @example (message="test3", level="warning")
     * @example (message="test0", level="info")
     * @example (message="test1", level="success")
     *
     * @param FunctionalTester $I
     * @param Example $example
     */
    public function easyCustomParamsWay(FunctionalTester $I, Example $example)
    {
        notice($example['message'], $example['level']);

        $message = \session()->get('notice');

        $I->assertEquals($example['message'], $message[0]['message']);
        $I->assertEquals($example['level'], $message[0]['level']);
        $I->assertEquals(false, $message[0]['overlay']);
        $I->assertEquals(false, $message[0]['title']);
        $I->assertEquals(false, $message[0]['important']);
    }

    /**
     *
     * @param FunctionalTester $I
     */
    public function facadeWayContainsInstanceOfNotice(FunctionalTester $I)
    {
        $I->assertInstanceOf(Notifier::class, Notice::info('info'));
    }

    /**
     *
     * @param FunctionalTester $I
     */
    public function hardWayContainsInstanceOfNotice(FunctionalTester $I)
    {
        $I->assertInstanceOf(Notifier::class, notice());
    }

    /**
     *
     * @param FunctionalTester $I
     * @param Notifier $notice
     */
    public function overlayMethod(FunctionalTester $I, Notifier $notice)
    {
        $notice->success('success')->overlay('title');

        $I->assertEquals('success', $notice->message['message']);
        $I->assertEquals('success', $notice->message['level']);
        $I->assertEquals(true, $notice->message['overlay']);
        $I->assertEquals('title', $notice->message['title']);
        $I->assertEquals(false, $notice->message['important']);

        $notice->success('success')->overlay();

        $I->assertEquals(false, $notice->message['title']);
    }

    /**
     *
     * @param FunctionalTester $I
     * @param Notifier $notice
     */
    public function importantMethod(FunctionalTester $I, Notifier $notice)
    {
        $notice->success('success')->important();

        $I->assertEquals('success', $notice->message['message']);
        $I->assertEquals('success', $notice->message['level']);
        $I->assertEquals(false, $notice->message['overlay']);
        $I->assertEquals(false, $notice->message['title']);
        $I->assertEquals(true, $notice->message['important']);
    }


    /**
     *
     * @param FunctionalTester $I
     * @param Notifier $notice
     */
    public function importantOverlayMethodsPriority(FunctionalTester $I, Notifier $notice)
    {
        $notice->success('success')->important()->overlay('test');

        $I->assertEquals(true, $notice->message['overlay']);
        $I->assertEquals('test', $notice->message['title']);
        $I->assertEquals(false, $notice->message['important']);

        $notice->success('success')->overlay('test')->important();

        $I->assertEquals(false, $notice->message['overlay']);
        $I->assertEquals(false, $notice->message['title']);
        $I->assertEquals(true, $notice->message['important']);
    }

    /**
     *
     * @param FunctionalTester $I
     */
    public function severalMessageInStorages(FunctionalTester $I)
    {
        $examples = [
            ['message'=>"test1", 'level'=>"info"],
            ['message'=>"test2", 'level'=>"success"]
        ];

        foreach ($examples as $example){
            $level = $example['level'];
            $message =  $example['level'];

            notice($message, $level);
            $json = notice()->$level($message)->json();
            $html =  notice()->$level($message)->html();
        }

        $I->assertCount(2, notice()->storages['session']->store);
        $I->assertCount(2, notice()->storages['json']->store);
        $I->assertCount(2, notice()->storages['html']->store);
    }

    /**
     *
     * @param FunctionalTester $I
     */
    public function ifThereIsNoMessage(FunctionalTester $I)
    {
        \notice('', 'success');
        $message = \session()->get('notice');

        $I->assertEquals('success', $message['0']['message']);

//        $I->expectThrowable(new Exception('Sending a blank notification'), function() {
//            \notice('', 'success');
//        });
    }
}
