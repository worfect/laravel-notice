<?php

namespace Tests\functional;

use Codeception\Example;
use FunctionalTester;
use Worfect\Notice\HtmlStorage;
use Worfect\Notice\JsonStorage;
use Worfect\Notice\Message;
use Worfect\Notice\Notice;
use Worfect\Notice\Notifier;
use Worfect\Notice\SessionStorage;

class NotifierCest
{
    /**
     *
     * @param FunctionalTester $I
     */
    public function easyWay(FunctionalTester $I)
    {
        notice('test');

        $session = \session()->get('notice');

        $I->assertEquals('test', $session['0']['message']);
        $I->assertEquals('info', $session['0']['level']);
        $I->assertEquals(false, $session['0']['overlay']);
        $I->assertEquals(false, $session['0']['title']);
        $I->assertEquals(false, $session['0']['important']);
    }

    /**
     *
     * @example (message="test0", level="danger")
     * @example (message="test1", level="warning")
     * @example (message="test2", level="info")
     * @example (message="test3", level="success")
     *
     * @param FunctionalTester $I
     * @param Example $example
     */
    public function easyCustomParamsWay(FunctionalTester $I, Example $example)
    {
        notice($example['message'], $example['level']);

        $session = \session()->get('notice');

        $I->assertEquals($example['message'], $session[0]['message']);
        $I->assertEquals($example['level'], $session[0]['level']);
        $I->assertEquals(false, $session[0]['overlay']);
        $I->assertEquals(false, $session[0]['title']);
        $I->assertEquals(false, $session[0]['important']);
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
     * @param Notifier $notice
     */
    public function accordanceDataAndReturnTypeDataInStorages(FunctionalTester $I, Notifier $notice)
    {

        $notice->success('text0')->session();
        $notice->danger('text1')->session();

        $notice->success('text0')->json();
        $notice->danger('text1')->json();

        $notice->success('text0')->html();
        $notice->danger('text1')->html();

        $I->assertJson($notice->json());
        $I->assertIsString($notice->html());

        $I->assertCount(2, $notice->storages['json']->store);
        $I->assertCount(2, $notice->storages['html']->store);
        $I->assertCount(2, $notice->storages['session']->store);

        $I->assertEquals($notice->storages['html']->store[0], $notice->storages['json']->store[0]);
        $I->assertEquals($notice->storages['html']->store[1], $notice->storages['json']->store[1]);
        $I->assertEquals($notice->storages['json']->store[0], $notice->storages['session']->store[0]);
        $I->assertEquals($notice->storages['json']->store[1], $notice->storages['session']->store[1]);
    }

    /**
     *
     * @param FunctionalTester $I
     */
    public function ifThereIsNoMessageText(FunctionalTester $I)
    {
        \notice('', 'success');
        $message = \session()->get('notice');

        $I->assertEquals('success', $message['0']['message']);

//        $I->expectThrowable(new Exception('Sending a blank notification'), function() {
//            \notice('', 'success');
//        });
    }
}
