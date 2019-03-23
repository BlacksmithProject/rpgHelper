<?php
declare(strict_types=1);

namespace App\Application\Shared\Listener;

use App\Domain\Shared\Exception\DomainException;
use App\Infrastructure\Shared\Doctrine\Exception\NotFoundException;
use Assert\InvalidArgumentException;
use Assert\LazyAssertionException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ExceptionListener
{
    private const INTERNAL_ERROR = 'errors.internal';

    private $logger;
    private $translator;

    public function __construct(LoggerInterface $logger, TranslatorInterface $translator)
    {
        $this->logger = $logger;
        $this->translator = $translator;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof DomainException) {
            return $event->setResponse($this->buildJsonResponseFromDomainException($exception));
        }

        if ($exception instanceof LazyAssertionException) {
            return $event->setResponse($this->buildJsonResponseFromInvalidInput($exception));
        }

        if ($exception instanceof InvalidArgumentException) {
            return $event->setResponse($this->buildJsonResponseFromIAException($exception));
        }

        if ($exception instanceof NotFoundException) {
            return $event->setResponse($this->buildJsonResponseFromNotFoundException($exception));
        }

        return $event->setResponse($this->buildJsonResponseFromInfrastructureException($exception));
    }

    private function buildJsonResponseFromInvalidInput(LazyAssertionException $exception): JsonResponse
    {
        $response = [];

        foreach ($exception->getErrorExceptions() as $invalidArgumentException) {
            $response[$invalidArgumentException->getPropertyPath()] = $this->translator->trans(
                $invalidArgumentException->getMessage()
            );
        }

        return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function buildJsonResponseFromDomainException(DomainException $exception): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->translator->trans($exception->getMessage()),
        ], Response::HTTP_BAD_REQUEST);
    }

    private function buildJsonResponseFromIAException(InvalidArgumentException $exception): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->translator->trans($exception->getMessage()),
        ], Response::HTTP_BAD_REQUEST);
    }

    private function buildJsonResponseFromNotFoundException(NotFoundException $exception): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->translator->trans($exception->getMessage()),
        ], Response::HTTP_NOT_FOUND);
    }

    private function buildJsonResponseFromInfrastructureException(\Exception $exception): JsonResponse
    {
        $this->logger->emergency(sprintf(
            '%s: %s',
            static::class,
            $exception->getMessage()
        ));

        return new JsonResponse([
            'message' => $this->translator->trans(self::INTERNAL_ERROR),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
