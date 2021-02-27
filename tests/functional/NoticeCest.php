<?php

namespace Tests\functional;

use Codeception\Example;
use FunctionalTester;
use Worfect\Notice\BaseStorage;
use Worfect\Notice\Notice;
use Worfect\Notice\Notifier;


class NoticeCest
{

    /**
     * @var Notifier
     */
    protected $notifier;

    protected function _inject(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

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

        BaseStorage::removeStores();
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

        BaseStorage::removeStores();
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
     * @param $source
     * @param $message
     * @param $level
     * @param $overlay
     * @param $title
     * @param $important
     */
    protected function check(FunctionalTester $I, $source, $message, $level, $overlay, $title, $important)
    {
        if(is_string($source)){
            $I->assertStringContainsString($message, $message);
            $I->assertStringContainsString("notice-message alert alert-$level", $source);
            if($overlay == true){
                $I->assertStringContainsString(
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>', $source);
            }
            if($title == true){
                $I->assertStringContainsString($title, $source);
            }
            if($important == true){
                $I->assertStringContainsString(
                    'alert-important', $source);
            }
        }else{
            $I->assertEquals($message, $source['message']);
            $I->assertEquals($level, $source['level']);
            $I->assertEquals($overlay, $source['overlay']);
            $I->assertEquals($title, $source['title']);
            $I->assertEquals($important, $source['important']);
        }
    }

    /**
     *
     * @param FunctionalTester $I
     */
    public function json(FunctionalTester $I)
    {
        $this->notifier->info('test0')->overlay('title0')->json();
        $this->notifier->danger('test1')->important()->json();
        $this->notifier->success('test2')->important()->overlay('title2')->json();
        $json = $this->notifier->warning('test3')->overlay('title3')->important()->json();

        $I->assertJson($json);

        $arr = json_decode($json, true);
        $I->assertCount(4, $arr);

        $this->check($I, $arr[0],'test0', 'info',true, 'title0', false);
        $this->check($I, $arr[1],'test1', 'danger',false, false, true);
        $this->check($I, $arr[2],'test2', 'success',true, 'title2', false);
        $this->check($I, $arr[3],'test3', 'warning',false, false, true);
    }

    /**
     *
     * @param FunctionalTester $I
     */
    public function session(FunctionalTester $I)
    {
        $this->notifier->info('test0')->overlay('title0')->session();
        $this->notifier->danger('test1')->important()->session();
        $this->notifier->success('test2')->important()->overlay('title2')->session();
        $this->notifier->warning('test3')->overlay('title3')->important()->session();

        $session = session()->get('notice');

        $I->assertCount(4, $session);

        $this->check($I, $session[0],'test0', 'info',true, 'title0', false);
        $this->check($I, $session[1],'test1', 'danger',false, false, true);
        $this->check($I, $session[2],'test2', 'success',true, 'title2', false);
        $this->check($I, $session[3],'test3', 'warning',false, false, true);
    }

    /**
     *
     * @param FunctionalTester $I
     */
    public function html(FunctionalTester $I)
    {
        $html = $this->notifier->info('test0')->overlay('title0')->html();
        $this->check($I, $html,'test0', 'info',true, 'title0', false);
        BaseStorage::removeStores();

        $html = $this->notifier->danger('test1')->important()->html();
        $this->check($I, $html,'test1', 'danger',false, false, true);
        BaseStorage::removeStores();

        $html = $this->notifier->success('test2')->important()->overlay('title2')->html();
        $this->check($I, $html,'test2', 'success',true, 'title2', false);
        BaseStorage::removeStores();

        $html = $html = $this->notifier->warning('test3')->overlay('title3')->important()->html();
        $this->check($I, $html,'test3', 'warning',false, false, true);
    }
}
