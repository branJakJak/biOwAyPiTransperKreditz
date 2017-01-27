<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/27/17
 * Time: 10:29 PM
 */

class TopUpFormTest  extends CTestCase{

    public function test_topup_form_refresh_credits_used()
    {
        /*create test model*/
        $testModel = new RemoteDataCache();
        $testModel->main_user = 'test';
        $testModel->main_pass = 'test';
        $testModel->sub_user = 'test';
        $testModel->sub_pass = 'test';
        $testModel->is_active = true;
        $testModel->exact_balance = 10;
        $testModel->last_balance_since_topup= 20;
        $this->assertTrue($testModel->save(),CHtml::errorSummary($testModel));
        $topupform = new TopupForm();
        $topupform->refreshCreditsUsed();
        $testModel = RemoteDataCache::model()->findByPk($testModel->id);
        $this->assertNotNull($testModel->accumulating_credits_used, 'Accumulating credits used must not be empty');
        $this->assertEquals(10, intval($testModel->accumulating_credits_used), 'Accumulating should be updated be equal to zero');



        //simulate balance has changed , there are used credits
        $testModel->exact_balance = 15;
        $testModel->last_balance_since_topup = 15;
        $testModel->update();// there should be new exact balance
        $this->assertEquals($testModel->last_balance_since_topup, 15);
        $this->assertEquals($testModel->exact_balance, 15);

        $topupform->refreshCreditsUsed();
        $testModel = RemoteDataCache::model()->findByPk($testModel->id);
        $this->assertNotEquals(0, intval($testModel->accumulating_credits_used), 'Accumulating should be updated and not equal to zero');
        $this->assertEquals(10, intval($testModel->accumulating_credits_used), 'Accumulating should be updated and not equal to zero');

        //the balance updated
        $testModel = RemoteDataCache::model()->findByPk($testModel->id);        
        $testModel->exact_balance = 10;
        $testModel->last_balance_since_topup = 15;
        $testModel->save();
        $topupform->refreshCreditsUsed();        
        $testModel = RemoteDataCache::model()->findByPk($testModel->id);                
        $this->assertEquals(15, intval($testModel->accumulating_credits_used), 'Accumulating should be updated and not equal to zero');

        // $testModel->delete();
    }
}