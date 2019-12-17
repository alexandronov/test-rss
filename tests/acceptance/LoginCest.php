<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use Faker\Factory as FakerFactory;

class LoginCest
{
    public function testLoginForm(AcceptanceTester $I): void
    {
        $I->wantTo('Login form is displayed');

        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);

        $I->see('Please sign in');

        $I->see('Email', 'label');
        $I->seeElement('input[name=email]');

        $I->see('Password', 'label');
        $I->seeElement('input[type=password]');

        $I->see('Sign in', 'button[type=submit]');
    }

    public function testLoginWithNonExistingEmail(AcceptanceTester $I): void
    {
        $I->wantTo('Cannot login with non existing email');

        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);

        $faker = FakerFactory::create();

        $I->loginWithEmailAndPassword($faker->email, $faker->password);

        $I->see('Email could not be found.');
    }

    public function testRegisteredUserCannotLoginWithIncorrectPassword(AcceptanceTester $I): void
    {
        $I->wantTo('Cannot login with incorrect password');

        $faker = FakerFactory::create();

        $email = $faker->email;

        $I->registerWithEmailAndPassword($email, $faker->password);

        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);

        $I->loginWithEmailAndPassword($email, 'totally_wrong_password');

        $I->see('Invalid credentials.');
    }

    public function testRegisteredUserCanLogin(AcceptanceTester $I): void
    {
        $I->wantTo('Login with freshly registered user');

        $faker = FakerFactory::create();

        $email = $faker->email;
        $password = $faker->password;

        $I->registerWithEmailAndPassword($email, $password);

        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);

        $I->loginWithEmailAndPassword($email, $password);

        $I->amOnPage('/feed');
        $I->seeResponseCodeIs(200);
        $I->see('Welcome to Feed');
    }

    public function testCannotAccessFeedWithoutLoggingIn(AcceptanceTester $I): void
    {
        $I->wantTo('Feed is not accessible without login');

        $I->amOnPage('/feed');

        $I->dontSee('Welcome to Feed');
        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);
        $I->see('Please sign in');
    }
}
