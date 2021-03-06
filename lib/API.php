<?php
/**
 * Implementation of the `phing\smartling\API` trait.
 */
namespace phing\smartling;

use Smartling\AuthApi\{AuthTokenProvider};
use Smartling\File\{FileApi};

/**
 * Provides common properties and methods for the [Phing](https://www.phing.info) tasks related to the [Smartling](https://www.smartling.com) service.
 */
trait API {

  /**
   * @var string The project identifier.
   */
  private $projectId = '';

  /**
   * @var string The user identifier.
   */
  private $userId = '';

  /**
   * @var string The user secret.
   */
  private $userSecret = '';

  /**
   * Gets the project identifier.
   * @return string $value The current project identifier.
   */
  public function getProjectId(): string {
    return $this->projectId;
  }

  /**
   * Gets the user identifier.
   * @return string The current user identifier.
   */
  public function getUserId(): string {
    return $this->userId;
  }

  /**
   * Gets the user secret.
   * @return string The current user secret.
   */
  public function getUserSecret(): string {
    return $this->userSecret;
  }

  /**
   * Sets the project identifier.
   * @param string $value The new project identifier.
   */
  public function setProjectId(string $value) {
    $this->projectId = $value;
  }

  /**
   * Sets the user identifier.
   * @param string $value The new user identifier.
   */
  public function setUserId(string $value) {
    $this->userId = $value;
  }

  /**
   * Sets the user secret.
   * @param string $value The new user secret.
   */
  public function setUserSecret(string $value) {
    $this->userSecret = $value;
  }

  /**
   * Creates an authentication token provider.
   * @return AuthTokenProvider The newly created instance.
   */
  protected function createAuthTokenProvider(): AuthTokenProvider {
    return AuthTokenProvider::create($this->getUserId(), $this->getUserSecret());
  }

  /**
   * Creates a File API provider.
   * @return FileApi The newly created instance.
   */
  protected function createFileAPI(): FileApi {
    return FileApi::create($this->createAuthTokenProvider(), $this->getProjectId());
  }
}
