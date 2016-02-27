<?php

use FinanCalc\Utils\Strings;

/**
 * Class StringTest
 */
class StringTest extends PHPUnit_Framework_TestCase
{
    public function testNonExistentLocale()
    {
        $this->assertNull(Strings::getString('message_incompatible_types', 'non_existent_locale'));
    }

    public function testNonExistentIdentifier()
    {
        $this->assertNull(Strings::getString('non_existent_identifier'));
        $this->assertNull(Strings::getFormattedString('non_existent_identifier', null));
    }

    public function testGetString()
    {
        $this->assertEquals(
            'The value has to be of the type %s, but currently is of the type %s instead.',
            Strings::getString('message_incompatible_types')
        );

        $this->assertEquals(
            'The value has to be of the type goodType, but currently is of the type badType instead.',
            Strings::getFormattedString('message_incompatible_types', null, 'goodType', 'badType')
        );
    }
}
