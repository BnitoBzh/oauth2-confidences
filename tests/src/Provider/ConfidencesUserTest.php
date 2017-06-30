<?php

namespace Confidences\OAuth2\Client\Test\Provider;

use Confidences\OAuth2\Client\Provider\ConfidencesUser;

/**
 * Class ConfidencesUserTest
 *
 * @package Confidences\OAuth2\Client\Test\Provider
 * @author  Paul Thebaud
 *
 * @covers  \Confidences\OAuth2\Client\Provider\ConfidencesUser
 */
class ConfidencesUserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfidencesUser
     */
    protected $user;

    /**
     * @var array
     */
    protected $data;

    protected function setUp()
    {
        $this->data = [
            'id'        => 1,
            'lastname'  => 'lastname',
            'firstname' => 'firstname',
            'email'     => 'email',
            'company'   => [
                'name' => 'company_name'
            ]
        ];

        $this->user = new ConfidencesUser($this->data);
    }

    /**
     * @covers  \Confidences\OAuth2\Client\Provider\ConfidencesUser::getId()
     */
    public function testGetId()
    {
        $this->assertEquals($this->data['id'], $this->user->getId());
    }

    /**
     * @covers  \Confidences\OAuth2\Client\Provider\ConfidencesUser::getFirstName()
     */
    public function testGetFirstName()
    {
        $this->assertEquals($this->data['firstname'], $this->user->getFirstName());
    }

    /**
     * @covers  \Confidences\OAuth2\Client\Provider\ConfidencesUser::getLastName()
     */
    public function testGetLastName()
    {
        $this->assertEquals($this->data['lastname'], $this->user->getLastName());
    }

    /**
     * @covers  \Confidences\OAuth2\Client\Provider\ConfidencesUser::getEmail()
     */
    public function testGetEmail()
    {
        $this->assertEquals($this->data['email'], $this->user->getEmail());
    }

    /**
     * @covers  \Confidences\OAuth2\Client\Provider\ConfidencesUser::getCompanyName()
     */
    public function testGetCompanyName()
    {
        $this->assertEquals($this->data['company']['name'], $this->user->getCompanyName());

        $user = new ConfidencesUser([]);
        $this->assertEquals(null, $user->getCompanyName());
    }

    /**
     * @covers  \Confidences\OAuth2\Client\Provider\ConfidencesUser::toArray()
     */
    public function testToArray()
    {
        $this->assertEquals($this->data, $this->user->toArray());
    }
}
