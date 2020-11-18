<?php

namespace AestronSdk\Exception;

/**
 * Class ErrorCode
 *
 * @package AestronSdk\Exception
 */
class ErrorCode
{
    /**
     * Invalid AccessKey
     */
    const INVALID_ACCESS_KEY = 'SDK.InvalidAccessKey';

    /**
     * Host Not Found
     */
    const HOST_NOT_FOUND = 'SDK.HostNotFound';

    /**
     * Server Unreachable
     */
    const SERVER_UNREACHABLE = 'SDK.ServerUnreachable';

    /**
     * Invalid Argument
     */
    const INVALID_ARGUMENT = 'SDK.InvalidArgument';

    /**
     * Invalid AccessKey
     */
    const INVALID_TOKEN = 'SDK.InvalidAccessKey';

    /**
     * Service Unknown Error
     */
    const SERVICE_UNKNOWN_ERROR = 'SDK.UnknownError';

    /**
     * Response Empty
     */
    const RESPONSE_EMPTY = 'The response is empty';
}
