<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use Faker\Factory as FakerFactory;

class FeedCest
{
    public function testFeedNotAccesibleWithoutLogin(AcceptanceTester $I): void
    {
        $I->wantTo('Access feed without login not possible');

        $I->amOnPage('/feed');
        $I->dontSee('Welcome to feed');

        $I->see('Please sign in');
    }

    public function testFeedIsVisible(AcceptanceTester $I): void
    {
        $I->wantTo('Test feed is visible');

        $faker = FakerFactory::create();

        $email = $faker->email;
        $password = $faker->password;

        $I->registerWithEmailAndPassword($email, $password);
        $I->loginWithEmailAndPassword($email, $password);

        $I->amOnPage('/feed');
        $I->seeResponseCodeIs(200);

        $I->see('Welcome to Feed');
        $I->see('Common words');
    }
}
