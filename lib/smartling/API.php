<?php
/**
 * Implementation of the `phing\smartling\API` trait.
 */
namespace phing\smartling;
use Smartling\AuthApi\AuthTokenProvider;

/**
 * Provides common properties and methods for the [Phing](https://www.phing.info) tasks related to the [Smartling](https://www.smartling.com) service.
 */
trait API {

  /**
   * @var string The token to authenticate all API requests.
   */
  private $accessToken;

  /**
   * @var string The project identifier.
   */
  private $projectId;

  /**
   * @var string The user identifier.
   */
  private $userId;

  /**
   * Gets the Smartling access token.
   * @return string The current Smartling access token.
   */
  public function getAccessToken() {
    return $this->accessToken;
  }

  /**
   * Gets the project identifier.
   * @return string $value The current project identifier.
   */
  public function getProjectId() {
    return $this->projectId;
  }

  /**
   * Gets the user identifier.
   * @return string The current user identifier.
   */
  public function getUserId() {
    return $this->userId;
  }

  /**
   * Sets the Smartling access token.
   * @param string $value The new Smartling access token.
   */
  public function setAccessToken($value) {
    $this->accessToken = $value;
  }

  /**
   * Sets the project identifier.
   * @param string $value The new project identifier.
   */
  public function setProjectId($value) {
    $this->projectId = $value;
  }

  /**
   * Sets the user identifier.
   * @param string $value The new user identifier.
   */
  public function setUserId($value) {
    $this->userId = $value;
  }

  /**
   * Checks that the instance properties are properly initialized.
   * @return bool Whether the requirements are met.
   */
  private function checkRequirements() {
    if(!mb_strlen($this->getAccessToken())) return false;
    if(!mb_strlen($this->getProjectId())) return false;
    if(!mb_strlen($this->getUserId())) return false;
    return true;
  }

  /**
   * Creates an authentication provider.
   * @return AuthTokenProvider The newly created instance.
   */
  private function createAuthProvider() {
    return AuthTokenProvider::create($this->getUserId(), $this->getAccessToken());
  }
}
