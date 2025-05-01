<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Throwable;

class BaseException extends Exception
{
    protected int $status_code;

    protected ?array $errors;

    /**
     * Standard exception object
     */
    public function __construct(
        ?string $message = null,
        int $status_code = Response::HTTP_BAD_REQUEST,
        ?array $errors = [],
        ?Throwable $previous = null
    ) {
        $translated_message = $message ? __($message) : __('exceptions.default');
        $this->status_code = $status_code;
        $this->errors = $errors;

        parent::__construct($translated_message, $status_code, $previous);
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }
}
