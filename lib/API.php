<?php
/**
 * Implementation of the `phing\smartling\API` trait.
 */
namespace phing\smartling;

use Smartling\AuthApi\AuthTokenProvider;
use Smartling\File\FileApi;

/**
 * Provides common properties and methods for the [Phing](https://www.phing.info) tasks related to the [Smartling](https://www.smartling.com) service.
 */
trait API {

  /**
   * @var string The token to authenticate all API requests.
   */
  private $accessToken = '';

  /**
   * @var string The project identifier.
   */
  private $projectId = '';

  /**
   * @var string The user identifier.
   */
  private $userId = '';

  /**
   * Gets the Smartling access token.
   * @return string The current Smartling access token.
   */
  public function getAccessToken(): string {
    return $this->accessToken;
  }

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
   * Sets the Smartling access token.
   * @param string $value The new Smartling access token.
   */
  public function setAccessToken(string $value) {
    $this->accessToken = $value;
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
   * Creates an authentication provider.
   * @return AuthTokenProvider The newly created instance.
   */
  protected function createAuthProvider(): AuthTokenProvider {
    return AuthTokenProvider::create($this->getUserId(), $this->getAccessToken());
  }

  /**
   * Creates a File API provider.
   * @return FileApi The newly created instance.
   */
  protected function createFileApi(): FileApi {
    return FileApi::create($this->createAuthProvider(), $this->getProjectId());
  }
}