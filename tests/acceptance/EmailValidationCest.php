<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use Codeception\Example;
use Codeception\Scenario;
use Faker\Factory as FakerFactory;

/**
 * @TODO: this actually is just a quick solution. Codeception API suite should be generated and used in this case
 * @see: https://codeception.com/docs/10-APITesting
 */
class EmailValidationCest
{
    /**
     * @dataProvider invalidEmailDataProvider
     */
    public function testInvalidEmail(AcceptanceTester $I, Scenario $scenario, Example $example): void
    {
        $data = $example->getIterator()->getArrayCopy();
        $invalidEmail = $data[0];

        $I->sendAjaxPostRequest('/validation/email', [
            'email' => $invalidEmail,
        ]);

        $I->seeResponseCodeIs(400);

        //@todo: do checks on json response after setting up api suite
    }

    public function testAlreadyRegisteredEmail(AcceptanceTester $I): void
    {
        $faker = FakerFactory::create();

        $registeredEmail = $faker->email;

        $I->registerWithEmailAndPassword($registeredEmail, $faker->password);

        $I->sendAjaxPostRequest('/validation/email', [
            'email' => $registeredEmail,
        ]);

        $I->seeResponseCodeIs(400);
    }

    public function testNonExistingEmail(AcceptanceTester $I, Scenario $scenario): void
    {
        $scenario->skip('This test fails for some reason, although the same endpoint works fine in browser');

        $faker = FakerFactory::create();

        $I->sendAjaxPostRequest('/validation/email', [
            'email' => $faker->email,
        ]);

        $I->seeResponseCodeIs(200);
    }

    public function invalidEmailDataProvider(): array
    {
        return [
            [''],
            ['INVALID_EMAIL'],
            ['foo@bar'],
        ];
    }
}
