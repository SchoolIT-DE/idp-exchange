<?php

namespace SchoolIT\IdpExchange;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use SchoolIT\IdpExchange\Request\Builder\UpdatedUsersRequestBuilder;
use SchoolIT\IdpExchange\Request\Builder\UserRequestBuilder;
use SchoolIT\IdpExchange\Request\Builder\UsersRequestBuilder;
use SchoolIT\IdpExchange\Response\UpdatedUsersResponse;
use SchoolIT\IdpExchange\Response\UserResponse;
use SchoolIT\IdpExchange\Response\UsersResponse;

class Client {
    private const TOKEN_HEADER = 'X-Token';
    private const UPDATED_USERS_ENDPOINT = '/exchange/updated_users';
    private const USERS_ENDPOINT = '/exchange/users';
    private const USER_ENDPOINT = '/exchange/user';

    private $endpoint;
    private $token;
    private $guzzle;
    private $serializer;
    private $logger;

    public function __construct(string $endpoint, string $token, GuzzleClient $guzzle, Serializer $serializer, LoggerInterface $logger = null) {
        $this->endpoint = $endpoint;
        $this->token = $token;
        $this->guzzle = $guzzle;
        $this->serializer = $serializer;
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * @param $request
     * @param string $endpoint
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws ClientException
     * @throws GuzzleException
     */
    private function request($request, string $endpoint) {
        $context = (new SerializationContext())
            ->setSerializeNull(true);

        $jsonBody = $this->serializer->serialize($request, 'json', $context);

        $response = $this->guzzle->request('POST', $this->getEndpointFor($endpoint), [
            'headers' => [
                static::TOKEN_HEADER => $this->token
            ],
            'accept' => 'application/json',
            'body' => $jsonBody
        ]);

        if($response->getStatusCode() !== 200) {
            $this->logger->debug(sprintf('Request failed with response code %d', $response->getStatusCode()), [
                'response' => $response->getBody()->getContents()
            ]);

            throw new ClientException(sprintf('Request failed with response code %d', $response->getStatusCode()));
        }

        return $response;
    }

    /**
     * @param string $json
     * @param string $type
     * @return array|\JMS\Serializer\scalar|mixed|object
     */
    private function deserialize(string $json, string $type) {
        $context = new DeserializationContext();

        $object = $this->serializer->deserialize($json, $type, 'json', $context);
        return $object;
    }

    private function getEndpointFor(string $endpoint): string {
        return sprintf('%s%s', $this->endpoint, $endpoint);
    }

    /**
     * @param string[] $users
     * @param \DateTime $since
     * @return UpdatedUsersResponse
     * @throws ClientException
     */
    public function getUpdatedUsers(array $users, \DateTime $since): UpdatedUsersResponse {
        $this->logger->debug('getUpdatedUsers() started');

        try {
            $request = (new UpdatedUsersRequestBuilder())
                ->addUsers($users)
                ->since($since)
                ->build();

            $response = $this->request($request, static::UPDATED_USERS_ENDPOINT);

            return $this->deserialize($response->getBody()->getContents(), UpdatedUsersResponse::class);
        } catch (GuzzleException $e) {
            $this->logger->error('Request failed with exception', [
                'exception' => $e
            ]);

            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        } finally {
            $this->logger->debug('getUpdatedUsers() finished');
        }
    }

    /**
     * @param string[] $users
     * @return UsersResponse
     * @throws ClientException
     */
    public function getUsers(array $users): UsersResponse {
        $this->logger->debug('getUsers() started');

        try {
            $request = (new UsersRequestBuilder())
                ->addUsers($users)
                ->build();

            $response = $this->request($request, static::USERS_ENDPOINT);

            return $this->deserialize($response->getBody()->getContents(), UsersResponse::class);
        } catch (GuzzleException $e) {
            $this->logger->error('Request failed with exception', [
                'exception' => $e
            ]);

            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        } finally {
            $this->logger->debug('getUsers() finished');
        }
    }

    /**
     * @param string $username
     * @return UserResponse
     * @throws ClientException
     */
    public function getUser(string $username): UserResponse {
        $this->logger->debug('getUser() started');

        try {
            $request = (new UserRequestBuilder())
                ->setUsername($username)
                ->build();

            $response = $this->request($request, static::USER_ENDPOINT);

            return $this->deserialize($response->getBody()->getContents(), UserResponse::class);
        } catch (GuzzleException $e) {
            $this->logger->error('Request failed with exception', [
                'exception' => $e
            ]);

            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        } finally {
            $this->logger->debug('getUser() finished');
        }
    }
}