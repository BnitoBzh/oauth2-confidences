<?php

namespace Confidences\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Class ConfidencesUser
 *      Provide a Confidences user implementation
 *
 * @package Confidences\OAuth2\Client\Provider
 * @author  Paul Thebaud
 */
class ConfidencesUser implements ResourceOwnerInterface
{
    /**
     * The user information
     *
     * @var array $response
     */
    protected $response;

    /**
     * ConfidencesUser constructor
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * Get id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->response['id'];
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->response['firstname'];
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->response['lastname'];
    }

    /**
     * Get email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->response['email'];
    }

    /**
     * Get company name
     *
     * @return string|null
     */
    public function getCompanyName()
    {
        if (! empty($this->response['company'])) {
            return $this->response['company']['name'];
        }
        return null;
    }

    /**
     * Get company features
     *
     * @return array
     */
    public function getCompanyFeatures()
    {
        if (! empty($this->response['company'])) {
            return $this->response['company']['features'];
        }
        return [];
    }

    /**
     * Get user data as an array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
